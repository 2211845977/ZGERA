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
    $subPage = "add_loan";
    include("../sidebar.php");
    ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Add New Loan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Borrowing Management</li>
                    <li class="breadcrumb-item active">Add Loan</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add New Loan</h5>

                            <form id="loanForm" class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Select Book</label>
                                    <select name="book_id" class="form-select" required>
                                        <option value="">Choose a book...</option>
                                        <?php
                                        $query = "SELECT b.id, b.title, b.copies 
                                                FROM books b 
                                                WHERE b.copies > 0
                                                ORDER BY b.title ASC";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['title'] . " (النسخ المتاحة: " . $row['copies'] . ")</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Select Borrower</label>
                                    <select name="borrower_id" class="form-select" required>
                                        <option value="">Choose a borrower...</option>
                                        <?php
                                        $query = "SELECT userid, username FROM users WHERE role = 'Members' ORDER BY username";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['userid']}'>{$row['username']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Borrow Date</label>
                                    <input type="date" class="form-control" name="borrow_date"
                                        value="<?php echo date('Y-m-d'); ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" class="form-control" name="due_date"
                                        value="<?php echo date('Y-m-d', strtotime('+21 days')); ?>" required>
                                </div>

                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary">Add Loan</button>
                                    <a href="view_loan.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.getElementById('loanForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            $.ajax({
                url: 'process_loan.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    if (response.status === 'success') {
                        window.location.href = 'view_loan.php';
                    }
                },
                error: function() {
                    alert('حدث خطأ أثناء إضافة الإعارة');
                }
            });
        });
    </script>

    <?php include "../footer.php"; ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>
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