<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    // Determine the destination based on the user's role
    if ($_SESSION['role'] == 'admin') {
        header("Location: a_dashboard.php"); // Redirect admins to admin dashboard
    } else {
        header("Location: main_menu.php"); // Redirect regular users to main menu
    }
    exit();
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate login credentials
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connect to the database
    $server = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "qrcodedb";

    $conn = new mysqli($server, $username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user details from the database based on the email and password
    $sql = "SELECT * FROM u_management WHERE EMAIL = '$email' AND PASSWORD = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $email; // Store email in session
        $_SESSION['role'] = $row['ROLE']; // Store role in session

        // Determine the destination based on the user's role
        if ($row['ROLE'] == 'admin') {
            header("Location: a_dashboard.php"); // Redirect admins to admin dashboard
        } else {
            header("Location: main_menu.php"); // Redirect regular users to main menu
        }
        exit();
    } else {
        $error_message = "Invalid email or password"; // Display error message if email or password is incorrect
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

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

    <title>Library Hub | Login</title>

</head>
<style>
         body {
            background-image: url('images/bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
</style>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <div class="d-flex justify-content-space-between">
            <a href="index.php"><img class="logo mx-2" src="images/logo.png" alt="LOGO"></a>
            </div>
            <button class="btn btn-sm btn-secondary"><a class="text-white text-decoration-none"
                    href="index.php">Back</a></button>
        </div>
    </nav>

    <!-- Login Start -->
    <section>
        <div class="container mt-5">
            <div class="register-wrap px-2">
                <div class="row mt-5">
                    <form method="post" class="mt-5">
                        <div class="col-lg-4 m-auto  wrapper p-3 rounded" style="background: rgba(0,0,0,0.3);">
                            <?php if (isset($error_message)) { ?>
                            <div class="alert alert-danger text-center" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                            <?php } ?>
                            <h1 class="text-center fw-bold text-white  p-2">Sign in</h1>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-envelope-fill text-dark"></i></span>
                                <input type="email" id="email" class="form-control" placeholder="Email" name="email"
                                    required><br>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-lock-fill text-dark"></i></span>
                                <input type="password" id="password" class="form-control" placeholder="Password"
                                    name="password" required><br><br>
                            </div>
                            <div class="mb-3 text-center">
                                <div class="col  mb-2">
                                    <button type="submit" class="btn btn-primary px-3">Login</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Login End -->

    <!-- DOWNLOADED JS -->  
    <script src="js/jquery.js"></script>
    <script src="toaster/toastr.min.js"></script>
    <script src="sweetalert/alert.js"></script>
    <script src="bootstrap/boots.js"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
</body>

</html>