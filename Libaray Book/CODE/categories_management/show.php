<!DOCTYPE html>
<head>
<?php
include "head.php";  // تحديث المسار
include "../db_connct.php";

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
include "../header.php";  
$currentPage = "categories_management"; // القسم الأساسي 
$subPage = "show_categories"; // الصفحة الفرعية 
include "../sidebar.php";  
?>

<main id="main" class="main">

<div class="pagetitle">
 
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>  <!-- تحديث المسار -->
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
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Category Name</th>
              <th scope="col">Description</th>
              <th scope="col">Actions</th> <!-- إضافة عمود الأفعال -->
            </tr>
          </thead>
          <tbody id="categoriesTableBody">
            <!-- سيتم عرض البيانات هنا باستخدام AJAX -->
          </tbody>
        </table>
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
<script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>  <!-- تحديث المسار -->
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>  <!-- تحديث المسار -->
<script src="../assets/vendor/chart.js/chart.umd.js"></script>  <!-- تحديث المسار -->
<script src="../assets/vendor/echarts/echarts.min.js"></script>  <!-- تحديث المسار -->
<script src="../assets/vendor/quill/quill.min.js"></script>  <!-- تحديث المسار -->
<script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>  <!-- تحديث المسار -->
<script src="../assets/vendor/tinymce/tinymce.min.js"></script>  <!-- تحديث المسار -->
<script src="../assets/vendor/php-email-form/validate.js"></script>  <!-- تحديث المسار -->

<!-- Template Main JS File -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  <!-- إضافة مكتبة jQuery -->
<script src="../assets/js/main.js"></script>  <!-- تحديث المسار -->

<script>
  $(document).ready(function() {
    // استرجاع البيانات عبر AJAX عند تحميل الصفحة
    $.ajax({
      url: "get_categories.php",  // مسار الملف الذي يعيد البيانات
      type: "GET",
      dataType: "json",
      success: function(data) {
        // التحقق من وجود بيانات
        if (data.length > 0) {
          let rows = '';
          // إضافة البيانات إلى الجدول
          data.forEach(function(category) {
            rows += '<tr data-id="' + category.id + '">';
            rows += '<td>' + category.name + '</td>';
            rows += '<td>' + category.description + '</td>';
            // إضافة أزرار تعديل وحذف
            rows += '<td><a href="edit_category.php?id=' + category.id + '" class="btn btn-warning btn-sm">update</a>';
            rows += ' <button class="btn btn-danger btn-sm deleteBtn" data-id="' + category.id + '">delete</button></td>';
            rows += '</tr>';
          });
          // تحديث محتوى الجدول
          $('#categoriesTableBody').html(rows);
        } else {
          $('#categoriesTableBody').html('<tr><td colspan="3">لا توجد تصنيفات لعرضها.</td></tr>');
        }
      },
      error: function() {
        alert("حدث خطأ أثناء جلب البيانات.");
      }
    });

    // التعامل مع زر الحذف
    $(document).on('click', '.deleteBtn', function() {
      var categoryId = $(this).data('id');
      if (confirm('هل أنت متأكد أنك تريد حذف هذا التصنيف؟')) {
        // إرسال طلب الحذف باستخدام AJAX
        $.ajax({
          url: "delete_category.php",  // ملف الحذف
          type: "POST",
          data: { id: categoryId },
          success: function(response) {
            if (response === 'success') {
              alert('تم الحذف بنجاح!');
              // إزالة الصف من الجدول دون إعادة تحميل الصفحة
              $('tr[data-id="'+categoryId+'"]').remove();
            } else {
              alert('حدث خطأ أثناء الحذف.');
            }
          },
          error: function() {
            alert("حدث خطأ أثناء الاتصال بالخادم.");
          }
        });
      }
    });
  });
</script>

</body>
</html>
