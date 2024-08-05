<?php 
require ("../config/db_connection.php");
session_start();

// GETTING USER DATA USING USER ID
if(isset($_POST['id']) && $_POST['id'] != ""){
    $id = $_POST['id'];

    $query = "SELECT * FROM users WHERE user_id = '$id'";
    if(!$result = mysqli_query($conn, $query)){
        exit(mysqli_error());
    }
    $response = array();

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)) {
            $response = $row;
        }
    }
    else{
        $response['status'] = 200;
        $response['message'] = "Data not found";
    }
    echo json_encode($response);
}
else{
    $response['status'] = 200;
    $response['message'] = "Invalid request";
    echo json_encode($response);
}

// UPDATING USER DATA
if(isset($_POST['hidden_userid'])){
    $id = $_POST['hidden_userid'];

    $enumber = $_POST['enumber'];
    $name = $_POST['name'];
    $program = $_POST['program'];
    $department = $_POST['department'];
    $cnumber = $_POST['cnumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if a file was uploaded
    if(isset($_FILES['picture']) && $_FILES['picture']['error'] == 0){
        $file_name = $_FILES['picture']['name'];
        $file_tmp = $_FILES['picture']['tmp_name'];
        
        // Split the filename and extension
    $file_parts = pathinfo($file_name);
    $filename = $file_parts['filename'];
    $extension = isset($file_parts['extension']) ? '.' . $file_parts['extension'] : '';

    // Insert session ID between filename and extension
    $new_filename = $filename . '_' . $_SESSION['id'] . $extension;

    // Move uploaded file to desired location with the new filename
    move_uploaded_file($file_tmp, "../assets/img/profiles/" . $new_filename);
    
    // Update the picture variable with the new file name
    $picture = $new_filename;
    }
    
    // Check if picture is empty
    if(empty($picture)){
        mysqli_query($conn, "UPDATE users SET user_id='$enumber', name='$name', program='$program', department='$department', contactNumber='$cnumber', email='$email', password='$password' WHERE user_id=$id");
    }
    else {
        mysqli_query($conn, "UPDATE users SET user_id='$enumber', name='$name', program='$program', department='$department', contactNumber='$cnumber', email='$email', password='$password', picture='$picture' WHERE user_id=$id");
        $_SESSION["picture"] = $picture;
    }

    // Update session variables
    $_SESSION["id"] = $enumber;
    $_SESSION["name"] = $name;
    $_SESSION["program"] = $program;
    $_SESSION["department"] = $department;
    $_SESSION["contactNumber"] = $cnumber;
    $_SESSION["email"] = $email;
    $_SESSION["password"] = $password;
    
}

?>
