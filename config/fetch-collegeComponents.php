<?php
// Perform database connection
require("db_connection.php");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['action']) && $_GET['action'] === 'fetch_programs') {
    // Query to fetch programs
    $query = "SELECT program FROM college_components WHERE program != ''";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching programs: " . mysqli_error($conn));
    }

    // Fetch programs as an associative array
    $programs = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $programs[] = $row['program'];
    }

    // Send JSON response
    echo json_encode($programs);
} elseif (isset($_GET['action']) && $_GET['action'] === 'fetch_departments') {
    // Query to fetch departments
    $query = "SELECT department FROM college_components WHERE department != ''";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching departments: " . mysqli_error($conn));
    }

    // Fetch departments as an associative array
    $departments = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $departments[] = $row['department'];
    }

    // Send JSON response
    echo json_encode($departments);
} elseif (isset($_GET['action']) && $_GET['action'] === 'fetch_designations') {
    // Query to fetch designations
    $query = "SELECT designation FROM college_components WHERE designation != ''";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error fetching designation: " . mysqli_error($conn));
    }

    // Fetch designations as an associative array
    $designations = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $designations[] = $row['designation'];
    }

    // Send JSON response
    echo json_encode($designations);
}else {
    // Invalid request
    echo json_encode(array('error' => 'Invalid request'));
}

// Close connection
mysqli_close($conn);
?>
