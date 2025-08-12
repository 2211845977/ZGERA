<?php
include "../db_connct.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $publish_year = $_POST['publish_year'];
    $category_name = $_POST['category_name'];
    $language = $_POST['language'];
    $copies = $_POST['copies'];


    $update_query = "UPDATE books SET 
                  title='$title', 
                  description='$description', 
                  author='$author', 
                  publisher='$publisher', 
                  publish_year='$publish_year', 
                  category_name='$category_name', 
                  language='$language', 
                  copies='$copies'
                  WHERE id='$book_id'";

    if (mysqli_query($conn, $update_query)) {
        echo 'success';
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>