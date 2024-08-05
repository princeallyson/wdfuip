<?php
// Include database connection
require("../config/db_connection.php");

// Check if the form data is received
if(isset($_POST['document_id'], $_POST['faculty_id'], $_POST['status'])) {
    // Get form data
    $document_id = $_POST['document_id'];
    $faculty_id = $_POST['faculty_id'];
    $status = $_POST['status'];
    $comment = $_POST['comment'];
    $remarks = $_POST['remarks'];
    $name = '';

    // Update comment and remarks based on document ID and signatory ID
    $sql = "UPDATE document_status 
    SET comments = '".$comment."', remarks = '".$remarks."', approval_status = '".$status."', approval_time = NOW()
    WHERE document_id = '$document_id' AND signatory_id = '$faculty_id'";
    
    // Execute the query
    if(mysqli_query($conn, $sql)) {
        $nameSql = mysqli_query($conn, "SELECT name from users WHERE user_id = '$faculty_id'");
        if ($nameSql) {
    // Fetch the row as an associative array
            $row = mysqli_fetch_assoc($nameSql);
            if ($row) {
                $name = $row['name'];
            }
        }

        notifyUser($document_id, $status, $name, $conn);


        // Operation successful
        echo "Form processed successfully!";
    } else {
        // Error occurred
        echo "Error: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
} else {
    // If form data is not received
    echo "Error: Form data is not received.";
}

function notifyUser($id, $status, $name, $conn){
    $apiKey = '590c6c4421031d422bb2b442a33d76b0';
    $sql = mysqli_query($conn, "SELECT documents.document, users.contactNumber FROM documents JOIN users ON documents.owner_id= users.user_id WHERE documents.document_id = '$id'");
    while($row = mysqli_fetch_assoc($sql)){
        $phoneNumber = $row['contactNumber'];
        $documentName = $row['document'];
        $message = 'From PUP GSREO! Your '.$documentName.' has been '.$status.' by '.$name.'';
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
