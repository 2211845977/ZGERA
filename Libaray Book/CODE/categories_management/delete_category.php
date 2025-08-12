<?php
// حذف التصنيف من قاعدة البيانات
if (isset($_POST['id'])) {
    $categoryId = $_POST['id'];

    // الاتصال بقاعدة البيانات
    include "../db_connct.php"; // تضمين الاتصال بقاعدة البيانات

    // استعلام الحذف
    $sql = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);

    // تنفيذ الاستعلام
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
