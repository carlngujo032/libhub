<?php
session_start();
$server = "localhost";
$username = "root";
$password = "";
$dbname = "qrcodedb"; // Change the database name to your library database

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed" . $conn->connect_error);
}

if (isset($_POST['bookID'])) {
    $bookID = $_POST['bookID'];
    $date = date('Y-m-d');
    $time = date('H:i:s A');

    // Assuming you have a books table in your database
    $sql = "SELECT * FROM books WHERE bookID = '$bookID'";
    $query = $conn->query($sql);

    if ($query->num_rows < 1) {
        $_SESSION['error'] = 'Cannot find book with ID: ' . $bookID;
    } else {
        $row = $query->fetch_assoc();
        $id = $row['bookID'];
        // Insert logic to handle book borrowing here
        // For example, you can insert a record into a borrowed_books table with borrower information and book ID
        // You can also update the availability status of the book in the books table
        $_SESSION['success'] = 'Successfully borrowed book: ' . $row['title'];
    }
} else {
    $_SESSION['error'] = 'Please scan the QR Code of the book';
}
header("location: index.php"); // Redirect back to the main page
$conn->close();
?>
