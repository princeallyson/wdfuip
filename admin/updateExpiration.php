<?php
require("../config/db_connection.php");

if(isset($_POST['updateExpiration'])){
	$id = $_POST['id'];
	$date = $_POST['date'];

	$query = mysqli_query($conn, "UPDATE document_status SET expiration = '".$date."' WHERE document_id = $id");

	if($query){
		echo '1';
	}

}

if(isset($_POST['retrieveExpired'])) {
    $id = $_POST['id'];
    $date = $_POST['date'];

    // Sanitize the input (assuming $conn is the database connection)
    $id = mysqli_real_escape_string($conn, $id);
    $date = mysqli_real_escape_string($conn, $date);

    // Construct and execute the SQL query
    $query = mysqli_query($conn, "UPDATE document_status SET expiration = '$date', archive_status = 0 WHERE document_id = $id");

    // Check if the query was successful
    if($query) {
        echo '1'; // Echo success
    } else {
        echo mysqli_error($conn); // Echo any errors
    }
}

?>
