<?php
include "../db_connct.php";

// التحقق من وجود 'userid' في بيانات POST
if (isset($_POST['userid'])) {
    $userid = intval($_POST['userid']);
    $query = "DELETE FROM users WHERE userid = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Database error: " . $conn->error);
    }

    $stmt->bind_param("i", $userid);

    if ($stmt->execute()) {
        echo "Member deleted successfully.";
    } else {
        echo "Error: Could not delete member.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>