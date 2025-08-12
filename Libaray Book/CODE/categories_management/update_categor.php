<?php
include "../db_connct.php";  // الاتصال بقاعدة البيانات

if (isset($_POST['id'], $_POST['name'], $_POST['description'])) {
    $categoryId = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    // تحديث التصنيف في قاعدة البيانات
    $query = "UPDATE categories SET name = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $name, $description, $categoryId);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
