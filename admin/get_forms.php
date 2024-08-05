<?php
require("../config/db_connection.php");

// Execute the query
$result = mysqli_query($conn, "SELECT * FROM forms");

// Build an array to hold your data
$data = array();

// Fetch data
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'id' => $row['id'],
            'name' => $row['form_name'],
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
