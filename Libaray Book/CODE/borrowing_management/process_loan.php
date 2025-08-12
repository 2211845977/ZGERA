<?php
include "../db_connct.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();

    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    $borrower_id = mysqli_real_escape_string($conn, $_POST['borrower_id']);
    $borrow_date = mysqli_real_escape_string($conn, $_POST['borrow_date']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);

    // التحقق من وجود الموظف في جدول users
    $employee_query = "SELECT userid FROM users WHERE role = 'Employee' LIMIT 1";
    $employee_result = mysqli_query($conn, $employee_query);
    $employee_row = mysqli_fetch_assoc($employee_result);
    $employee_id = $employee_row ? $employee_row['userid'] : null;

    if (!$employee_id) {
        $response['status'] = 'error';
        $response['message'] = 'لا يوجد موظف متاح لتسجيل الإعارة';
        echo json_encode($response);
        exit;
    }

    // التحقق من توفر الكتاب وعدد النسخ
    $book_query = "SELECT copies FROM books WHERE id = '$book_id'";
    $book_result = mysqli_query($conn, $book_query);
    $book_row = mysqli_fetch_assoc($book_result);

    if ($book_row['copies'] <= 0) {
        $response['status'] = 'error';
        $response['message'] = 'عذراً، لا توجد نسخ متوفرة من هذا الكتاب';
        echo json_encode($response);
        exit;
    }

    // إضافة الإعارة الجديدة
    $insert_query = "INSERT INTO borrowedbooks (book_id, borrowed_id, by_employee, borrowed_date, due_date) 
                    VALUES ('$book_id', '$borrower_id', '$employee_id', '$borrow_date', '$due_date')";

    if (mysqli_query($conn, $insert_query)) {
        // تقليل عدد النسخ المتاحة
        $update_copies_query = "UPDATE books SET copies = copies - 1 WHERE id = '$book_id'";
        mysqli_query($conn, $update_copies_query);

        $response['status'] = 'success';
        $response['message'] = 'تمت إضافة الإعارة بنجاح';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'حدث خطأ أثناء إضافة الإعارة: ' . mysqli_error($conn);
    }

    echo json_encode($response);
    exit;
}
?>