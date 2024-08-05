<?php
require("config/db_connection.php");
session_start(); 

extract($_POST);

if(isset($_POST['userID']) && isset($_POST['password'])){
	$check_user = mysqli_query($conn, "SELECT * FROM users WHERE user_id='".$userID."' AND password = '".$password."'");
	if (mysqli_num_rows($check_user) > 0) {
		while($row = mysqli_fetch_assoc($check_user)){
			$id = $row["user_id"];
			$name = $row["name"];
			$program = $row["program"];
			$designation = $row["designation"];
			$department = $row["department"];
			$contactNumber = $row['contactNumber'];
			$email = $row['email'];
			$password = $row["password"];
			$picture = $row["picture"];
			$signature = $row["signature"];
			$user_level = $row["user_level"];

			$_SESSION["id"] = $id;
			$_SESSION["name"] = $name;
			$_SESSION["program"] = $program;
			$_SESSION["designation"] = $designation;
			$_SESSION["department"] = $department;
			$_SESSION["contactNumber"] = $contactNumber;
			$_SESSION["email"] = $email;
			$_SESSION["password"] = $password;
			$_SESSION["picture"] = $picture;
			$_SESSION["signature"] = $signature;
			$_SESSION["user_level"] = $user_level;


			if ($user_level == "Admin") {
				echo "Admin";
			}
			if ($user_level == "Faculty") {
				echo "Faculty";
			}
			if ($user_level == "Student") {
				echo "Student";
			}
		}
	}
	else{
		echo '0';
	}
}
?>