<?php
require("../config/db_connection.php");
session_start();

$data = '';
$sql = "SELECT DISTINCT n.recipient_id, n.document_id, n.is_read, ds.approval_status FROM notifications n INNER JOIN document_status ds ON n.document_id = ds.document_id WHERE n.recipient_id = '".$_SESSION['id']."' AND ds.approval_status = 'Pending' AND n.is_read = 0";
$result = mysqli_query($conn, $sql);

// Check if there are any rows returned by the query
if(mysqli_num_rows($result) > 0) {
    // Loop through each row of the result set
    while($row = mysqli_fetch_assoc($result)) {
        $document_id = $row['document_id'];
        $data .= '<a href="documents.php"><li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">The document number <strong>'.$document_id.'</strong> is pending for your signature.</li></a>';
    }
} else {
    // No pending documents found
    $data .= '<li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">There is no pending document to be signed.</li>';
}

echo $data;

// Check if notification POST data is set
if(isset($_POST['notification'])){
    mysqli_query($conn, "UPDATE notifications n INNER JOIN document_status ds ON n.document_id = ds.document_id SET n.is_read = 1 WHERE n.recipient_id = '".$_SESSION['id']."' AND ds.approval_status = 'Pending' AND n.is_read = 0");
}
?>
