<?php
require("../config/db_connection.php");

// Execute the query
$result = mysqli_query($conn, "SELECT
    D.document_id,
    D.document,
    D.document_type,
    D.owner_id,
    D.uploaded_at
FROM
    documents D
LEFT JOIN
    assign_signatory AS ASG ON D.document_id = ASG.document_id
WHERE
    ASG.document_id IS NULL;
");

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
