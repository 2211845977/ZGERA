<?php
include "../db_connct.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();

    if (isset($_POST['delete_id'])) {
        $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

        // الحصول على معرف الكتاب قبل الحذف
        $book_query = "SELECT book_id FROM borrowedbooks WHERE id = '$delete_id'";
        $book_result = mysqli_query($conn, $book_query);
        $book_row = mysqli_fetch_assoc($book_result);
        $book_id = $book_row['book_id'];

        // حذف الإعارة
        $delete_query = "DELETE FROM borrowedbooks WHERE id = '$delete_id'";

        if (mysqli_query($conn, $delete_query)) {
            // زيادة عدد النسخ المتوفرة
            $update_copies_query = "UPDATE books SET copies = copies + 1 WHERE id = '$book_id'";
            mysqli_query($conn, $update_copies_query);

            $response['status'] = 'success';
            $response['message'] = 'تم حذف الإعارة بنجاح';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'حدث خطأ أثناء حذف الإعارة';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'معرف الإعارة غير موجود';
    }

    echo json_encode($response);
    exit;
}
?>