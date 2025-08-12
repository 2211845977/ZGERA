<!DOCTYPE html>
<html lang="en">
<?php include "head.php";
include "../db_connct.php";
// تحقق إذا كان المستخدم قد سجل الدخول
if (!isset($_SESSION['user_id'])) {
    // إذا لم يكن قد سجل الدخول، أعد التوجيه إلى صفحة الولوج
    header("Location: /lib_sys/index.php");  // أو رابط صفحة الولوج الخاصة بك
    exit();  // تأكد من توقف السكربت بعد إعادة التوجيه
}
?>

<body>
    <?php
    include "../header.php";
    $currentPage = "employees-management";
    $subPage = "show_employees";
    include("../sidebar.php");
    ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item active">Employees Management</li>
                    <li class="breadcrumb-item active">Show Employees</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">
                        <h5 class="card-title">Employees Table</h5>

                        <!-- Default Table -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" colspan="2" style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch query
                                $query = "SELECT userid, username, address, phone, email FROM users WHERE role='Employee'";

                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    $counter = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $counter++ . "</td>";
                                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td><a href='update.php?id=" . $row['userid'] . "' class='btn btn-warning'>Edit</a></td>";
                                        echo "<td><button class='btn btn-danger delete-btn' data-id='" . $row['userid'] . "'>Delete</button></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' style='text-align:center;'>No employees found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- End Default Table Example -->
                    </div>
                </div>
                <!-- End Left side columns -->
            </div>
        </section>
    </main><!-- End #main -->

    <?php include "../footer.php"; ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.min.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>

    <!-- DELETE AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.delete-btn').click(function () {
                var employeeId = $(this).data('id');

                // Confirmation
                if (confirm('Are you sure you want to delete this employee?')) {
                    $.ajax({
                        url: 'delete.php',
                        method: 'POST',  // Changed to POST
                        data: { id: employeeId },
                        contentType: "application/x-www-form-urlencoded",
                        success: function (response) {
                            if (response.trim() === 'success') {
                                alert('Employee deleted successfully!');
                                $('button[data-id="' + employeeId + '"]').closest('tr').remove();
                            } else {
                                alert('Error deleting the employee.');
                            }
                        },
                        error: function () {
                            alert('Error in the AJAX request.');
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>
