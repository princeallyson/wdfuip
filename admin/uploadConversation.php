<?php
require("../config/db_connection.php");

if (isset($_POST['documentId'], $_POST['userId'], $_POST['signatoryId'], $_POST['status'])) {
    $documentId = $_POST['documentId'];
    $userId = $_POST['userId'];
    $signatoryId = $_POST['signatoryId'];
    $status = $_POST['status'];

    // Check if file was uploaded without errors
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file'];

        // Construct the filename (documentId_signatoryId)
        $fileName = $documentId . '_' . $signatoryId;

        // Specify the directory for file uploads
        $targetDir = "../assets/conversations/";

        // Generate a unique filename to prevent overwriting
        $uniqueFileName = uniqid() . '_' . $fileName;

        // Construct the target file path
        $targetFilePath = $targetDir . $uniqueFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        	if($status == "Approved"){
            // Prepare and execute the SQL UPDATE statement
        		echo '1';
        		mysqli_query($conn, "UPDATE document_status SET conversation = '$targetFilePath', approval_status = 'Approved', approval_time = NOW() WHERE document_id = $documentId AND signatory_id = $signatoryId");
            }
            else{
            	echo '2';
            	mysqli_query($conn, "UPDATE document_status SET conversation = '$targetFilePath', approval_status = 'Rejected', approval_time = NOW() WHERE document_id = $documentId AND signatory_id = $signatoryId");
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "File upload error: " . $_FILES['file']['error'];
    }
} else {
    echo "Required parameters are missing.";
}

// Close the database connection
mysqli_close($conn);
?>
