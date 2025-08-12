<!DOCTYPE html>
<html lang="en">
<?php
include "head.php";
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
    $currentPage = "employees_management"; // القسم الأساسي
    $subPage = "update_employees"; // الصفحة الفرعية
    include("../sidebar.php");



    if (isset($_GET['id'])) {
        $userid = $_GET['id'];

        // Query to get the employee details based on userid
        $query = "SELECT * FROM users WHERE userid = '$userid' AND role = 'Employee'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $employee = mysqli_fetch_assoc($result);
        } else {
            echo "Employee not found.";
            exit;
        }
    }
    ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item active">Management Employees</li>
                    <li class="breadcrumb-item active">Update Employees</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Update Employee</h5>
                        </div>
                        <div class="card-body">
                            <form action="update_employee.php" method="POST">
                                <div class="mb-6">
                                    <label class="form-label" for="update-fullname">Full Name</label>
                                    <input type="text" class="form-control" id="update-fullname" name="fullname"
                                        value="<?php echo htmlspecialchars($employee['username']); ?>">
                                </div>
                                <div class="mb-6">
                                    <label class="form-label" for="update-email">Email</label>
                                    <input type="email" class="form-control" id="update-email" name="email"
                                        value="<?php echo htmlspecialchars($employee['email']); ?>">
                                </div>
                                <div class="mb-6">
                                    <label class="form-label" for="update-phone">Phone</label>
                                    <input type="text" class="form-control" id="update-phone" name="phone"
                                        value="<?php echo htmlspecialchars($employee['phone']); ?>">
                                </div>
                                <div class="mb-6">
                                    <label class="form-label" for="update-address">Address</label>
                                    <input type="text" class="form-control" id="update-address" name="address"
                                        value="<?php echo htmlspecialchars($employee['address']); ?>">
                                </div>
                                <div class="mb-6">
                                    <label class="form-label" for="update-password">Password</label>
                                    <input type="password" class="form-control" id="update-password" name="password"
                                        placeholder="*******">
                                </div>
                                <br>
                                <input type="hidden" name="userid" value="<?php echo $employee['userid']; ?>">
                                <!-- Hidden field for the userid -->
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Left side columns -->
            </div>
        </section>
    </main><!-- End #main -->

    <?php
    include "../footer.php";
    ?>
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

</body>

</html>