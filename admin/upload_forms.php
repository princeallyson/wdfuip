<?php
// Include database connection code here (assuming you have a database connection)
require_once "../config/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file is uploaded
    if (isset($_FILES["docxFile"])) {
        $file = $_FILES["docxFile"];
        
        // File details
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];
        
        // Get file extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Allowed file extensions
        $allowedExtensions = ["docx"];
        
        // Check if the uploaded file is a DOCX file
        if (in_array($fileExt, $allowedExtensions)) {
            // Specify the folder to save the uploaded file
            $uploadFolder = "forms/";
            
            // Move the uploaded file to the upload folder on the server with the original file name
            if (move_uploaded_file($fileTmpName, $uploadFolder . $fileName)) {
                // Include database connection code here (assuming you have a database connection)
                require_once "../config/db_connection.php";
                
                // Insert the file name into the database
                $sql = "INSERT INTO forms (form_name) VALUES (?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $fileName);
                
                if ($stmt->execute()) {
                    // File uploaded and database entry added successfully
                    echo "File uploaded and database entry added.";
                } else {
                    // Error inserting into the database
                    echo "Error: " . $conn->error;
                }
            } else {
                // Error moving the uploaded file
                echo "Error uploading the file.";
            }
        } else {
            // Invalid file type
            echo "Invalid file type. Only DOCX files are allowed.";
        }
    } else {
        // No file uploaded
        echo "Please select a file to upload.";
    }
} else {
    // Redirect if accessed directly without form submission
    header("Location: ../config/not_found.php");
    exit();
}
?>