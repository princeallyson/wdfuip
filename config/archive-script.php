<?php
require ("db_connection.php");

$currentDate = date('Y-m-d');
$sql = "SELECT * FROM document_status where expiration < '$currentDate'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		$id = $row['document_id'];
		mysqli_query($conn, "UPDATE document_status SET archive_status = 1 WHERE document_id = $id");
	}
}
?>