<?php
require("../config/db_connection.php");
session_start();
// Execute the query
$result = mysqli_query($conn, "SELECT d.document_id, d.document, d.document_type, d.owner_id, u.user_id, d.uploaded_at, ds.comments, ds.remarks, ds.approval_status
FROM documents d 
INNER JOIN document_status ds ON d.document_id = ds.document_id 
INNER JOIN users u ON ds.signatory_id = u.user_id 
WHERE u.user_id = '" . $_SESSION['id'] . "'");

// Build an array to hold your data
$data = array();

// Fetch data
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'document_id' => $row['document_id'],
            'document' => $row['document'],
            'document_type' => $row['document_type'],
            'owner_id' => $row['owner_id'],
            'approval_status' => $row['approval_status'],
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
