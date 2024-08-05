<?php
require("../config/db_connection.php");
session_start();

$data = '';

$sql = "SELECT COUNT(D.document_id) AS count FROM documents D LEFT JOIN assign_signatory AS ASG ON D.document_id = ASG.document_id WHERE ASG.document_id IS NULL";
$result = mysqli_query($conn, $sql);
// Check if query was successful
if ($result) {
    // Fetch the result
    $row = mysqli_fetch_assoc($result);
    $data .= $row['count'];
}
echo $data;
?>