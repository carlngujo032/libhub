<?php
session_start(); 
include 'db_connection.php'; // Include database connection
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

    <title>Library Hub | User Management</title>

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
                        <a class="a text-decoration-none px-2" href="a_m_book.php">
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
            <section class="Adduser">
                <div class="container">
                    <h4 class="m-2">User Management</h4>
                    <div class="container">
                        <button id="openAddUserModal" class="btn  btn-sm btn-secondary mx-2">Add User</button>
                        <div class="row">

                            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-muted" id="exampleModalLabel">User Information
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="add_user.php" method="POST" class="row g-3">
                                                <div class="col-md-6">
                                                    <input type="text" id="fullName" name="fullName"
                                                        class="form-control" placeholder="Full Name" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" id="email" name="email" class="form-control"
                                                        placeholder="Email" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="contactNo" name="contactNo"
                                                        class="form-control" placeholder="Contact No" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="schoolName" name="schoolName" class="form-control" placeholder="School Name" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="lrn" name="lrn" class="form-control" placeholder="LRN (Learner Reference Number)">
                                                </div>
                                                <div class="col-md-6">
                                                    <select id="role" name="role" class="form-control" required>
                                                        <option value="">Select Role</option>
                                                        <option value="admin">Admin</option>
                                                        <option value="user">User</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="password" id="password" name="password"
                                                        class="form-control" placeholder="Password" required>
                                                </div>
                                               
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-sm btn-primary">Add
                                                        User</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Table for displaying users -->
                        <div style="border-radius: 5px;padding:10px;background:#fff;" id="divvideo">
                            <table id="example1" class="custom-table">
                                <thead>
                                    <tr>
                                        <th>LRN</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Contact No</th>
                                        <th>School</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                $sql = "SELECT * FROM u_management";
                                $result = mysqli_query($conn, $sql);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>".$row['LRN']."</td>";
                                        echo "<td>".$row['FULLNAME']."</td>";
                                        echo "<td>".$row['EMAIL']."</td>";
                                        echo "<td>".$row['CONTACT_NO']."</td>";
                                        echo "<td>".$row['SCHOOL_NAME']."</td>";
                                        echo "<td>".$row['ROLE']."</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-sm btn-primary mx-2 edit-user-btn' data-user-id='" . $row['id'] . "' data-toggle='modal' data-target='#editUserModal'>";
                                        echo "<i class='bi bi-pencil-fill'></i>";
                                        echo "</button>";
                                        echo "<button class='btn btn-sm btn-danger delete-user-btn' data-user-id='" . $row['id'] . "'>";
                                        echo "<i class='bi bi-trash-fill'></i>";
                                        echo "</button>";
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
        <section>
            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-muted" id="exampleModalLabel">Edit User Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="update_user.php" method="POST" class="row g-3">
                                <input type="hidden" id="editUserId" name="user_id">
                                <div class="col-md-6">
                                    <input type="text" id="editFullName" name="fullName" class="form-control"
                                        placeholder="Full Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" id="editEmail" name="email" class="form-control"
                                        placeholder="Email" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="editContactNo" name="contactNo" class="form-control"
                                        placeholder="Contact No" required>
                                </div>
                                <div class="col-md-6">
                                                    <input type="text" id="schoolName" name="schoolName" class="form-control" placeholder="School Name" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="lrn" name="lrn" class="form-control" placeholder="LRN (Learner Reference Number)">
                                                </div>
                                <div class="col-md-6">
                                    <select id="editRole" name="role" class="form-control" required>
                                        <option value="">Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">Update User</button>
                                </div>
                            </form>
                        </div>
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
            $(document).on('click', '.edit-user-btn', function () {
                var user_id = $(this).data('user-id');

                // Send AJAX request to fetch_user.php
                $.ajax({
                    url: 'fetch_user.php',
                    type: 'GET',
                    data: { user_id: user_id },
                    dataType: 'json',
                    success: function (user) {
                        if (user) {
                            // Populate the edit modal with user details
                            $('#editUserModal #editFullName').val(user.FULLNAME);
                            $('#editUserModal #editEmail').val(user.EMAIL);
                            $('#editUserModal #editContactNo').val(user.CONTACT_NO);
                            $('#editUserModal #schoolName').val(user.SCHOOL_NAME);
                            $('#editUserModal #lrn').val(user.LRN);
                            $('#editUserModal #editRole').val(user.ROLE);

                            // Store the user ID in a hidden input field
                            $('#editUserModal #editUserId').val(user.id);

                            // Show the edit modal
                            $('#editUserModal').modal('show');
                        } else {
                            alert('Failed to fetch user details');
                        }
                    },
                    error: function () {
                        alert('Failed to fetch user details');
                    }
                });
            });

</script>

        <script>
            $(document).on('click', '.delete-user-btn', function () {
                var user_id = $(this).data('user-id');

                // Display SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to delete_user.php
                        $.ajax({
                            url: 'delete_user.php',
                            type: 'POST',
                            data: { user_id: user_id },
                            dataType: 'json',
                            success: function (response) {
                                if (response.status === 'success') {
                                    // Display success message with SweetAlert
                                    Swal.fire(
                                        'Deleted!',
                                        'The user has been deleted.',
                                        'success'
                                    ).then((result) => {
                                        // Reload the page after successful deletion
                                        location.reload();
                                    });
                                } else {
                                    // Display error message with SweetAlert
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete user.',
                                        'error'
                                    );
                                }
                            },
                            error: function () {
                                // Display error message with SweetAlert
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete user.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        </script>

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
                function getQueryParam(name) {
                    const urlParams = new URLSearchParams(window.location.search);
                    return urlParams.get(name);
                }

                // Check if the message parameter exists and is equal to 'success'
                if (getQueryParam('message') === 'success') {
                    toastr.success('Success!');
                }
            });

            $(document).ready(function () {
                $('#openAddUserModal').click(function () {
                    $('#addUserModal').modal('show');
                });

                $('.close').click(function () {
                    $('#addUserModal').modal('hide');
                });

                $(document).on('click', function (event) {
                    if ($(event.target).hasClass('modal')) {
                        $('#addUserModal').modal('hide');
                    }
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