<?php
require_once("../config/db_connection.php");
// Include FPDF autoload file or class
require_once('vendor/fpdf/fpdf.php');

// Include FPDI autoload file
require_once('vendor/FPDI/src/autoload.php');

session_start();

use setasign\Fpdi\Fpdi;

// Sanitize inputs
$document_id = mysqli_real_escape_string($conn, $_POST['document_id']);
$signatoryIds = array_map('intval', $_POST['signatoryIds']); // Sanitize signatory IDs

// Example of inserting data into a database for each signatory ID
foreach ($signatoryIds as $signatoryId) {
    // Insert into assign_signatory table
    $sql = "INSERT INTO assign_signatory (document_id, signatory_id, assigned_at) 
            VALUES ('$document_id', '$signatoryId', NOW())";
    mysqli_query($conn, $sql); // Execute the query (consider using prepared statements)
    notifyUser($signatoryId, $conn);
    // Insert into document_status table
    $expiration = date('Y-m-d H:i:s', strtotime('+7 days')); // Calculate expiration time
    $stat = "INSERT INTO document_status (document_id, assign_id, signatory_id, approval_status, approval_time, expiration) 
             VALUES ('$document_id', LAST_INSERT_ID(), '$signatoryId', 'Pending', NOW(), '$expiration')";
    mysqli_query($conn, $stat); // Execute the query (consider using prepared statements)

    // Insert into notifications table
    $notification = "INSERT INTO notifications (recipient_id, document_id, assign_id, created_at, is_read) 
                     VALUES ('$signatoryId', '$document_id', LAST_INSERT_ID(), NOW(), 0)";
    mysqli_query($conn, $notification); // Execute the query (consider using prepared statements)
}


function notifyUser($id, $conn){
    $apiKey = '590c6c4421031d422bb2b442a33d76b0';
    $signatoryNumber = mysqli_query($conn, "SELECT contactNumber FROM users WHERE user_id = '$id'");
    while($row = mysqli_fetch_assoc($signatoryNumber)){
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


// Fetching and copying signature images
foreach ($signatoryIds as $signatoryId) {
    // Query to fetch the signature filename from the users table
    $query = "SELECT name, signature FROM users WHERE user_id = '$signatoryId'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $signatureFilename = $row['signature'];
        $sourcePath = "upload_folder/$signatureFilename"; // Path to the signature image
        $destinationPath = "documents_with_signatures/$signatureFilename"; // Destination folder

        // Copy the signature image to the destination folder
        if (copy($sourcePath, $destinationPath)) {
            echo "Signature for user ID $signatoryId copied successfully.<br>";
        } else {
            echo "Error copying signature for user ID $signatoryId.<br>";
        }
    } else {
        echo "No signature found for user ID $signatoryId.<br>";
    }
}

$queryLastDocumentType = "SELECT u.name, u.signature, d.document_type 
                          FROM users u 
                          JOIN assign_signatory a ON u.user_id = a.signatory_id 
                          JOIN documents d ON d.document_id = a.document_id 
                          WHERE a.signatory_id = '$signatoryId'
                          ORDER BY a.assign_id DESC LIMIT 1";

$resultLastDocumentType = mysqli_query($conn, $queryLastDocumentType);
if ($rowLastDocumentType = mysqli_fetch_assoc($resultLastDocumentType)) {
    $documentType = $rowLastDocumentType['document_type'];// Get the document type
} 





// Query to fetch the document filename from the documents table
$queryDoc = "SELECT document_id, document FROM documents WHERE document_id = '$document_id'";
$resultDoc = mysqli_query($conn, $queryDoc);

if ($rowDoc = mysqli_fetch_assoc($resultDoc)) {
    $documentId = $rowDoc['document_id'];
    $documentFilename = $documentId . '_' . $rowDoc['document']; // Construct the document filename
}

    // Retrieve PDF file and initiate FPDI
    $pdf = new FPDI();

    // Disable auto page rotation
    $pdf->setAutoPageBreak(false);

$extension = strtolower(pathinfo($documentFilename, PATHINFO_EXTENSION));


if ($extension == 'pdf') {

    // Set the source file for FPDI
    $pdf->setSourceFile("../assets/documents/$documentFilename");

    // Loop through all pages and import them without changing orientation
    $numPages = $pdf->setSourceFile("../assets/documents/$documentFilename");
    for ($pageNo = 1; $pageNo <= $numPages; $pageNo++) {
        $templateId = $pdf->importPage($pageNo);
        $size = $pdf->getTemplateSize($templateId);
        $width = $size['width'];
        $height = $size['height'];

        // Set page size based on the original orientation
        if ($width > $height) {
            $pdf->AddPage('L', array($width, $height));
        } else {
            $pdf->AddPage('P', array($width, $height));
        }

        // Use the template without changing orientation
        $pdf->useTemplate($templateId);

        // Add document ID to the top right of the first page
        if ($pageNo === 1) {
            $pdf->SetFont('Arial', 'I', 8);
            $pdf->SetXY(170, 2); // Adjust coordinates as needed
            $pdf->Cell(30, 10, 'Document ID: ' . $document_id, 0, 0, 'R');
        }
    }

    // Define arrays for x and y coordinates for each signatory's signature and name  
    //FORM 1
    if ($documentType == "Thesis/Dissertation Concept Paper Adviser Endorsement Form") {
        $xSignatureCoordinates = [120, 100]; // X coordinates for each signatory's signature    
        $ySignatureCoordinates = [175, 222]; // Y coordinates for each signatory's signature
        $xNameCoordinates = [130, 100]; // X coordinates for each signatory's name
        $yNameCoordinates = [194, 223]; // Y coordinates for each signatory's name
        //DONE
    } 
    //FORM 2
    elseif ($documentType == "Thesis/Dissertation Advising Contract") {
        $xSignatureCoordinates = [130, 40, 130]; // Different X coordinates for type2           
        $ySignatureCoordinates = [148, 186, 186]; // Different Y coordinates for type2
        $xNameCoordinates = [130, 40, 130]; // Different X coordinates for type2
        $yNameCoordinates = [168, 205,205]; // Different Y coordinates for type2
        //DONE

    }
    //FORM 3
    elseif ($documentType == "Thesis/Dissertation Consultation/Monitoring Form") {
        $xSignatureCoordinates = [245, 120]; // Different X coordinates for type2
        $ySignatureCoordinates = [115, 250]; // Different Y coordinates for type2
        $xNameCoordinates = [160, 120]; // Different X coordinates for type2
        $yNameCoordinates = [220, 253]; // Different Y coordinates for type2

        //DONE
    }
    //FORM 4
    elseif ($documentType == "Thesis/Dissertation Adviser Appointment and Acknowledgement Form") {
        $xSignatureCoordinates = [38, 123]; // Different X coordinates for type2
        $ySignatureCoordinates = [133, 227]; // Different Y coordinates for type2
        $xNameCoordinates = [35, 130]; // Different X coordinates for type2
        $yNameCoordinates = [154, 244]; // Different Y coordinates for type2
        //DONE
    }
    //FORM 5
    elseif ($documentType == "Thesis/Dissertation Confidentiality Non-Disclosure Agreement") {
    // Assume the first two pages are not relevant for signatures and names
    $pageToPlaceSignatures = 3; // Page number to place signatures and names

    // Check if the current page is the page to place signatures and names
    if ($pdf->PageNo() >= $pageToPlaceSignatures) {
        // X coordinates for signature and name (assuming they are aligned horizontally)
        $xSignatureCoordinates = [45, 123]; // X coordinates for each signatory's signature
        $ySignatureCoordinates = [208, 208]; // Y coordinates for each signatory's signature
        $xNameCoordinates = [45, 137]; // X coordinates for each signatory's name
        $yNameCoordinates = [203, 203]; // Y coordinates for each signatory's name
    }
    //DONE
}

   //FORM 6
    elseif ($documentType == "Thesis/Dissertation Committee Appointment and Acceptance Form") { 
    $xSignatureCoordinates = [130, 130, 130, 50, 135]; // X coordinates for each signatory's signature
    $ySignatureCoordinates = [133, 143, 153, 190, 190]; // Y coordinates for each signatory's signature
    $xNameCoordinates = [65, 65, 65, 50, 135]; // X coordinates for each signatory's name
    $yNameCoordinates = [143, 153, 163, 210, 210]; // Y coordinates for each signatory's name
    //DONE
    }
    //FORM 7
    elseif ($documentType == "Thesis/Dissertation Proposal Defense Endorsement Form") {
    $xSignatureCoordinates = [130, 130, 130, 50, 50]; // X coordinates for each signatory's signature
    $ySignatureCoordinates = [147, 157, 167, 215, 250]; // Y coordinates for each signatory's signature
    $xNameCoordinates = [65, 65, 65, 45, 45]; // X coordinates for each signatory's name
    $yNameCoordinates = [158, 168, 178, 233, 268]; // Y coordinates for each signatory's name
    //DONE
    }
    //FORM 8
    elseif ($documentType == "Thesis/Dissertation Proposal Defense Evaluation Sheet") {
        $xSignatureCoordinates = [80]; // Different X coordinates for type2
        $ySignatureCoordinates = [250]; // Different Y coordinates for type2
        $xNameCoordinates = [80]; // Different X coordinates for type2
        $yNameCoordinates = [266]; // Different Y coordinates for type2
        //DONE
    }
    //FORM 9
    /*elseif ($documentType == "Thesis/Dissertation Final Endorsement Form") {
        $xSignatureCoordinates = [130, 130, 130, 50, 50]; // X coordinates for each signatory's signature
        $ySignatureCoordinates = [138, 148, 158, 190, 190]; // Y coordinates for each signatory's signature
        $xNameCoordinates = [65, 65, 65, 50, 135]; // X coordinates for each signatory's name
        $yNameCoordinates = [138, 148, 158, 240, 280]; // Y coordinates for each signatory's name
        //DOCUMENT TYPE SHOULD BE PRE-FINAL NOT FINAL 
    }*/
    //FORM 10
    elseif ($documentType == "Thesis/Dissertation Pre-Final Evaluation Sheet") {
        $xSignatureCoordinates = [100]; // Different X coordinates for type2
        $ySignatureCoordinates = [264]; // Different Y coordinates for type2
        $xNameCoordinates = [100]; // Different X coordinates for type2
        $yNameCoordinates = [282];// Different Y coordinates for type2
        //DONE
    }
    //FORM 11
        elseif ($documentType == "Thesis/Dissertation Panel on Oral Defense Appointment and Acceptance Form") {
        $xSignatureCoordinates = [130, 130, 130, 50, 135]; // X coordinates for each signatory's signature
        $ySignatureCoordinates = [135, 145, 155, 200, 200]; // Y coordinates for each signatory's signature
        $xNameCoordinates = [65, 65, 65, 45, 140]; // X coordinates for each signatory's name
        $yNameCoordinates = [145, 155, 165, 219, 219]; // Y coordinates for each signatory's name
    //DONE
    }
    //FORM 12
    elseif ($documentType == "Thesis/Dissertation Final Endorsement Form") {
        $xSignatureCoordinates = [130, 130, 130, 50, 50]; // X coordinates for each signatory's signature
        $ySignatureCoordinates = [135, 145, 155, 198, 230]; // Y coordinates for each signatory's signature
        $xNameCoordinates = [65, 65, 65, 45, 45]; // X coordinates for each signatory's name
        $yNameCoordinates = [145, 155, 165, 215, 249]; // Y coordinates for each signatory's name
        //DONE
    }
     elseif ($documentType == "Ethics Review Approval and Recommendation Form") {
        $xSignatureCoordinates = [85, 85, 30, 85, 150]; // X coordinates for each signatory's signature
        $ySignatureCoordinates = [105, 120, 140, 140, 140]; // Y coordinates for each signatory's signature
        $xNameCoordinates = [85, 85, 30, 85, 150]; // X coordinates for each signatory's name
        $yNameCoordinates = [120, 135, 155, 155, 155]; // Y coordinates for each signatory's name
        //DONE
    }
    else {
        // Default coordinates
        $xSignatureCoordinates = [100, 80];
        $ySignatureCoordinates = [150, 200];
        $xNameCoordinates = [110, 80];
        $yNameCoordinates = [170, 203];
    }

    // Loop through signatory IDs to insert signatures and names
    foreach ($signatoryIds as $index => $signatoryId) {
        // Fetch and insert signature image
        $query = "SELECT signature FROM users WHERE user_id = '$signatoryId'";
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            $signatureFilename = $row['signature'];
            $signaturePath = "upload_folder/$signatureFilename"; // Path to the signature image

            // Check if coordinates are defined for the current signatory
            if (isset($xSignatureCoordinates[$index]) && isset($ySignatureCoordinates[$index]) && isset($xNameCoordinates[$index]) && isset($yNameCoordinates[$index])) {
                $xSignature = $xSignatureCoordinates[$index]; // Get X coordinate for the current signatory's signature
                $ySignature = $ySignatureCoordinates[$index]; // Get Y coordinate for the current signatory's signature
                $xName = $xNameCoordinates[$index]; // Get X coordinate for the current signatory's name
                $yName = $yNameCoordinates[$index]; // Get Y coordinate for the current signatory's name

                // Insert signature image
                $pdf->Image($signaturePath, $xSignature, $ySignature, 30);

                // Add name at specified coordinates
                $userNameQuery = "SELECT name FROM users WHERE user_id = '$signatoryId'";
                $userNameResult = mysqli_query($conn, $userNameQuery);
                if ($userNameRow = mysqli_fetch_assoc($userNameResult)) {
                    $userName = $userNameRow['name'];
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Text($xName, $yName, $userName);
                }
            } else {
                echo "Coordinates not defined for signatory ID $signatoryId.<br>";
            }
        }
    }

    $pdfFilename = $_SERVER['DOCUMENT_ROOT'] . '/wdfuip/admin/signatured_documents/' . $document_id . '.pdf';
    $pdf->Output($pdfFilename, 'F');

    echo "PDF with signatures saved successfully.";
}

if($extension == 'jpg' || $extension == 'jpeg'){
    // Handle JPG background for a new PDF

        // Create a new PDF instance
        $pdf = new FPDF();

        // Add a page to the PDF
        $pdf->AddPage();

        // Set background image
        $pdf->Image("../assets/documents/$documentFilename", 0, 0, 210, 297); // Adjust width and height as needed

    if ($documentType == "Thesis/Dissertation Concept Paper Adviser Endorsement Form") {
        $xSignatureCoordinates = [120, 100]; // X coordinates for each signatory's signature    
        $ySignatureCoordinates = [175, 222]; // Y coordinates for each signatory's signature
        $xNameCoordinates = [130, 100]; // X coordinates for each signatory's name
        $yNameCoordinates = [194, 223]; // Y coordinates for each signatory's name
        } 

        // Loop through signatory IDs to insert signatures and names
    foreach ($signatoryIds as $index => $signatoryId) {
        // Fetch and insert signature image
        $query = "SELECT signature FROM users WHERE user_id = '$signatoryId'";
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            $signatureFilename = $row['signature'];
            $signaturePath = "upload_folder/$signatureFilename"; // Path to the signature image

            // Check if coordinates are defined for the current signatory
            if (isset($xSignatureCoordinates[$index]) && isset($ySignatureCoordinates[$index]) && isset($xNameCoordinates[$index]) && isset($yNameCoordinates[$index])) {
                $xSignature = $xSignatureCoordinates[$index]; // Get X coordinate for the current signatory's signature
                $ySignature = $ySignatureCoordinates[$index]; // Get Y coordinate for the current signatory's signature
                $xName = $xNameCoordinates[$index]; // Get X coordinate for the current signatory's name
                $yName = $yNameCoordinates[$index]; // Get Y coordinate for the current signatory's name

                // Insert signature image
                $pdf->Image($signaturePath, $xSignature, $ySignature, 30);

                // Add name at specified coordinates
                $userNameQuery = "SELECT name FROM users WHERE user_id = '$signatoryId'";
                $userNameResult = mysqli_query($conn, $userNameQuery);
                if ($userNameRow = mysqli_fetch_assoc($userNameResult)) {
                    $userName = $userNameRow['name'];
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Text($xName, $yName, $userName);
                }
            } else {
                echo "Coordinates not defined for signatory ID $signatoryId.<br>";
            }
        }
    }

        // Save the PDF with the JPG background
        $pdfFilename = $_SERVER['DOCUMENT_ROOT'] . '/wdfuip/admin/signatured_documents/' . $document_id . '.pdf';
        $pdf->Output($pdfFilename, 'F');

        echo "PDF with JPG background saved successfully.";

}

?>
