<?php
session_start(); 
include 'db_connection.php';
?>

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

    <title>Library Hub | Issued Books</title>

</head>
<style>
    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th,
    .custom-table td {
        border: 1px solid #dddddd;
        padding: 6px;
        text-align: left;
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
</style>

<body>
    <!-- Start Side bar -->
    <div class="main-container d-flex">
        <div class="sidebar" id="side_nav">
            <div class="header-box p-1">
                <h1 class="text-center fw-bold mt-2">Library Hub</h1>
                <button class="btn d-md-none d-block close-btn px-1 py-0 text-white"><i
                        class="bi bi-justify"></i></button>
            </div>
            <div class="py-1">
                <ul class="list-unstyled px-3 mt-2">
                    <!-- Sidebar Content -->
                    <li class="text-white mb-2">
                        <i class="bi bi-house-door"></i>
                        <a href="a_dashboard.php" class="a text-decoration-none px-2">
                            Dashboard
                        </a>
                    </li>

                    <li class="text-white mb-2">
                        <i class="bi bi-book"></i>
                        <a href="a_m_book.php" class="a text-decoration-none px-2">
                            Manage Books
                        </a>
                    </li>

                    <li class="text-white mb-2">
                        <i class="bi bi-journal-bookmark"></i>
                        <a class="a text-decoration-none px-2" href="a_issued.php">
                            Issued Books
                        </a>
                    </li>
                    <hr class="h-color mx-1">
                    <li class="text-white mb-2">
                        <i class="bi bi-hand-thumbs-up"></i>
                        <a class="a text-decoration-none px-2" href="a_BorrowReturn.php">User Preferences</a>
                    </li>
                    <li class="text-white mb-2">
                        <i class="bi bi-people"></i>
                        <a class="a text-decoration-none px-2" href="a_user.php">
                            User Management
                        </a>
                    </li>
                </ul>

                <hr class="h-color mx-1">
                <ul class="list-unstyled px-3">
                    <li><a href="logout.php" class="btn btn-danger text-white btn-sm px-3">LOGOUT</a></li>
                </ul>
            </div>
        </div>
        <!-- End Side Bar -->
        <div class="content">
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <div class="d-flex justify-content-space-between">
                        <img class="logo mx-2" src="images/logo.png" alt="LOGO">
                        <button class="btn px-1 py0 open-btn"><i class="bi bi-justify d-md-none d-block"></i></button>
                    </div>
                </div>
            </nav>
            <section class="ManageBooks">
                <div class="container">
                    <h4 class="m-2">Issued Books</h4>
                    <div style="border-radius: 5px;padding:10px;background:#fff;" id="divvideo">
                        <table id="example1" class="custom-table">
                            <thead>
                                <tr>
                                    <th>Book #</th>
                                    <th>Title</th>
                                    <th>Borrower</th>
                                    <th>Contact No.</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                // Query for borrowed books
                                $borrowed_query = "SELECT * FROM b_borrowed";

                                // Query for returned books
                                $returned_query = "SELECT * FROM b_returned";

                                // Union both queries and order by date in descending order
                                $merged_query = "SELECT * FROM (($borrowed_query) UNION ALL ($returned_query)) AS merged_result ORDER BY date DESC";

                                $merged_result = mysqli_query($conn, $merged_query);

                                if (!empty($merged_result)) {
                                    foreach ($merged_result as $row) {
                                        echo "<tr>";
                                        echo "<td>".$row['book_id']."</td>"; 
                                        echo "<td>".$row['TITLE']."</td>";
                                        echo "<td>".$row['BORROWER']."</td>";
                                        echo "<td>".$row['CONTACT_NO']."</td>";
                                        echo "<td>".$row['STATUS']."</td>";
                                        echo "<td>".$row['date']."</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </section>
        </div>
    </div>

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
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.open-btn').on('click', function () {
                $('.sidebar').addClass('active');
            });

            $('.close-btn').on('click', function () {
                $('.sidebar').removeClass('active');
            });

            $(document).on('click', function (event) {
                if (!$(event.target).closest('.sidebar, .open-btn').length) {
                    $('.sidebar').removeClass('active');
                }
            });
        });
    </script>
</body>

</html>