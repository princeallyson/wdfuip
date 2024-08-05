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
    // Include your database connection file here
    // include 'db_connection.php';

    $id = $_POST['hidden_userid'];
    $enumber = $_POST['enumber'];
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $department = $_POST['department'];
    $cnumber = $_POST['cnumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if a file was uploaded
    if(isset($_FILES['picture']) && $_FILES['picture']['error'] == 0){
        $file_name = $_FILES['picture']['name'];
        $file_tmp = $_FILES['picture']['tmp_name'];

        // Specify the target directory for file upload
        $target_dir = "../assets/img/profiles/";
        
        // Move uploaded file to desired location with the original filename
        move_uploaded_file($file_tmp, $target_dir . $file_name);
        
        // Update the picture variable with the new file name
        $picture = $file_name;
    }
    
    // Check if picture is empty
    if(empty($picture)){
        // Update user data without picture
        // Note: You should use prepared statements for better security
        // Example: $stmt = $conn->prepare("UPDATE users SET user_id=?, name=?, designation=?, department=?, contactNumber=?, email=?, password=? WHERE user_id=?");
        // $stmt->bind_param("sssssssi", $enumber, $name, $designation, $department, $cnumber, $email, $password, $id);
        // $stmt->execute();
        mysqli_query($conn, "UPDATE users SET user_id='$enumber', name='$name', designation='$designation', department='$department', contactNumber='$cnumber', email='$email', password='$password' WHERE user_id=$id");
    }
    else {
        // Update user data with picture
        // Note: Use prepared statements for better security
        // Example: $stmt = $conn->prepare("UPDATE users SET user_id=?, name=?, designation=?, department=?, contactNumber=?, email=?, password=?, picture=? WHERE user_id=?");
        // $stmt->bind_param("ssssssssi", $enumber, $name, $designation, $department, $cnumber, $email, $password, $picture, $id);
        // $stmt->execute();
        mysqli_query($conn, "UPDATE users SET user_id='$enumber', name='$name', designation='$designation', department='$department', contactNumber='$cnumber', email='$email', password='$password', picture='$picture' WHERE user_id=$id");
        $_SESSION["picture"] = $picture;
    }

    // Update session variables
    $_SESSION["id"] = $enumber;
    $_SESSION["name"] = $name;
    $_SESSION["designation"] = $designation;
    $_SESSION["department"] = $department;
    $_SESSION["contactNumber"] = $cnumber;
    $_SESSION["email"] = $email;
    $_SESSION["password"] = $password;

    // Provide a response (optional)
    //echo "User Updated!";
}
?>