<!DOCTYPE html>
<html lang="en">
<?php
 include "head.php";
 ?>
<body>

<?php
 include "../header.php";
$currentPage = "book_mangment"; // القسم الأساسي
$subPage = "add_book"; // الصفحة الفرعية
include "../sidebar.php";
include "../db_connct.php";
?>


<!-- جلب البيانات من قاعدة البيانات لوضعها في الفورم -->
<?php
$book_id = $_GET['id'];
    
    
    $query = "SELECT * FROM books WHERE id = $book_id";
    $result = mysqli_query($conn, $query);

    
    if ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $description = $row['description'];
        $author = $row['author'];
        $publisher = $row['publisher'];
        $publish_year = $row['publish_year'];
        $category_name = $row['category_name'];
        $language = $row['language'];
        $copies = $row['copies'];
    } else {
        echo "<div class='alert alert-danger'>Book not found!</div>";
        exit();
    }
      
    
?>

 
 <main id="main" class="main">

<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
      <li class="breadcrumb-item active">mangment books</li>
      <li class="breadcrumb-item active">update book</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-8">
    <div class="row">
    <div class="card">
            <div class="card-body">
              <h5 class="card-title">Update book</h5>

              <!-- edit book -->
               <form method="POST">
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Book Title</label>
        <div class="col-sm-10">
            <input type="text" name="title" class="form-control" value="<?php echo $title; ?>" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-10">
            <textarea name="description" class="form-control" required><?php echo $description; ?></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Author</label>
        <div class="col-sm-10">
            <input type="text" name="author" class="form-control" value="<?php echo $author; ?>" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Publisher</label>
        <div class="col-sm-10">
            <input type="text" name="publisher" class="form-control" value="<?php echo $publisher; ?>" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Publish Year</label>
        <div class="col-sm-10">
            <input type="text" name="publish_year" class="form-control" value="<?php echo $publish_year; ?>" required>
        </div>
    </div>

    <div class="row mb-3">
                <label for="selectExample" class="col-sm-3 col-form-label text-nowrap" >Select categories</label>
                 <div class="col-sm-9">
                 <select class="form-select form-control" id="selectExample" name="category_name">
                 <option ><?php echo $category_name; ?></option>
                 <?php
                        // الاستعلام لجلب الفئات من قاعدة البيانات
                        $query = "SELECT  `name`FROM `categories`";
                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                              echo "<option value='" .($row['name']) . "'>" . ($row['name']) . "</option>";

                            }
                        } else {
                            echo "<option value=''>Error fetching categories</option>";
                        }
                        ?>
                 </select>
                 </div>
                </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Language</label>
        <div class="col-sm-10">
            <input type="text" name="language" class="form-control" value="<?php echo $language; ?>" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Copies</label>
        <div class="col-sm-10">
            <input type="number" name="copies" class="form-control" value="<?php echo $copies; ?>" required>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary" name ="save">Save</button>
        <a href="show_book.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>
              <!-- End edit book -->

            </div>
          </div>
      </div>
    </div>
    <!-- End Left side columns -->


  </div>
</section>

</main><!-- End #main -->


<!-- تنفيذ الامر بعد الضفط علي زر save  -->
<?php
if (isset($_POST["save"])) {
  
  $title = $_POST['title'];
  $description = $_POST['description'];
  $author = $_POST['author'];
  $publisher = $_POST['publisher'];
  $publish_year = $_POST['publish_year'];
  $category_name = $_POST['category_name'];
  $language = $_POST['language'];
  $copies = $_POST['copies'];

  
  $update_query = "UPDATE books SET 
                  title='$title', 
                  description='$description', 
                  author='$author', 
                  publisher='$publisher', 
                  publish_year='$publish_year', 
                  category_name='$category_name', 
                  language='$language', 
                  copies='$copies'
                  WHERE id='$book_id'";

if (mysqli_query($conn, $update_query)) {
    echo '<script>
        alert("Book updated successfully!");
        window.location.href = "show_book.php"; 
    </script>';
} else {
    echo '<script>
        alert("Failed to update the book!");
    </script>';
}
}
?>



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





  
</body>
</html>