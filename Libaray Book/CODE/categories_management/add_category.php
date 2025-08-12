<?php
include "../db_connct.php";  // تضمين الاتصال بقاعدة البيانات

// التحقق من إرسال البيانات عبر POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && isset($_POST['description'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];

        // التحقق من أن الحقول ليست فارغة
        if (!empty($name) && !empty($description)) {
            // استعلام لإدخال البيانات في قاعدة البيانات
            $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";

            // التحضير وتنفيذ الاستعلام
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ss", $name, $description);
                if ($stmt->execute()) {
                    echo "success";  // إذا تم الحفظ بنجاح
                } else {
                    echo "error";  // إذا حدث خطأ أثناء الحفظ
                }
                $stmt->close();
            } else {
                echo "error";  // إذا حدث خطأ في الاستعلام
            }
        } else {
            echo "error";  // إذا كانت الحقول فارغة
        }
    }
    exit(); // إيقاف تنفيذ أي محتوى HTML بعد الاستجابة
}
?>
