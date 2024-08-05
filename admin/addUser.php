<?php
require("../config/db_connection.php");

// Check if all required fields are set and files are uploaded
if(isset($_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['enumber'], $_POST['designation'], $_POST['department'], $_POST['email'], $_POST['cnumber'], $_POST['password'], $_POST['cpassword'], $_FILES['profilepicture'], $_FILES['signature'])) {

    // Extract form data
    extract($_POST);

    // Prepare user's full name
    $name = $fname . ' ' . $mname . '. ' . $lname;

    // Check if user already exists
    $check_query = "SELECT * FROM users WHERE user_id = '$enumber'";
    $check_result = mysqli_query($conn, $check_query);
    if (!$check_result) {
        die('Error checking user: ' . mysqli_error($conn));
    }
    if (mysqli_num_rows($check_result) < 0) {
        echo 'User already exists';
    } else {
        // Upload profile picture
        $profile_picture_tmp_name = $_FILES['profilepicture']['tmp_name'];
        $profile_picture_name = $_FILES['profilepicture']['name'];
        $profile_picture_path = "upload_folder/$profile_picture_name";

        // Upload signature
        $signature_tmp_name = $_FILES['signature']['tmp_name'];
        $signature_name = $_FILES['signature']['name'];
        $signature_path = "upload_folder/$signature_name";

        // Move files to upload folder and insert user data into the database
        if(move_uploaded_file($profile_picture_tmp_name, $profile_picture_path) && move_uploaded_file($signature_tmp_name, $signature_path)) {
            // Insert user data into the database with the image paths
            $insert_query = "INSERT INTO users (user_id, name, designation, department, contactNumber, email, password, picture, signature, user_level) VALUES ('$enumber', '$name', '$designation', '$department', '$cnumber', '$email', '$password', '$profile_picture_name', '$signature_name', 'Faculty')";
            $insert_result = mysqli_query($conn, $insert_query);
            if (!$insert_result) {
                die('Error inserting user: ' . mysqli_error($conn));
            }
            echo '1'; // Success message
        } else {
            echo 'Error uploading files';
        }
    }
} else {
    echo '0'; // Error message
}
?>
