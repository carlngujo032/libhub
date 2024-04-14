<?php
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $copyright = $_POST['copyright'];
    $subjectArea = $_POST['subject_area'];
    $keyStage = $_POST['key_stage'];
    $source = $_POST['source'];
    $format = $_POST['format'];
    $classificationNo = $_POST['classification_no'];
    $isbn = $_POST['isbn'];
    $dateReceived = $_POST['date_received'];
    $bookID = $_POST['bookID'];
    $status = $_POST['status'];

    // SQL to insert book into database
    $sql = "INSERT INTO Books (TITLE, AUTHOR, PUBLISHER, COPYRIGHT, SUBJECT_AREA, KEY_STAGE, SOURCE, FORMAT, CLASSIFICATION_NO, ISBN, DATE_RECEIVED, bookID, STATUS) 
            VALUES ('$title', '$author', '$publisher', '$copyright', 
                    '$subjectArea', '$keyStage', '$source', '$format', '$classificationNo', '$isbn', '$dateReceived', '$bookID', '$status')";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        // Book inserted successfully
        mysqli_close($conn); // Close database connection
        header("Location: a_m_book.php?message=success"); // Redirect to a_m_book.php with success message
        exit(); // Stop further execution
    } else {
        // Error occurred while inserting book
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
