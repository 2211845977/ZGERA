<?php
include "../db_connct.php";

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loan_id = mysqli_real_escape_string($conn, $_POST['loan_id']);
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    $borrower_id = mysqli_real_escape_string($conn, $_POST['borrower_id']);
    $borrow_date = mysqli_real_escape_string($conn, $_POST['borrow_date']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $return_date = !empty($_POST['return_date']) ? "'" . mysqli_real_escape_string($conn, $_POST['return_date']) . "'" : "NULL";

    // جلب بيانات الإعارة الحالية
    $current_query = "SELECT returned_date, book_id FROM borrowedbooks WHERE id = '$loan_id'";
    $current_result = mysqli_query($conn, $current_query);
    $current_data = mysqli_fetch_assoc($current_result);

    // التحقق من عدد النسخ المتوفرة إذا تم تغيير الكتاب
    if ($book_id != $current_data['book_id']) {
        $book_query = "SELECT copies FROM books WHERE id = '$book_id'";
        $book_result = mysqli_query($conn, $book_query);
        $book_row = mysqli_fetch_assoc($book_result);

        if ($book_row['copies'] <= 0) {
            $response['status'] = 'error';
            $response['message'] = 'عذراً، لا توجد نسخ متوفرة من هذا الكتاب';
            echo json_encode($response);
            exit;
        }
    }

    // إذا تم تعبئة تاريخ الإرجاع وكان فارغاً من قبل
    if ($current_data['returned_date'] == NULL && $return_date != "NULL") {
        // زيادة عدد النسخ المتاحة للكتاب القديم
        $update_copies_query = "UPDATE books SET copies = copies + 1 WHERE id = '{$current_data['book_id']}'";
        mysqli_query($conn, $update_copies_query);
    }
    // إذا تم إفراغ تاريخ الإرجاع وكان معبأ من قبل
    else if ($current_data['returned_date'] != NULL && $return_date == "NULL") {
        // تقليل عدد النسخ المتاحة للكتاب القديم
        $update_copies_query = "UPDATE books SET copies = copies - 1 WHERE id = '{$current_data['book_id']}'";
        mysqli_query($conn, $update_copies_query);
    }

    // إذا تم تغيير الكتاب
    if ($book_id != $current_data['book_id']) {
        if ($return_date == "NULL") {
            // تقليل عدد النسخ المتاحة للكتاب الجديد
            $update_new_copies_query = "UPDATE books SET copies = copies - 1 WHERE id = '$book_id'";
            mysqli_query($conn, $update_new_copies_query);
        }
        if ($current_data['returned_date'] == NULL) {
            // زيادة عدد النسخ المتاحة للكتاب القديم
            $update_old_copies_query = "UPDATE books SET copies = copies + 1 WHERE id = '{$current_data['book_id']}'";
            mysqli_query($conn, $update_old_copies_query);
        }
    }

    // تحديث الإعارة
    $update_query = "UPDATE borrowedbooks 
                    SET book_id = '$book_id',
                        borrowed_id = '$borrower_id',
                        borrowed_date = '$borrow_date',
                        due_date = '$due_date',
                        returned_date = $return_date
                    WHERE id = '$loan_id'";

    if (mysqli_query($conn, $update_query)) {
        $response['status'] = 'success';
        $response['message'] = 'تم تحديث الإعارة بنجاح';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'حدث خطأ أثناء تحديث الإعارة: ' . mysqli_error($conn);
    }

    echo json_encode($response);
    exit;
}
?>