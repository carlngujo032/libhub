<?php
session_start();
include 'db_connection.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    // Sanitize input data
    $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);

    // Delete user from the database
    $sql = "DELETE FROM u_management WHERE id='$user_id'";
    if (mysqli_query($conn, $sql)) {
        // Return success response
        echo json_encode(array("status" => "success"));
        exit();
    } else {
        // Return error response
        echo json_encode(array("status" => "error"));
        exit();
    }
} else {
    // Return error response if user ID is not provided
    echo json_encode(array("status" => "error"));
    exit();
}
?>
