<?php
require("../config/db_connection.php");
session_start();

$data = '';

$sql = "SELECT COUNT(DISTINCT n.recipient_id, n.document_id, n.is_read) AS count FROM notifications n INNER JOIN document_status ds ON n.document_id = ds.document_id WHERE n.recipient_id = '".$_SESSION['id']."' AND ds.approval_status = 'Pending' AND n.is_read = 0;";
$result = mysqli_query($conn, $sql);
// Check if query was successful
if ($result) {
    // Fetch the result
    $row = mysqli_fetch_assoc($result);
    $data .= $row['count'];
}
echo $data;
?>