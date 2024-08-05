<?php
require("../config/db_connection.php");
session_start();

$data = '';
$sql = "SELECT D.document_id, D.document, D.document_type, D.owner_id, D.uploaded_at FROM documents D LEFT JOIN assign_signatory AS ASG ON D.document_id = ASG.document_id WHERE ASG.document_id IS NULL";
$result = mysqli_query($conn, $sql);

// Check if there are any rows returned by the query
if(mysqli_num_rows($result) > 0) {
    // Loop through each row of the result set
    while($row = mysqli_fetch_assoc($result)) {
        $document_id = $row['document_id'];
        $data .= '<a href="request-document.php"><li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">The document number <strong>'.$document_id.'</strong> is in need of a signatory.</li></a>';
    }
} else {
    // No pending documents found
    $data .= '<li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">There are no documents in need of a signatory as of the moment.</li>';
}

echo $data;
?>
