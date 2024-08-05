<?php
require("../config/db_connection.php");

// Check if the ID is provided
if(isset($_POST['id'])) {
    $id = $_POST['id'];

    // Perform the deletion query
    $query = "DELETE FROM college_components WHERE id = ?";
    $statement = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($statement, "i", $id);
    
    if(mysqli_stmt_execute($statement)) {
        echo "success"; // Return success message if deletion is successful
    } else {
        echo "error"; // Return error message if deletion fails
    }

    mysqli_stmt_close($statement);
    mysqli_close($conn);
} else {
    echo "ID is required";
}
?>
