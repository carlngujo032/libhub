<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['bookID'])) {
        $bookID = $_POST['bookID'];
        
        $sql = "DELETE FROM books WHERE bookID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $bookID);
        
        if ($stmt->execute()) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "error"));
        }
    } else {
        echo json_encode(array("status" => "error"));
    }
}
?>
