<?php
session_start();

// Establishing a database connection
$server = "localhost";
$username = "root";
$db_password = "";
$dbname = "qrcodedb";

$conn = new mysqli($server, $username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate login credentials
    $email = $_POST['email'];
    // Password is no longer used for logging in

    // Fetch user details from the database based on the email
    $sql = "SELECT * FROM u_management WHERE EMAIL = '$email'";
    $result = mysqli_query($conn, $sql); // Use $conn for the mysqli_query function

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $email; // Store email in session
        $_SESSION['role'] = $row['ROLE']; // Store role in session

        // Redirect to main_menu.php
        header("Location: main_menu.php");
        exit();
    } else {
        $error_message = "User not found"; // Display error message if user is not found
    }
}

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

    <title>Library Hub | ReturnBorrow</title>

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
                        <a class="a text-decoration-none px-2 " href="a_issued.php">Issued Books</a>
                    </li>
                    <hr class="h-color mx-1">
                    <li class="text-white mb-2">
                        <i class="bi bi-hand-thumbs-up"></i>
                        <a class="a text-decoration-none px-2" href="a_BorrowReturn.php">User Preferences</a>
                    </li>
                    <li class="text-white mb-2">
                        <i class="bi bi-people"></i>
                        <a class="a text-decoration-none px-2 " href="a_user.php">User Management</a>
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
            <section class="main-menu">
                <div class="container">
                    <h4 class="m-2">Library Transactions</h4>
                    <div class="row mt-4">
                        <div class="col-md-2 col-lg-4 mb-4">
                            <div class="card bg-light p-4">
                                <div class="text-center mb-3">
                                    <h5>Scan QR Code</h5>
                                </div>
                                <video id="preview" width="100%" height="auto" class="rounded"></video>
                                <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    <i class="fa fa-exclamation-circle"></i>
                                    <?= $_SESSION['error'] ?>
                                </div>
                                <?php unset($_SESSION['error']); ?>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success mt-3" role="alert">
                                    <i class="fa fa-check-circle"></i>
                                    <?= $_SESSION['success'] ?>
                                </div>
                                <?php unset($_SESSION['success']); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-10 col-lg-8">
                            <div class="card bg-light p-4">
                            <?php if (isset($_SESSION['message'])): ?>
                                <div class="container">
                                    <?php if (strpos($_SESSION['message'], 'successfully borrowed') !== false || strpos($_SESSION['message'], 'successfully returned') !== false): ?>
                                        <!-- Success message -->
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Success!</strong> <?= $_SESSION['message'] ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php else: ?>
                                        <!-- Warning message -->
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>Warning!</strong> <?= $_SESSION['message'] ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php unset($_SESSION['message']); ?>
                            <?php endif; ?>

                            <form action="BorrowReturnBook.php" method="post" class="form-horizontal" style="border-radius: 5px;padding:10px;background:#fff;" id="form">
                                    <input type="text" name="bookId" id="text" placeholder="Scan QR Code of the book" class="form-control mb-2" autofocus>
                                    <label><i class="bi bi-info-circle text-dark"></i> Status:</label><br>
                                    <label class="form-check-label"><input class="form-check-input" type="radio" name="status" value="borrow" checked> Borrow</label>
                                    <label class="form-check-label"><input class="form-check-input" type="radio" name="status" value="return"> Return</label>
                                </form>
                            </div>
                        </div>
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

    <script src="js/instascan.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found');
                    alert('No cameras found. Please ensure your camera is connected and accessible.');
                }
            }).catch(function (e) {
                console.error('Error accessing camera:', e);
                alert('Error accessing camera. Please check your browser permissions and camera settings.');
            });

            scanner.addListener('scan', function (content) {
                document.getElementById('text').value = content;
                var action = document.querySelector('input[name="status"]:checked').value;
                document.getElementById('form').action = "BorrowReturnBook.php?action=" + action;
                document.getElementById('form').submit();
            });
        });
    </script>

</body>

</html>