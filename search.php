<style>
    .custom-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<?php
// Include your database connection file
include 'db_connection.php';

// Define table headers
$tableHeaders = ["Title", "Author", "Publisher", "Copyright", "Classification No", "Status"];

// Initialize default values for pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rowsPerPage = isset($_GET['rows']) ? intval($_GET['rows']) : 10;

// Calculate offset based on the current page
$offset = ($page - 1) * $rowsPerPage;

// Check if search query parameter is set
if(isset($_GET['search'])) {
    // Sanitize the search query to prevent SQL injection
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    // Construct SQL query to fetch books based on search query and pagination
    $sql = "SELECT * FROM books 
            WHERE TITLE LIKE '%$search%' OR AUTHOR LIKE '%$search%' OR PUBLISHER LIKE '%$search%' OR CLASSIFICATION_NO LIKE '%$search%' OR DATE_RECEIVED LIKE '%$search%' OR STATUS LIKE '%$search%'
            ORDER BY CASE WHEN TITLE LIKE 'A%' THEN 1 ELSE 2 END, TITLE
            LIMIT $rowsPerPage OFFSET $offset";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
        // Display table headers
        echo "<table class='custom-table'>";
        echo "<tr>";
        foreach ($tableHeaders as $header) {
            echo "<th style='background-color: #f2f2f2;'>$header</th>";
        }
        echo "</tr>";

        // Fetch and display rows
        $row_num = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $row_num++;
            echo "<tr " . ($row_num % 2 == 0 ? "class='even-row'" : "") . ">";
            echo "<td>".$row['TITLE']."</td>";
            echo "<td>".$row['AUTHOR']."</td>"; 
            echo "<td>".$row['PUBLISHER']."</td>"; 
            echo "<td>".$row['COPYRIGHT']."</td>";
            echo "<td>".$row['CLASSIFICATION_NO']."</td>";
            echo "<td>".$row['STATUS']."</td>";
            echo "</tr>";   
        }
        echo "</table>";
    } else {
        echo "<p>No books found</p>";
    }
} else {
    // If no search query parameter is provided, display a message
    echo "<p>Please enter a search query</p>";
}

mysqli_close($conn);
?>
