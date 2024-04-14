<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the book ID and status from the form
    $bookId = $_POST['bookId'];
    $status = $_POST['status']; // Assuming the status indicates whether the book is borrowed or returned

    // Connect to the database
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "qrcodedb";

    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize the statement variables
    $stmt_check_available = null;
    $stmt_check_borrowed = null;
    $stmt_borrow = null;
    $stmt_return = null;

    // Get borrower's full name and contact number from user_management table
    $borrowerFullName = $_SESSION['fullname']; // Assuming the full name is stored in session
    $borrowerContactNo = "";

    $sql_get_user_info = "SELECT fullname, contact_no FROM u_management WHERE email = ?";
    $stmt_get_user_info = $conn->prepare($sql_get_user_info);
    $stmt_get_user_info->bind_param("s", $_SESSION['email']);
    $stmt_get_user_info->execute();
    $result_get_user_info = $stmt_get_user_info->get_result();

    if ($result_get_user_info->num_rows > 0) {
        $row = $result_get_user_info->fetch_assoc();
        $borrowerFullName = $row['fullname'];
        $borrowerContactNo = $row['contact_no'];
    }

    // Get current date and time
    date_default_timezone_set("Asia/Manila");
    
    $currentDateTime = date("Y-m-d H:i:s");

    // Sanitize input to prevent SQL injection
    $bookId = htmlspecialchars($bookId);
    $status = htmlspecialchars($status);
// Inside the 'borrow' section of your code
if ($status === 'borrow') {
    // Check if the book is available for borrowing
    $sql_check_available = "SELECT * FROM books WHERE bookID = ? AND status = 'available'";
    $stmt_check_available = $conn->prepare($sql_check_available);
    $stmt_check_available->bind_param("s", $bookId);
    $stmt_check_available->execute();
    $result_check_available = $stmt_check_available->get_result();

    if ($result_check_available->num_rows > 0) {
        // Fetch the book title
        $row = $result_check_available->fetch_assoc();
        $borrowed_book_title = $row['TITLE'];

        // Insert the record into borrowed_books table
        $sql_borrow = "INSERT INTO b_borrowed (book_id, title, borrower, contact_no, status, date) VALUES (?, ?, ?, ?, 'borrow', ?)";
        $stmt_borrow = $conn->prepare($sql_borrow);
        $stmt_borrow->bind_param("sssss", $bookId, $borrowed_book_title, $borrowerFullName, $borrowerContactNo, $currentDateTime);
        if ($stmt_borrow->execute()) {
            // Update the status of the book to indicate it's no longer available
            $sql_update = "UPDATE books SET status = 'unavailable' WHERE bookID = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("s", $bookId);
            $stmt_update->execute();

            $_SESSION['message'] = "Book successfully borrowed: $borrowed_book_title";
        } else {
            $_SESSION['message'] = "Error borrowing the book";
        }
    } else {
        $_SESSION['message'] = "Book not found or not available for borrowing";
    }

    } elseif($status === 'return') {
        // Check if the book has been borrowed by the user
        $sql_check_borrowed = "SELECT * FROM b_borrowed WHERE book_id = ? AND borrower = ?";
        $stmt_check_borrowed = $conn->prepare($sql_check_borrowed);
        $stmt_check_borrowed->bind_param("ss", $bookId, $borrowerFullName);
        $stmt_check_borrowed->execute();
        $result_check_borrowed = $stmt_check_borrowed->get_result();
    
        if ($result_check_borrowed->num_rows > 0) {
            // Fetch the book title
            $sql_get_title = "SELECT TITLE FROM books WHERE bookID = ?";
            $stmt_get_title = $conn->prepare($sql_get_title);
            $stmt_get_title->bind_param("s", $bookId);
            $stmt_get_title->execute();
            $result_get_title = $stmt_get_title->get_result();
            $row = $result_get_title->fetch_assoc();
            $returned_book_title = $row['TITLE'];
    
            // Insert the record into returned_books table
            $sql_return = "INSERT INTO b_returned (book_id, title, borrower, contact_no, status, date) VALUES (?, ?, ?, ?, 'return', ?)";
            $stmt_return = $conn->prepare($sql_return);
            $stmt_return->bind_param("sssss", $bookId, $returned_book_title, $borrowerFullName, $borrowerContactNo, $currentDateTime);
            if ($stmt_return->execute()) {
                // Update the status of the book to indicate it's available again
                $sql_update = "UPDATE books SET status = 'available' WHERE bookID = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("s", $bookId);
                $stmt_update->execute();
    
                $_SESSION['message'] = "Book successfully returned: $returned_book_title";
            } else {
                $_SESSION['message'] = "Error returning the book";
            }
        } else {
            $_SESSION['message'] = "Book is still available and nothing to return";
        }
    
    } else {
        $_SESSION['message'] = "Invalid status";
    }

    // Close the statements
    if ($stmt_check_available != null) {
        $stmt_check_available->close();
    }
    if ($stmt_check_borrowed != null) {
        $stmt_check_borrowed->close();
    }
    if ($stmt_borrow != null) {
        $stmt_borrow->close();
    }
    if ($stmt_return != null) {
        $stmt_return->close();
    }
    $conn->close();

    // Redirect to main_menu.php
    header("Location: main_menu.php");
    exit();
} else {
    echo "Invalid request";
}

?>
