<?php
include 'db_connct.php';


// تحقق من إذا كان المستخدم قد طلب الخروج
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // مسح جميع بيانات الجلسة
    session_unset();
    session_destroy();

    // إعادة التوجيه إلى صفحة تسجيل الدخول بعد الخروج
    header("Location: /lib_sys/index.php");
    exit(); // تأكد من توقف السكربت بعد إعادة التوجيه
}
?>