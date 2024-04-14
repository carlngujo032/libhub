<?php
session_start();
include 'db_connection.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set and not empty
    if (isset($_POST["user_id"]) && isset($_POST["fullName"]) && isset($_POST["email"]) && isset($_POST["contactNo"]) && isset($_POST["role"]) && isset($_POST["lrn"]) && isset($_POST["schoolName"])) {
        // Sanitize input data
        $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);
        $fullName = mysqli_real_escape_string($conn, $_POST["fullName"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $contactNo = mysqli_real_escape_string($conn, $_POST["contactNo"]);
        $role = mysqli_real_escape_string($conn, $_POST["role"]);
        $lrn = mysqli_real_escape_string($conn, $_POST["lrn"]);
        $schoolName = mysqli_real_escape_string($conn, $_POST["schoolName"]);

        // Update user information in the database
        $sql = "UPDATE u_management SET FULLNAME='$fullName', EMAIL='$email', CONTACT_NO='$contactNo', ROLE='$role', LRN='$lrn', SCHOOL_NAME='$schoolName' WHERE id='$user_id'";
        if (mysqli_query($conn, $sql)) {
            // Redirect to the user management page with a success message
            header("Location: a_user.php?message=success");
            exit();
        } else {
            // Redirect to the user management page with an error message
            header("Location: a_user.php?message=error");
            exit();
        }
    } else {
        // Redirect to the user management page with an error message if required fields are missing
        header("Location: a_user.php?message=error");
        exit();
    }
} else {
    // Redirect to the user management page if accessed through GET request
    header("Location: a_user.php");
    exit();
}
?>
