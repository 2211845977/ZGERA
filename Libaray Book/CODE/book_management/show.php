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

  // الغرض من القسم الاساسي والصفحة الفرعية جعل الشريط الجانبي مفتوح علي الادارة المطلوبة 
  $currentPage = "book-management"; // القسم الأساسي 
  $subPage = "show"; // الصفحة الفرعية 
  
  include "../sidebar.php";

  ?>
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item active">Management Books</li>
          <li class="breadcrumb-item active">Show Books</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="row">
              <h5 class="card-title">Books Table</h5>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col" class="text-nowrap">#</th>
                    <th scope="col" class="text-nowrap" style="text-align: center;">Book Title</th>
                    <th scope="col" style="text-align: center;">Description</th>
                    <th scope="col" style="text-align: center;">Author</th>
                    <th scope="col" style="text-align: center;">Publisher</th>
                    <th scope="col" class="text-nowrap" style="text-align: center;">Publication Year</th>
                    <th scope="col" class="text-nowrap" style="text-align: center;">Category Name</th>
                    <th scope="col" style="text-align: center;">Language</th>
                    <th scope="col" class="text-nowrap" style="text-align: center;">Copies Count</th>
                    <th scope="col" colspan="2" style="text-align: center;">Action</th>
                  </tr>
                </thead>
                <tbody id="body">
                  <!-- هنا سيتم عرض الكتب باستخدام الاجاكس -->
                  <script>
                    $(document).ready(function () {

                      $.ajax({
                        type: 'GET',
                        url: 'get_book.php',
                        dataType: 'html',

                        success: function (result) {
                          console.log(result);
                          $('#body').html(result);

                        },
                        error: function () {
                          alert("Failed to load books.");
                        }
                      });
                    });
                  </script>
                </tbody>
              </table>
            </div>
          </div>
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