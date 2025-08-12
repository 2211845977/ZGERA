<?php
include "../db_connct.php";  // تضمين الاتصال بقاعدة البيانات

// استعلام لاسترجاع التصنيفات من قاعدة البيانات
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

// التحقق من وجود نتائج
if ($result->num_rows > 0) {
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;  // إضافة كل تصنيف إلى المصفوفة
    }
    echo json_encode($categories);  // إرسال النتيجة بصيغة JSON
} else {
    echo json_encode([]);  // إذا لم توجد تصنيفات
}
?>

