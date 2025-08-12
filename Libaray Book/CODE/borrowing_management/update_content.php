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
    $currentPage = "borrowing_mangment";
    $subPage = "update_loan";
    include("../sidebar.php");

    // جلب بيانات الإعارة الحالية
    if (isset($_GET['id'])) {
        $loan_id = mysqli_real_escape_string($conn, $_GET['id']);
        $query = "SELECT bb.*, b.title, u.username 
                  FROM borrowedbooks bb
                  JOIN books b ON bb.book_id = b.id
                  JOIN users u ON bb.borrowed_id = u.userid
                  WHERE bb.id = '$loan_id'";
        $result = mysqli_query($conn, $query);
        $loan = mysqli_fetch_assoc($result);
    } else {
        header("Location: view_loan.php");
        exit();
    }
    ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Update Loan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Borrowing Management</li>
                    <li class="breadcrumb-item active">Update Loan</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Loan</h5>
                            <form id="updateLoanForm" class="row g-3">
                                <input type="hidden" name="loan_id" value="<?php echo $loan['id']; ?>">
                                <div class="col-md-6">
                                    <label class="form-label">Select Book</label>
                                    <select name="book_id" class="form-select" required>
                                        <option value="">Choose a book...</option>
                                        <?php
                                        $query = "SELECT id, title, copies FROM books ORDER BY title";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $selected = ($row['id'] == $loan['book_id']) ? 'selected' : '';
                                            $disabled = ($row['copies'] <= 0 && $row['id'] != $loan['book_id']) ? 'disabled' : '';
                                            echo "<option value='{$row['id']}' {$selected} {$disabled}>{$row['title']} (النسخ المتاحة: {$row['copies']})</option>";
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
                                            $selected = ($row['userid'] == $loan['borrowed_id']) ? 'selected' : '';
                                            echo "<option value='{$row['userid']}' {$selected}>{$row['username']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Borrow Date</label>
                                    <input type="date" class="form-control" name="borrow_date"
                                        value="<?php echo $loan['borrowed_date']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" class="form-control" name="due_date"
                                        value="<?php echo $loan['due_date']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Return Date</label>
                                    <input type="date" class="form-control" name="return_date"
                                        value="<?php echo $loan['returned_date']; ?>">
                                </div>
                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary">Update Loan</button>
                                    <a href="view_loan.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include "../footer.php"; ?>

    <script>
        document.getElementById('updateLoanForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            $.ajax({
                url: 'process_update_loan.php',
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
                    alert('حدث خطأ أثناء تحديث الإعارة');
                }
            });
        });
    </script>
</body>

</html>