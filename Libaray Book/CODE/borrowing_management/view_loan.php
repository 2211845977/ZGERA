<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include "head.php";
  ?>
</head>

<body>
  <?php
  include "../header.php";
  include "../db_connct.php";
  // تحقق إذا كان المستخدم قد سجل الدخول
  if (!isset($_SESSION['user_id'])) {
    header("Location: /lib_sys/index.php");
    exit();
  }
  $currentPage = "borrowing_management";
  $subPage = "view_loan";
  include("../sidebar.php");
  ?>
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Borrowing Mangement</li>
          <li class="breadcrumb-item active">Show Borrowers</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            <h5 class="card-title">Borrowing Table</h5>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col" class="text-nowrap" style="text-align: center;">Book Name</th>
                  <th scope="col" class="text-nowrap" style="text-align: center;">Borrowed Name</th>
                  <th scope="col" class="text-nowrap" style="text-align: center;">By Employee</th>
                  <th scope="col" class="text-nowrap" style="text-align: center;">Borrow Date</th>
                  <th scope="col" class="text-nowrap" style="text-align: center;">Due Date</th>
                  <th scope="col" class="text-nowrap" style="text-align: center;">Return Date</th>
                  <th scope="col" colspan="2" style="text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // تنفيذ استعلام لجلب بيانات الإعارة
                $query = "SELECT bb.*, b.title, u.username, e.username as employee_name 
            FROM borrowedbooks bb
            JOIN books b ON bb.book_id = b.id
            JOIN users u ON bb.borrowed_id = u.userid
            LEFT JOIN users e ON bb.by_employee = e.userid
            WHERE bb.returned_date IS NULL OR bb.returned_date IS NOT NULL
            ORDER BY bb.borrowed_date DESC";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                  $index = 1;
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr id='row-{$row['id']}'>
                  <th scope='row' style='text-align: center;'>{$index}</th>
                  <td style='text-align: center;' class='text-nowrap'>{$row['title']}</td>
                  <td style='text-align: center;' class='text-nowrap'>{$row['username']}</td>
                  <td style='text-align: center;' class='text-nowrap'>{$row['employee_name']}</td>
                  <td style='text-align: center;' class='text-nowrap'>{$row['borrowed_date']}</td>
                  <td style='text-align: center;' class='text-nowrap'>{$row['due_date']}</td>
                  <td style='text-align: center;' class='text-nowrap'>{$row['returned_date']}</td>
                  <td><button onclick='confirmDelete({$row['id']})' class='btn btn-danger rounded-pill'>Delete</button></td>
                  <td><a href='update_content.php?id={$row['id']}' class='btn btn-warning rounded-pill'>Update</a></td>
                </tr>";
                    $index++;
                  }
                } else {
                  echo "<tr><td colspan='9' style='text-align: center;'>No records found</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- End Left side columns -->
      </div>
    </section>
  </main><!-- End #main -->
  <?php include "../footer.php"; ?>
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

  <script>
    function confirmDelete(id) {
      if (confirm('هل أنت متأكد من حذف هذه الإعارة؟')) {
        $.ajax({
          url: 'delete_loan.php',
          type: 'POST',
          data: { delete_id: id },
          dataType: 'json',
          success: function(data) {
            alert(data.message);
            if (data.status === 'success') {
              $('#row-' + id).remove();
              // إعادة ترقيم الصفوف
              $('tbody tr').each(function(index) {
                $(this).find('th:first').text(index + 1);
              });
            }
          },
          error: function() {
            alert('حدث خطأ أثناء حذف الإعارة');
          }
        });
      }
    }
  </script>
</body>

</html>