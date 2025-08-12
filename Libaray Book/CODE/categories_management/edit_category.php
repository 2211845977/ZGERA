<?php
include "head.php"; 
include "../db_connct.php";  // الاتصال بقاعدة البيانات
// تحقق إذا كان المستخدم قد سجل الدخول
if (!isset($_SESSION['user_id'])) {
  // إذا لم يكن قد سجل الدخول، أعد التوجيه إلى صفحة الولوج
  header("Location: /lib_sys/index.php");  // أو رابط صفحة الولوج الخاصة بك
  exit();  // تأكد من توقف السكربت بعد إعادة التوجيه
}
// التحقق من وجود معرف التصنيف
if (isset($_GET['id'])) {
  $categoryId = $_GET['id'];

  // استرجاع البيانات من قاعدة البيانات بناءً على المعرف
  $query = "SELECT * FROM categories WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $categoryId);
  $stmt->execute();
  $result = $stmt->get_result();
  $category = $result->fetch_assoc();

  // التحقق من وجود التصنيف
  if (!$category) {
    echo "التصنيف غير موجود.";
    exit;
  }
} else {
  echo "معرف التصنيف مفقود.";
  exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php
include "../header.php";
include "../sidebar.php";
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        <li class="breadcrumb-item active">Categories management</li>
        <li class="breadcrumb-item active">Edit Category</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <form id="categoryForm">
            <div class="mb-3">
              <label for="name" class="form-label">Classification</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="ادخل تصنيف الكتاب" value="<?= isset($category) ? $category['name'] : ''; ?>">
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3"><?= isset($category) ? $category['description'] : ''; ?></textarea>
            </div>

            <input type="hidden" id="categoryId" name="categoryId" value="<?= isset($category) ? $category['id'] : ''; ?>">

            <!-- <button type="submit" class="btn btn-primary">update </button> -->
                    <div style="text-align: center;">
                        <button type="submit" class="btn btn-primary">update</button>
                    </div>

          </form>
        </div>
      </div>
    </div>
  </section>

</main>

<?php
include "../footer.php";
?>

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

<script>
  // التعامل مع إرسال البيانات باستخدام AJAX
  $(document).ready(function() {
    $("#categoryForm").submit(function(event) {
      event.preventDefault(); // منع الإرسال التقليدي للنموذج

      // الحصول على القيم من النموذج
      var name = $("#name").val();
      var description = $("#description").val();
      var categoryId = $("#categoryId").val(); // معرف التصنيف

      // التحقق من الحقول
      if (name == "" || description == "") {
        alert("الرجاء ملء جميع الحقول.");
        return false; // إيقاف العملية إذا كانت الحقول فارغة
      }

      // إرسال البيانات باستخدام AJAX إلى الملف الجديد
      $.ajax({
        url: "update_categor.php", // المسار إلى الملف الجديد
        type: "POST",
        data: { id: categoryId, name: name, description: description },
        success: function(response) {
          console.log(response);
           // عرض التنبيه بناءً على الاستجابة من السيرفر
           if (response.trim() === "success") {
            alert("تم تعديل التصنيف بنجاح!");
            window.location.href = "show.php";  // إعادة التوجيه إلى صفحة العرض بعد التعديل
          } else {
            alert("حدث خطأ أثناء تعديل التصنيف. حاول مرة أخرى.");
          }
        },
        error: function() {
          alert("حدث خطأ في الاتصال بالخادم. حاول مرة أخرى.");
        }
      });
    });
  });
</script>

</body>
</html>
