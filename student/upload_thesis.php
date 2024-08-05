<?php
require("../config/db_connection.php");

session_start();

if(isset($_POST['submit'])) {
    $uploader_name = $_SESSION['name'];
    $thesis_comments = $_POST['thesis-comments'];
    $upload_date = date("Y-m-d H:i:s");

    // Get user_id based on uploader_name
    $sql_user = "SELECT user_id FROM users WHERE name = '$uploader_name'";
    $result_user = mysqli_query($conn, $sql_user);

    if(mysqli_num_rows($result_user) == 1) {
        $row_user = mysqli_fetch_assoc($result_user);
        $user_id = $row_user['user_id'];

        // File upload handling
        $filename = basename($_FILES["thesis-file"]["name"]);
        $file_extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Specify the target directory path
        $target_dir = "uploads/";

        // File upload handling
        $target_file = $target_dir . basename($_FILES["thesis-file"]["name"]);

        // Move the file to the target directory
        if(move_uploaded_file($_FILES["thesis-file"]["tmp_name"], $target_file)) {
            // Insert data into the database
            $sql = "INSERT INTO thesis_document (user_id, uploader_name, file_name, upload_date, comments) VALUES ('$user_id', '$uploader_name', '$filename', '$upload_date', '$thesis_comments')";
            if(mysqli_query($conn, $sql)) {
                header("Location: dashboard.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "User not found or multiple users found with the same name.";
    }
}
?>
