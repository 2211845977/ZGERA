<?php
session_start();
include '../db_connct.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $userid = mysqli_real_escape_string($conn, $_POST['id']);

    // Delete from database with that ID
    $query = "DELETE FROM users WHERE userid = '$userid' AND role='Employee'";
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>