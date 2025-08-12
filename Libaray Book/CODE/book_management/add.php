<!DOCTYPE html>
<html lang="en">
<?php
include "head.php";
include "../db_connct.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: /lib_sys/index.php");
  exit();
}
?>

<body>
  <?php
  include "../header.php";
  $currentPage = "book-management";
  $subPage = "add";
  include "../sidebar.php";
  ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item active">Management Books</li>
          <li class="breadcrumb-item active">Add book</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add New Book</h5>
              <form method="POST" action="add_book.php">
                <div class="row mb-3">
                  <label for="bookName" class="col-sm-2 col-form-label">Book Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="description" class="col-sm-2 col-form-label">Description</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="description" name="description" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="author" class="col-sm-2 col-form-label">Author</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="author" name="author" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="publisher" class="col-sm-2 col-form-label">Publisher</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="publisher" name="publisher" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="publicationYear" class="col-sm-2 col-form-label">Publication Year</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="publish_year" name="publish_year" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="language" class="col-sm-2 col-form-label">Language</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="language" name="language" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="CopiesCount" class="col-sm-2 col-form-label">Copies Count</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="copies" name="copies" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="selectExample" class="col-sm-3 col-form-label">Select Categories</label>
                  <div class="col-sm-9">
                    <select class="form-select form-control" id="selectExample" name="category_name">
                      <option>Select a Category</option>
                      <?php
                      $query = "SELECT `name` FROM `categories`";
                      $result = mysqli_query($conn, $query);
                      if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                        }
                      } else {
                        echo "<option value=''>Error fetching categories</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <script>
  $(document).ready(function () {
    // Listen for the form submission
    $('form').on('submit', function (e) {
      e.preventDefault(); // Prevent page reload

      // Collect form data
      var formData = {
        title: $('#title').val(),
        description: $('#description').val(),
        author: $('#author').val(),
        publisher: $('#publisher').val(),
        publish_year: $('#publish_year').val(),
        language: $('#language').val(),
        copies: $('#copies').val(),
        category_name: $('#selectExample').val()
      };

      $.ajax({
        url: 'add_book.php', // The page where we handle the form submission
        method: 'POST',
        data: formData, // Send the data
        success: function (response) {
          console.log(response); // Check the server response
          if (response.trim() === 'success') {
            // Show success message
            alert('تم إضافة الكتاب بنجاح!');
            // Redirect to show.php after successful addition
            window.location.href = 'show.php'; 
          } else {
            alert('حدث خطأ أثناء إضافة الكتاب.');
          }
        },
        error: function () {
          alert('حدث خطأ في الاتصال بالخادم.');
        }
      });
    });
  });
</script>

  <?php include "../footer.php"; ?>

</body>
</html>
