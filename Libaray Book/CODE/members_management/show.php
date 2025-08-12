<!DOCTYPE html>
<html lang="ar">
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

  $currentPage = "members_management";
  $subPage = "show_members";
  include("../sidebar.php");
  ?>
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item active">Members Management</li>
          <li class="breadcrumb-item active">Show Members</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            <div class="row">
              <h5 class="card-title">Members Table</h5>
              <!-- Default Table -->
              <table class="table" id="membersTable">
                <thead>
                  <tr>
                    <th scope="col" style="text-align: center;">#</th>
                    <th scope="col" style="text-align: center;">Name</th>
                    <th scope="col" style="text-align: center;">Address</th>
                    <th scope="col" style="text-align: center;">Phone</th>
                    <th scope="col" style="text-align: center;">Email</th>
                    <th scope="col" colspan="2" style="text-align: center;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- سيتم ملء البيانات هنا عبر AJAX -->
                </tbody>
              </table>
              <!-- End Default Table Example -->
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
  <div class="overlay" id="overlay"></div>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      function loadMembers() {
        $.ajax({
          url: "fetch_members.php", // ملف PHP لجلب البيانات
          method: "GET",
          dataType: "json",
          success: function (data) {
            let rows = '';
            if (data.length > 0) {
              data.forEach((member, index) => {
                rows += `
                            <tr>
                                   <th scope='row' style='text-align: center;'>${index + 1}</th>
                                   <td style='text-align: center;'>${member.username}</td>
                                   <td style='text-align: center;' class='text-nowrap'>${member.address}</td>
                                   <td style='text-align: center;'>${member.phone}</td>
                                   <td style='text-align: center;'>${member.email}</td>
                                   <td style='text-align: center;'>
                                       <button type='button' class='btn btn-danger rounded-pill delete-member' data-id='${member.userid}'>Delete</button>
                                   </td>
                                   <td style='text-align: center;'>
                                       <a href='update_member.php?userid=${member.userid}' class='btn btn-warning rounded-pill'>Update</a>
                                   </td>
                               </tr>`;
              });
            } else {
              rows = `
                        <tr>
                            <td colspan="6" style="text-align: center; color: gray;">
                                No members found.
                            </td>
                        </tr>`;
            }
            $("#membersTable tbody").html(rows);
          },
          error: function () {
            alert("Error loading members data.");
          }
        });
      }
      loadMembers();
      // حذف عضو
      $(document).on("click", ".delete-member", function () {
        const memberId = $(this).data("id"); // الحصول على 'id' من الزر
        if (!memberId) {
          alert("Error: Member ID not found.");
          return;
        }
        if (confirm("Are you sure you want to delete this member?")) {
          $.ajax({
            url: "delete_member.php", // ملف الحذف
            method: "POST",
            data: { userid: memberId }, // إرسال المفتاح كـ 'userid'
            success: function (response) {
              alert(response);
              loadMembers(); // إعادة تحميل البيانات بعد الحذف
            },
            error: function () {
              alert("Error deleting member.");
            }
          });
        }
      });
    });
  </script>
</body>

</html>