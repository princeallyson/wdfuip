<?php
require("config/db_connection.php");

// Function to check if a user already exists
function userExists($conn, $snumber) {
    $check = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$snumber'");
    return mysqli_num_rows($check) > 0;
}

// Main registration logic
if (
    isset($_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['snumber'], $_POST['program'],
        $_POST['department'], $_POST['email'], $_POST['cnumber'], $_POST['passwordInput'], $_POST['confirmPasswordInput'])
    && isset($_FILES['profilepicture'])
) {

    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $snumber = $_POST['snumber'];
    $program = $_POST['program'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $cnumber = $_POST['cnumber'];
    $password = $_POST['passwordInput'];
    $cpassword = $_POST['confirmPasswordInput'];
    $name = $fname . ' ' . $mname . '. ' . $lname;
    $profilepicture = $_FILES['profilepicture']['name'];

    if (!userExists($conn, $snumber)) {
        // File upload handling
        $targetDir = "assets/img/profiles/"; // Specify the target directory where you want to store uploaded files
        $targetFile = $targetDir . basename($profilepicture);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES['profilepicture']['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Check file size (adjust the size limit as needed)
        if ($_FILES['profilepicture']['size'] > 5000000) {
            // echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats (add/remove file formats as needed)
        if (
            $imageFileType != "jpg" && $imageFileType != "png" &&
            $imageFileType != "jpeg" && $imageFileType != "gif"
        ) {
            // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // echo "Sorry, your file was not uploaded.";
        } else {
            // If everything is OK, try to upload the file
            if (move_uploaded_file($_FILES['profilepicture']['tmp_name'], $targetFile)) {
                // Using plain mysqli to insert data
                $query = "INSERT INTO users (user_id, name, program, department, contactNumber, email, password, picture, user_level) VALUES ('$snumber', '$name', '$program', '$department', '$cnumber', '$email', '$password', '$profilepicture', 'Student')";
                if (mysqli_query($conn, $query)) {
                    echo '1';
                } else {
                    echo '0';
                }
            } else {
                echo '<script>toastr.error("Sorry, there was an error uploading your file.");</script>';
            }
        }
    } else {
        echo '<script>toastr.error("User already exists");</script>';
    }
} else {
    echo '<script>toastr.error("Incomplete form data");</script>';
}
?>
