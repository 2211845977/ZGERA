<?php

include '../db_connct.php'; 

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];  
    $query = "DELETE FROM books WHERE id = '$book_id'";  

    if (mysqli_query($conn, $query)) {
        echo 'success';  
    } else {
        echo 'error';  
    }
}


?>
