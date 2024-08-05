<?php
require("config/db_connection.php");

if (isset($_POST['snumber'])) {
    $snumber = $_POST['snumber'];

    // Check if the user exists in the database
    $check = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$snumber'");
    if (mysqli_num_rows($check) > 0) {
        echo 'exists';
    } else {
        echo 'not_exists';
    }
} else {
    echo 'error';
}
?>
