<?php
include("../db_connct.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];


    if (!empty($password)) {

        $query = "UPDATE users SET username='$fullname', email='$email', phone='$phone', address='$address', password='$password' WHERE userid='$userid' AND role='Employee'";
    } else {
        // If no password provided, don't update it
        $query = "UPDATE users SET username='$fullname', email='$email', phone='$phone', address='$address' WHERE userid='$userid' AND role='Employee'";
    }

    if (mysqli_query($conn, $query)) {
        echo "Employee updated successfully!";
        header("Location: show.php"); // Redirect
    } else {
        echo "Error updating employee: " . mysqli_error($conn);
    }
}
?>