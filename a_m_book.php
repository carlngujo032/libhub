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

    <title>Library Hub | Manage Books</title>

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
            <section class="ManageBooks">
                <div class="container">
                    <h4 class="m-2">Manage Books</h4>
                    <button id="openAddBookModal" class="btn  btn-sm btn-secondary mx-2">Add Book</button>
                    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-muted" id="exampleModalLabel">Book Information</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="add_book.php" method="POST" class="row g-3">
                                        <div class="col-md-4">
                                            <input type="text" id="title" name="title" class="form-control"
                                                placeholder="Title" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="author" name="author" class="form-control" placeholder="Author" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="publisher" name="publisher" class="form-control" placeholder="Publisher" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="copyright" name="copyright" class="form-control" placeholder="Copyright" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="subject_area" name="subject_area" class="form-control" placeholder="Subject Area" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="key_stage" name="key_stage" class="form-control" placeholder="Key Stage" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="source" name="source" class="form-control" placeholder="Source" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="format" name="format" class="form-control" placeholder="Format" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="classification_no" name="classification_no" class="form-control" placeholder="Classification No." required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="isbn" name="isbn" class="form-control" placeholder="ISBN" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="bookID" name="bookID" class="form-control" placeholder="Accession No." required>
                                        </div>
                                         <div class="col-md-4">
                                            <select id="status" name="status" class="form-select" required>
                                                <option value="">Select Status</option>
                                                <option value="available">Available</option>
                                                <option value="unavailable">Unavailable</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="date" id="date_received" name="date_received" class="form-control" required>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-sm btn-primary">Add Book</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Book Modal -->
                    <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-muted" id="exampleModalLabel">Edit Book Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBookForm" class="row g-3">
                    <input type="hidden" id="editBookID" name="bookID">
                    <div class="col-md-4">
                        <input type="text" id="editTitle" name="title" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="editAuthor" name="author" class="form-control" placeholder="Author" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="editPublisher" name="publisher" class="form-control" placeholder="Publisher" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="editCopyright" name="copyright" class="form-control" placeholder="Copyright" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="editSubjectArea" name="subject_area" class="form-control" placeholder="Subject Area" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="editKeyStage" name="key_stage" class="form-control" placeholder="Key Stage" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="editSource" name="source" class="form-control" placeholder="Source" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="editFormat" name="format" class="form-control" placeholder="Format" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="editClassificationNo" name="classification_no" class="form-control" placeholder="Classification No." required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="editISBN" name="isbn" class="form-control" placeholder="ISBN" required>
                    </div>
                    <div class="col-md-4">
                        <select id="editStatus" name="status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="date" id="editDateReceived" name="date_received" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-sm btn-primary">Update Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


                    <div style="border-radius: 5px;padding:10px;background:#fff;" id="divvideo">
                        <table id="example1" class="custom-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Publisher</th>
                                    <th>Copyright</th>
                                    <th>Subject Area</th>
                                    <th>Key Stage</th>
                                    <th>Source</th>
                                    <th>Format</th>
                                    <th>Classification No.</th>
                                    <th>Accession No.</th>
                                    <th>ISBN</th>
                                    <th>Date Received</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sql = "SELECT * FROM books";
                                $result = mysqli_query($conn, $sql);
                                if ($result && mysqli_num_rows($result) > 0) {
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
                                        echo "<td>".$row['ISBN']."</td>";    
                                        echo "<td>".$row['DATE_RECEIVED']."</td>";
                                        echo "<td>".$row['STATUS']."</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-sm btn-primary edit-book-btn' data-book-id='".$row['bookID']."' data-toggle='modal' data-target='#editBookModal'>Edit</button>";
                                        echo "<button class='btn btn-sm btn-danger mx-2 delete-book-btn' data-book-id='".$row['bookID']."'>Delete</button>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='13'>No books found</td></tr>";
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
    $(document).on('click', '.delete-book-btn', function () {
        var bookID = $(this).data('book-id');

        // Display SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to delete_book.php
                $.ajax({
                    url: 'delete_book.php',
                    type: 'POST',
                    data: { bookID: bookID },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            // Display success message with SweetAlert
                            Swal.fire(
                                'Deleted!',
                                'The book has been deleted.',
                                'success'
                            ).then((result) => {
                                // Reload the page after successful deletion
                                location.reload();
                            });
                        } else {
                            // Display error message with SweetAlert
                            Swal.fire(
                                'Error!',
                                'Failed to delete book.',
                                'error'
                            );
                        }
                    },
                    error: function () {
                        // Display error message with SweetAlert
                        Swal.fire(
                            'Error!',
                            'Failed to delete book.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>

</script>

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
            function getQueryParam(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }

            // Check if the message parameter exists and is equal to 'success'
            if (getQueryParam('message') === 'success') {
                toastr.success('Book added successfully!');
            }
        });

        $(document).ready(function () {
            $('#openAddBookModal').click(function () {
                $('#addBookModal').modal('show');
            });

            $('.close').click(function () {
                $('#addBookModal').modal('hide');
            });

            $(document).on('click', function (event) {
                if ($(event.target).hasClass('modal')) {
                    $('#addBookModal').modal('hide');
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
</body>

</html>

