<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- DOWNLOADED CSS -->
    <link rel="stylesheet" href="bootstrap/boots.css">
    <link rel="stylesheet" href="fontawesome/all.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome.min.css">
    <link rel="stylesheet" href="bootstrap-icons-1.11.1/bootstrap-icons.css">
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="style/admin.css">
    <link rel="stylesheet" href="style/a_mobile.css">
    <link rel="stylesheet" href="toaster/toastr.min.css">
    <link rel="icon" type="image/x-icon" href="images/logo.png">

    <title>Library Hub</title>

</head>
<style>
    body {
        background-image: url('images/bg.jpg');
        background-repeat: no-repeat;
        background-size: cover;

    }

    /* Table styles */
    table.custom-table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    table.custom-table th,
    table.custom-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        border: 1px solid #dddddd;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .custom-table th {
    background-color: #f2f2f2;
    }

    .custom-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Table hover effect */
    table.custom-table tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <div class="d-flex justify-content-space-between">
                <a href="index.php"><img class="logo mx-2" src="images/logo.png" alt="LOGO"></a>
            </div>
            <p class="text-white fs-2 mt-2 fw-bold">Division of Lapu-Lapu Library Hub Management System</p>
            <button class="btn btn-sm btn-secondary"><a class="text-white text-decoration-none"
                    href="login.php">LOGIN</a></button>
        </div>
    </nav>


    <section class="mt-4 mx-auto">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="input-group">
                        <input type="text" class="form-control"
                            style="border-top-left-radius: 50px; border-bottom-left-radius: 50px;"
                            placeholder="Search..." id="searchInput">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-3"
                                style="border-top-right-radius: 50px; border-bottom-right-radius: 50px;"
                                id="searchBtn"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="input-group rounded">
                        <select class="custom-select px-2" id="bookType">
                            <option value="">All</option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="filterBtn">Filter</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-1 rounded" id="tableContainer">
                <table class="table" id="bookTable">
                    <thead>
                        <tr>
                            <!-- Table headers will be populated dynamically -->
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Table rows will be populated dynamically -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12" class="text-end ">
                                <button class="btn btn-sm btn-primary mr-2" id="prevBtn">Previous</button>
                                <button class="btn btn-sm btn-primary" id="nextBtn">Next</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        </div>
    </section>
    <!-- DOWNLOADED JS -->
    <script src="js/jquery.js"></script>
    <script src="toaster/toastr.min.js"></script>
    <script src="sweetalert/alert.js"></script>
    <script src="bootstrap/boots.js"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Variables
            var currentPage = 1; // Initialize current page
            var totalRows = 0; // Total number of rows
            var rowsPerPage = 10; // Number of rows per page

            // Hide the sort button initially
            $('#sortBtn').hide();
            // Hide pagination initially
            $('#prevBtn').hide();
            $('#nextBtn').hide();

            // Function to perform AJAX search
            function performSearch() {
                var searchQuery = $('#searchInput').val();
                var bookType = $('#bookType').val(); // Get the selected book type
                if (searchQuery.length > 0) {
                    $('#tableContainer').show(); // Show the table container
                    $('#prevBtn').show(); // Show pagination buttons
                    $('#nextBtn').show(); // Show pagination buttons
                    $.ajax({
                        type: "GET",
                        url: "search.php",
                        data: {
                            search: searchQuery,
                            bookType: bookType,
                            page: currentPage, // Pass the current page number
                            rows: rowsPerPage   // Pass the number of rows per page
                        },
                        success: function (response) {
                            $('#tableBody').html(response);
                            updatePagination(); // Update pagination buttons
                        }
                    });
                } else {
                    $('#tableContainer').hide(); // Hide the table container if search query is empty

                    $('#prevBtn').hide(); // Hide pagination buttons
                    $('#nextBtn').hide(); // Hide pagination buttons
                    // Reset pagination
                    currentPage = 1;
                    updatePagination(); // Update pagination buttons
                }
            }

            // Update pagination buttons
            function updatePagination() {
                var totalPages = Math.ceil(totalRows / rowsPerPage);
                $('#prevBtn').prop('disabled', currentPage === 1);
                $('#nextBtn').prop('disabled', currentPage === totalPages);
            }

            // Next button click event
            $('#nextBtn').click(function () {
                currentPage++;
                performSearch(); // Perform search for the next page
            });

            // Previous button click event
            $('#prevBtn').click(function () {
                currentPage--;
                if (currentPage < 1) {
                    currentPage = 1; // Ensure current page is not less than 1
                }
                performSearch(); // Perform search for the previous page
            });

            // Perform search on button click
            $('#searchBtn').click(function () {
                performSearch();
            });

            // Perform search on typing
            $('#searchInput').on('input', function () {
                performSearch();
            });

            // Initially perform search to load data
            performSearch();
        });
    </script>


</body>

</html>