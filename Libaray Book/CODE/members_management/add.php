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
  $currentPage = "members_management"; // القسم الأساسي 
  $subPage = "add_members"; // الصفحة الفرعية 
  include("../sidebar.php");

  // معالجة بيانات النموذج
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['username'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // استخدام استعلامات محضرة لضمان الأمان
    $stmt = $conn->prepare("INSERT INTO users (username, address, phone, role, email, password) 
                              VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $address, $phone, $role, $email, $password);

    if ($stmt->execute()) {
      echo "<script>alert('Member added successfully!');</script>";
    } else {
      echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
  }
  ?>
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item active">Management Members</li>
          <li class="breadcrumb-item active">Add Member</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add New Member</h5>
              <!-- Add new member form -->
              <form method="POST" action="">
                <div class="row mb-3">
                  <label for="name" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="address" class="col-sm-2 col-form-label">Address</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="phone" name="phone" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="role" class="col-sm-2 col-form-label">Role</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="role" name="role" required>
                      <option value="Members">Member</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="email" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="password" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End add new member form -->
            </div>
          </div>
        </div>
        <!-- End Left side columns -->
        <!-- Right side columns -->
        <div class="col-lg-4">
        </div>
        <!-- End Right side columns -->
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