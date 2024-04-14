<?php
session_start();
// Include the database connection file
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
    <!-- CSS -->
    <link rel="stylesheet" href="style/admin.css">
    <link rel="stylesheet" href="style/a_mobile.css">
    <link rel="stylesheet" href="toaster/toastr.min.css">
    <link rel="icon" type="image/x-icon" href="images/logo.png">

    <title>Library Hub | Dashboard</title>

</head>
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
                    <li class="text-white mb-2">
                    <i class="bi bi-house-door"></i>
                    <a href="a_dashboard.php" class="a text-decoration-none px-2">
                            Dashboard</a>
                    </li>

                    <li class="text-white mb-2">
                    <i class="bi bi-book"></i>
                    <a href="a_m_book.php" class="a text-decoration-none px-2">
                            Manage Books</a>
                    </li>

                    <li class="text-white mb-2">
                    <i class="bi bi-journal-bookmark"></i>
                    <a class="a text-decoration-none px-2 " 
                        href="a_issued.php">Issued Books</a>
                    </li>
                    <hr class="h-color mx-1">
                    <li class="text-white mb-2">
                        <i class="bi bi-hand-thumbs-up"></i>
                        <a class="a text-decoration-none px-2" href="a_BorrowReturn.php">User Preferences</a>
                    </li>
                    <li class="text-white mb-2">
                    <i class="bi bi-people"></i>
                    <a class="a text-decoration-none px-2 " 
                        href="a_user.php">User Management</a>
                    </li>
                </ul>

                <hr class="h-color mx-1">
                <ul class="list-unstyled px-3">
                    <li ><a href="logout.php" class="btn btn-danger text-white btn-sm px-3">LOGOUT</a></li>
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
           <section class="Dashboard">
            <div class="container">
                <h4 class="m-3">Dashboard</h4>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    <div class="col">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Online Users</h5>
                                <p class="card-text">
                                    <i class="bi bi-people"></i>
                                    <?php
                                    // Query to get the count of online users
                                    $online_users_query = "SELECT COUNT(*) AS online_users FROM u_management WHERE status = 'online'";
                                    $online_users_result = mysqli_query($conn, $online_users_query);
                                    $online_users_row = mysqli_fetch_assoc($online_users_result);
                                    echo $online_users_row['online_users'];
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">No of Books</h5>
                                <p class="card-text">
                                    <i class="bi bi-journal-bookmark"></i>
                                    <?php
                                    // Query to get the total number of books
                                    $total_books_query = "SELECT COUNT(*) AS total_books FROM books";
                                    $total_books_result = mysqli_query($conn, $total_books_query);
                                    $total_books_row = mysqli_fetch_assoc($total_books_result);
                                    echo $total_books_row['total_books'];
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Available Books</h5>
                                <p class="card-text">
                                    <i class="bi bi-bookmarks"></i>
                                    <?php
                                    // Query to get the count of available books
                                    $available_books_query = "SELECT COUNT(*) AS available_books FROM books WHERE status = 'available'";
                                    $available_books_result = mysqli_query($conn, $available_books_query);
                                    $available_books_row = mysqli_fetch_assoc($available_books_result);
                                    echo $available_books_row['available_books'];
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Borrowed Books</h5>
                                <p class="card-text">
                                    <i class="bi bi-book-half"></i>
                                    <?php
                                    // Calculate the count of borrowed books
                                    $borrowed_books_query = "SELECT COUNT(*) AS borrowed_books FROM books WHERE status != 'available'";
                                    $borrowed_books_result = mysqli_query($conn, $borrowed_books_query);
                                    $borrowed_books_row = mysqli_fetch_assoc($borrowed_books_result);
                                    echo $borrowed_books_row['borrowed_books'];
                                    ?>
                                </p>
                            </div>
                        </div>
                </div>

                </div>
            </div>
        </section>

        </div>
    </div>
 
    <script src="js/jquery.js"></script>    
    <!-- DOWNLOADED JS -->
    <script src="toaster/toastr.min.js"></script>
    <script src="sweetalert/alert.js"></script>
    <script src="bootstrap/boots.js"></script>
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