<?php
require("../config/db_connection.php");

if(isset($_POST['program'])){
    $program = $_POST['program'];

    $check = mysqli_query($conn, "SELECT program from college_components WHERE program = '".$program."'");

    if(mysqli_num_rows($check) > 0){
        echo 'error';
    } else {
        mysqli_query($conn, "INSERT INTO college_components (program) VALUES ('$program')");
        echo 'Program Added!';
    }
}

if(isset($_POST['designation'])){
    $designation = $_POST['designation'];

    $check = mysqli_query($conn, "SELECT designation from college_components WHERE designation = '".$designation."'");

    if(mysqli_num_rows($check) > 0){
        echo 'error';
    } else {
        mysqli_query($conn, "INSERT INTO college_components (designation) VALUES ('$designation')");
        echo 'Designation Added!';
    }
}

if(isset($_POST['department'])){
    $department = $_POST['department'];

    $check = mysqli_query($conn, "SELECT department from college_components WHERE department = '".$department."'");

    if(mysqli_num_rows($check) > 0){
        echo 'error';
    } else {
        mysqli_query($conn, "INSERT INTO college_components (department) VALUES ('$department')");
        echo 'Department Added';
    }
}
?>