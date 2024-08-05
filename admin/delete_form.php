<?php 
require("../config/db_connection.php");

if(isset($_POST['id'])){
	$id = $_POST['id'];

	$formName = mysqli_query($conn, "SELECT form_name FROM forms WHERE id = '$id'");
	$deleteForm = mysqli_query($conn, "DELETE FROM forms WHERE id = '$id'");
	if(mysqli_num_rows($formName) > 0){
		while($row = mysqli_fetch_assoc($formName)){
			if($deleteForm){
				unlink("forms/".$row['form_name']);
				echo '1';
			}
			else{
				echo '0';
			}
		}
	}

}

?>