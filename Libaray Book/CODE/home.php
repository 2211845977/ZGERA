<!DOCTYPE html>
<html lang="en">
<?php
include "db_connct.php";
include "head.php";
// تحقق إذا كان المستخدم قد سجل الدخول
if (!isset($_SESSION['user_id'])) {
    // إذا لم يكن قد سجل الدخول، أعد التوجيه إلى صفحة الولوج
    header("Location: /lib_sys/index.php");  // أو رابط صفحة الولوج الخاصة بك
    exit();  // تأكد من توقف السكربت بعد إعادة التوجيه
}
?>

<body>

    <?php
    $currentPage = "home";
    include "header.php";
    include "sidebar.php";
    include "dashbord.php";
    include "footer.php";

    ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>


</body>