<?php
// Include your database connection file
include 'db_connection.php';

// Define table headers
$tableHeaders = ["Title", "Author", "Publisher", "Copyright", "Subject Area", "Key Stage", "Source", "Format", "Classification No", "Book ID", "Status"];

// Check if bookType parameter is set
if(isset($_GET['bookType'])) {
    // Sanitize the bookType parameter to prevent SQL injection
    $bookType = mysqli_real_escape_string($conn, $_GET['bookType']);
    
    // Construct the SQL query to filter books by book type (in this case, SUBJECT_AREA)
    $sql = "SELECT * FROM books WHERE TITLE = '$bookType'";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
        // Display table headers
        echo "<tr>";
        foreach ($tableHeaders as $header) {
            echo "<th>$header</th>";
        }
        echo "</tr>";

        // Fetch rows from the result set and construct HTML content for table rows
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['TITLE']."</td>";
            echo "<td>".$row['AUTHOR']."</td>"; 
            echo "<td>".$row['PUBLISHER']."</td>"; 
            echo "<td>".$row['COPYRIGHT']."</td>";
            echo "<td>".$row['SUBJECT_AREA']."</td>";
            echo "<td>".$row['KEY_STAGE']."</td>";
            echo "<td>".$row['SOURCE']."</td>";
            echo "<td>".$row['FORMAT']."</td>";
            echo "<td>".$row['CLASSIFICATION_NO']."</td>";
            echo "<td>".$row['bookID']."</td>";
            echo "<td>".$row['STATUS']."</td>";
            echo "</tr>";
        }
    } else {
        // If no results found, display a message
        echo "<tr><td colspan='13'>No books found</td></tr>";
    }
} else {
    // If bookType parameter is not provided, display a message
    echo "<tr><td colspan='13'>Please select a book type</td></tr>";
}

// Close the database connection
mysqli_close($conn);
?>
