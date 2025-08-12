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
  $currentPage = "employees-management"; // القسم الأساسي
  $subPage = "add_employees"; // الصفحة الفرعية
  include("../sidebar.php");

  ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item active">managment employees </li>
          <li class="breadcrumb-item active">add employees</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="card mb-6">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Add Employee</h5>
            </div>
            <div class="card-body">
              <form method="POST" action="">
                <div class="mb-6">
                  <label class="form-label" for="update-fullname">Full name</label>
                  <input type="text" class="form-control" id="update-fullname" placeholder="John Doe" name="name">
                </div>
                <div class="mb-6">
                  <label class="form-label" for="update-email">Email</label>
                  <input type="email" class="form-control" id="update-email" placeholder="example@gmail.com"
                    name="email">
                </div>
                <div class="mb-6">
                  <label class="form-label" for="update-phone">Phone</label>
                  <input type="text" class="form-control" id="update-phone" placeholder="0912345678" name="phone">
                </div>
                <div class="mb-6">
                  <label class="form-label" for="update-address">Address</label>
                  <input type="text" class="form-control" id="update-address" placeholder="123 Main Street"
                    name="address">
                </div>
                <div class="mb-6">
                  <label class="form-label" for="update-password">Password</label>
                  <input type="password" class="form-control" id="update-password" placeholder="*******"
                    name="password">
                </div>
                <br>
                <button type="submit" class="btn btn-primary" name="submit">Add</button>
              </form>
            </div>
          </div>

        </div>
        <!-- End Left side columns -->


        <!-- Right side columns -->
        <div class="col-lg-4">

        </div>
        <!-- End Right side columns -->

        <?php

        if (isset($_POST['submit'])) {
          $name = $_POST['name'];
          $phone = $_POST['phone'];
          $password = $_POST['password'];
          $address = $_POST['address'];
          $email = $_POST['email'];

          $sql = "INSERT INTO users (username ,email,phone,address ,password,role)
      VALUES ('$name','$email','$phone','$address','$password','Employee') ";

          if (mysqli_query($conn, $sql)) {
            echo '<script>
        alert("Employee added successfully!");
        window.location.href = "show.php"; 
    </script>';

          } else {
            echo '<script>
        alert("Failed to add the Employee!");
    </script>';
          }
          mysqli_close($conn);
        }



        ?>
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