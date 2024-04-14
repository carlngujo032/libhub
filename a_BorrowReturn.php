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
                        <button class="btn px-1 py0 open-btn"><i
                                class="bi bi-justify d-md-none d-block"></i></button>
                    </div>
                </div>
            </nav>
            <section class="Dashboard">
                <div class="container">
                    <h4 class="m-2">BorrowReturn</h4>
                    <div class="container">
                        <div class="row">
                            <div style="border-radius: 5px;padding:10px;background:#fff;" id="divvideo">
                                <table id="example1" class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>LRN</th>
                                            <th>Full Name</th>
                                            <th>Contact No</th>
                                            <th>School</th>
                                            <th>Scan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = "SELECT * FROM u_management WHERE ROLE = 'user'";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>".$row['LRN']."</td>";
                                                echo "<td>".$row['FULLNAME']."</td>";
                                                echo "<td>".$row['CONTACT_NO']."</td>";
                                                echo "<td>".$row['SCHOOL_NAME']."</td>";
                                                echo "<td>";
                                                echo "<form method='post'>";
                                                echo "<input type='hidden' name='email' value='".$row['EMAIL']."'>";
                                                echo "<button type='submit' class='btn btn-sm btn-dark'><i class='bi bi-qr-code-scan'></i></button>";


                                                echo "</form>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>No users found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
                "columnDefs": [
                    { "type": "num", "targets": [0,1,2] }
                ]
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
