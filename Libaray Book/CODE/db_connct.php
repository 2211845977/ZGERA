<?php
$servername = "localhost"; // اسم الخادم
$username = "root"; // اسم المستخدم الافتراضي
$password = ""; // كلمة المرور الافتراضية)
$dbname = "db_lib"; // اسم قاعدة البيانات

// إنشاء الاتصال
$conn = mysqli_connect($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn) {
  echo "";
} else {
  die("NO" . mysqli_connect_error());
}

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

?>