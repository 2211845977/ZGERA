<!DOCTYPE html>
<html lang="ar"> 

<head>
<?php
include "../db_connct.php";
include "head.php"; 
// تحقق إذا كان المستخدم قد سجل الدخول
if (!isset($_SESSION['user_id'])) {
  // إذا لم يكن قد سجل الدخول، أعد التوجيه إلى صفحة الولوج
  header("Location: /lib_sys/index.php");  // أو رابط صفحة الولوج الخاصة بك
  exit();  // تأكد من توقف السكربت بعد إعادة التوجيه
}
?>

</head>

<body>
<?php
include "../header.php";  // تحديث المسار
$currentPage = "categories_management"; // القسم الأساسي 
$subPage = "add_categories"; // الصفحة الفرعية 
include "../sidebar.php";  // تحديث المسار
?>

<main id="main" class="main">

<div class="pagetitle">

  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>  
      <li class="breadcrumb-item active">Categories management</li>
      <li class="breadcrumb-item active">Show Categories</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">
        <form id="categoryForm">
          <div class="mb-3">
            <label for="name" class="form-label"> Classification </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter the Book Category">
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>

          <div style="text-align: center;">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
        </form>
      </div>
    </div>
    <!-- End Left side columns -->

  </div>
</section>

</main><!-- End #main -->

<?php
include "../footer.php";  // تحديث المسار
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
<!-- إضافة مكتبة jQuery (لاستخدام AJAX) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../assets/js/main.js"></script>  

<script>
  // التعامل مع إرسال البيانات باستخدام AJAX
  $(document).ready(function() {
    $("#categoryForm").submit(function(event) {
      event.preventDefault(); // منع الإرسال التقليدي للنموذج

      // الحصول على القيم من النموذج
      var name = $("#name").val();
      var description = $("#description").val();

      // التحقق من الحقول
      if (name == "" || description == "") {
        alert("الرجاء ملء جميع الحقول.");
        return false; // إيقاف العملية إذا كانت الحقول فارغة
      }

      // إرسال البيانات باستخدام AJAX إلى الملف الجديد
      $.ajax({
        url: "add_category.php", // المسار إلى الملف الجديد
        type: "POST",
        data: { name: name, description: description },
        success: function(response) {
          console.log(response);
           // عرض التنبيه بناءً على الاستجابة من السيرفر
           if (response.trim() === "success") {
            alert("تم إضافة التصنيف بنجاح!");
            $("#name").val(""); // مسح الحقول بعد الإضافة
            $("#description").val("");
            window.location.href = "show.php";  // إعادة التوجيه إلى صفحة العرض بعد التعديل
          } else {
            alert("حدث خطأ أثناء إضافة التصنيف. حاول مرة أخرى.");
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
