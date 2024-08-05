<?php
require("../config/db_connection.php");
session_start();
// Execute the query
$result = mysqli_query($conn, "SELECT * FROM documents WHERE owner_id = '".$_SESSION['id']."'");

// Build an array to hold your data
$data = array();

// Fetch data
$id = 1;
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'id' => $id++,
            'document_id' => $row['document_id'],
            'document' => $row['document'],
            'document_type' => $row['document_type'],
            'uploaded_at' => $row['uploaded_at'],
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
