<!DOCTYPE html>
<html lang="en">
<?php 
include "../db_connct.php"; // الاتصال بقاعدة البيانات
include "head.php";
// تحقق إذا كان المستخدم قد سجل الدخول
if (!isset($_SESSION['user_id'])) {
  // إذا لم يكن قد سجل الدخول، أعد التوجيه إلى صفحة الولوج
  header("Location: /lib_sys/index.php");  // أو رابط صفحة الولوج الخاصة بك
  exit();  // تأكد من توقف السكربت بعد إعادة التوجيه
}
?>
<body>
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" onerror="this.onerror=null; this.src='../assets/img/logo.png';" alt="صورة">
        <span class="d-none d-lg-block">Library System</span>
      </a>
    </div>
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" onerror="this.onerror=null; this.src='../assets/img/profile-img.jpg';" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['username']; ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>member name</h6>
              <span>member</span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
            <a class="dropdown-item d-flex align-items-center" href="/lib_sys/logout.php?logout=true">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>
  
  <main id="main" class="main">
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-8">
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            Hello again, <?php echo $_SESSION['username']; ?>!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">List of books you have borrowed:</h5>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name of Book</th>
                    <th scope="col">Borrow Date</th>
                    <th scope="col">Due Date</th>
                  </tr>
                </thead>
                <tbody id="borrowedBooksTable">
                  <!-- سيتم تحميل البيانات هنا -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      function loadBorrowedBooks() {
        $.ajax({
          url: 'get_borrowedbooks.php',
          method: 'GET',
          success: function(response) {
            $('#borrowedBooksTable').html(response);
          },
          error: function() {
            $('#borrowedBooksTable').html('<tr><td colspan="4">Error loading data.</td></tr>');
          }
        });
      }
      loadBorrowedBooks();
    });

  </script>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
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
