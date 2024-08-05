<?php
require("../config/db_connection.php");

// Execute the query
$result = mysqli_query($conn, "SELECT user_id, name, CONCAT(program,designation) as designation, department, contactNumber, email, user_level FROM users;");

// Build an array to hold your data
$data = array();

// Fetch data
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'user_id' => $row['user_id'],
            'name' => $row['name'],
            'designation' => $row['designation'],
            'department' => $row['department'],
            'contactNumber' => '+63 '.$row['contactNumber'],
            'email' => $row['email'],
            'user_level' => $row['user_level'],
        );
    }
}

// Free the result set
mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);

// Send the data back as JSON
echo json_encode(array('data' => $data));

?>
