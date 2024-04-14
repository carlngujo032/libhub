<?php
include 'db_connection.php'; // Include database connection

if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    // Prepare and execute the SELECT query
    $sql = "SELECT * FROM u_management WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch user details
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        echo json_encode(array("status" => "error", "message" => "User not found"));
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
