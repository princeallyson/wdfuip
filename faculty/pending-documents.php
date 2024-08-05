<?php
require("../config/db_connection.php");
session_start();
// Execute the query
$result = mysqli_query($conn, "SELECT
    DS.document_id,
    D.document,
    D.document_type,
    D.owner_id,
    D.uploaded_at,
    COALESCE(
        MAX(CASE WHEN DS.approval_status = 'Rejected' THEN 'Rejected' END),
        MAX(CASE WHEN DS.approval_status = 'Pending' THEN 'Pending' END),
        'Approved'
    ) AS approval_status
FROM
    document_status DS
JOIN
    documents D ON DS.document_id = D.document_id
WHERE
    DS.signatory_id = '" . $_SESSION['id'] . "'
GROUP BY
    DS.document_id, D.document, D.owner_id, D.uploaded_at
HAVING
    approval_status = 'Pending'");

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
            'approval_status' => $row['approval_status'],
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
