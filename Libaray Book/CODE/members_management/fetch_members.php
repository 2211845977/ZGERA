<?php
include "../db_connct.php";

$query = "SELECT * FROM users WHERE Role = 'Members'"; // استعلام جلب البيانات
$result = mysqli_query($conn, $query);

$members = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $members[] = [
            "userid" => $row['userid'],
            "username" => $row['username'],
            "address" => $row['address'],
            "phone" => $row['phone'],
            "email" => $row['email']
        ];
    }
}

// إرجاع البيانات كـ JSON
header('Content-Type: application/json');
echo json_encode($members);
?>