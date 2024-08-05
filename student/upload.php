<?php
require("../config/db_connection.php");
session_start();

$id = 0;
$sql = mysqli_query($conn, "SELECT document_id from documents ORDER BY document_id DESC LIMIT 1");
$row = mysqli_fetch_assoc($sql);
$documentId = $row['document_id'];
$id = $documentId + 1;

if (isset($_POST['submit']) && isset($_FILES)) {
    require __DIR__ . '/assets/vendor/autoload.php';
    $target_dir = "../assets/documents/";
    $uploadOk = 1;
    $FileType = strtolower(pathinfo($_FILES["attachment"]["name"], PATHINFO_EXTENSION));

    // Constructing the new filename with the document ID
    $newFileName = $id . '_' . basename($_FILES["attachment"]["name"]); // Use document ID + filename
    $dbFileName = basename($_FILES["attachment"]["name"]); // Use document ID + filename

    $target_file = $target_dir . $newFileName;
    $db_file = $target_dir . $dbFileName;

    // Check file size
    if ($_FILES["attachment"]["size"] > 5000000) {
        header('HTTP/1.0 403 Forbidden');
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if ($FileType != "pdf" && $FileType != "png" && $FileType != "jpg") {
        header('HTTP/1.0 403 Forbidden');
        echo "Sorry, please upload a pdf file";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
            uploadToApi($target_file, $db_file, $id);
        } else {
            header('HTTP/1.0 403 Forbidden');
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    header('HTTP/1.0 403 Forbidden');
    echo "Sorry, please upload a pdf file";
}

function uploadToApi($target_file, $db_file, $id)
{
    require __DIR__ . '/assets/vendor/autoload.php';
    $fileData = fopen($target_file, 'r');
    $client = new \GuzzleHttp\Client();

    try {
        $r = $client->request('POST', 'https://api.ocr.space/parse/image', [
            'headers' => ['apiKey' => 'helloworld'],
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $fileData
                ]
            ]
        ], ['file' => $fileData]);

        $response = json_decode($r->getBody(), true);

        if (isset($response['ErrorMessage'])) {
            // Error occurred during OCR processing
            header('HTTP/1.0 400 Forbidden');
            echo $response['ErrorMessage'];
        } else {
            // OCR processing successful
            $formType = getFormType($response['ParsedResults'][0]['ParsedText']);
            if ($formType !== 'Unknown Type') {
                // Store the information in your database or perform other actions
                saveToDatabase(basename($db_file), $formType, $_SESSION['id'], $id);
            } else {
                header('HTTP/1.0 400 Forbidden');
                echo "Form type not recognized.";
            }
        }
    } catch (Exception $err) {
        header('HTTP/1.0 403 Forbidden');
        echo $err->getMessage();
    }
}

function getFormType($parsedText)
{
    // Map keywords to their corresponding form types
    $formTypeMap = [
        'CONCEPT PAPER ADVISER ENDORSEMENT FORM' => 'Thesis/Dissertation Concept Paper Adviser Endorsement Form',
        'ADVISING CONTRACT' => 'Thesis/Dissertation Advising Contract',
        'CONSULTATION/MONITORING FORM' => 'Thesis/Dissertation Consultation/Monitoring Form',
        'ADVISER APPOINTMENT AND ACKNOWLEDGEMENT FORM' => 'Thesis/Dissertation Adviser Appointment and Acknowledgement Form',
        'Confidentiality Non-Disclosure Agreement' => 'Thesis/Dissertation Confidentiality Non-Disclosure Agreement',
        'COMMITTEE APPOINTMENT AND ACCEPTANCE FORM' => 'Thesis/Dissertation Committee Appointment and Acceptance Form',
        'PROPOSAL DEFENSE ENDORSEMENT FORM' => 'Thesis/Dissertation Proposal Defense Endorsement Form',
        'PROPOSAL DEFENSE EVALUATION SHEET' => 'Thesis/Dissertation Proposal Defense Evaluation Sheet',
        'PRE-FINAL ENDORSEMENT FORM' => 'Thesis/Dissertation Pre-Final Endorsement Form',
        'PREFINAL EVALUATION SHEET' => 'Thesis/Dissertation Pre-Final Evaluation Sheet',
        'PANEL ON ORAL DEFENSE APPOINTMENT AND ACCEPTANCE FORM' => 'Thesis/Dissertation Panel on Oral Defense Appointment and Acceptance Form',
        'FINAL DEFENSE EVALUATION SHEET' => 'Thesis/Dissertation Final Defense Evaluation Sheet',
        'Final Endorsement Form' => 'Thesis/Dissertation Final Endorsement Form',
        'ETHICS REVIEW APPLICATION FORM' => 'Ethics Review Application Form',
        'ETHICS REVIEW APPROVAL AND RECOMMENDATION FORM' => 'Ethics Review Approval and Recommendation Form',
    ];

    // Check if any keyword exists in the parsed text
    foreach ($formTypeMap as $keyword => $formType) {
        if (stripos($parsedText, $keyword) !== false) {
            return $formType;
        }
    }

    // If no matching keyword found, return 'Unknown Type'
    return 'Unknown Type';
}

function saveToDatabase($fileName, $formType, $ownerId, $id)
{
    require("../config/db_connection.php");
    $uploadTime = date('Y-m-d H:i:s');
    notifyAdmin($id, $conn);
    $sql = "INSERT INTO documents (document, document_type, owner_id, uploaded_at) VALUES ('$fileName', '$formType', '$ownerId', '$uploadTime')";

    if (mysqli_query($conn, $sql)) {
        // Query executed successfully
        header("Location: dashboard.php");
    } else {
        // Handle query error
        header('HTTP/1.0 500 Internal Server Error');
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

function notifyAdmin($id, $conn){
    $apiKey = '590c6c4421031d422bb2b442a33d76b0';
    $adminNumber = mysqli_query($conn, "SELECT contactNumber FROM users WHERE user_level = 'Admin'");
    while($row = mysqli_fetch_assoc($adminNumber)){
        $phoneNumber = $row['contactNumber'];
        $message = 'From PUP GSREO! The document number '.$id.' is in need of a signatory.';
        $senderName = 'PUPGSREO';

        $ch = curl_init();
        $parameters = array(
            'apikey' => $apiKey,
            'number' => $phoneNumber,
            'message' => $message,
            'sendername' => $senderName
        );
        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
    }
}

?>
