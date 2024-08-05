<?php
require("../config/db_connection.php");

// Execute the query
$currentDate = date('Y-m-d');
$result = mysqli_query($conn, "SELECT documents.document_id, documents.document, documents.document_type, COALESCE(MAX(CASE WHEN document_status.approval_status = 'Rejected' THEN 'Rejected' END), MAX(CASE WHEN document_status.approval_status = 'Pending' THEN 'Pending' END), 'Approved') AS overall_approval_status, documents.owner_id, documents.uploaded_at, document_status.expiration, document_status.archive_status FROM documents JOIN document_status ON documents.document_id = document_status.document_id JOIN assign_signatory ON documents.document_id = assign_signatory.document_id WHERE document_status.archive_status = 0 AND document_status.expiration >= '$currentDate' GROUP BY documents.document_id, documents.document, documents.document_type, documents.uploaded_at ORDER BY documents.document_id DESC");

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
            'approval_status' => $row['overall_approval_status'],
            'expiration' =>  date_format(date_create($row['expiration']), 'Y-m-d'),
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
