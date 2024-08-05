<?php
require("../config/db_connection.php");

// Fetch data for each table from your database or any other source
$programResult = mysqli_query($conn, "SELECT id, program FROM college_components WHERE program != ''");
$designationResult = mysqli_query($conn, "SELECT id, designation from college_components WHERE designation != ''");
$departmentResult = mysqli_query($conn, "SELECT id, department from college_components WHERE department != ''");

// Fetch the data from result sets
$programData = mysqli_fetch_all($programResult, MYSQLI_ASSOC);
$designationData = mysqli_fetch_all($designationResult, MYSQLI_ASSOC);
$departmentData = mysqli_fetch_all($departmentResult, MYSQLI_ASSOC);

// Prepare data to be sent as JSON
$response = array(
    'program' => $programData,
    'designation' => $designationData,
    'department' => $departmentData
);

// Output data as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>