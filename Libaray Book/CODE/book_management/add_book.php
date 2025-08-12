<?php


include "../db_connct.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $publish_year = $_POST['publish_year'];
    $language = $_POST['language'];
    $copies = $_POST['copies'];
    $category_name = $_POST['category_name'];

    $query = "INSERT INTO books (title, description, author, publisher, publish_year, language, copies, category_name)
              VALUES ('$title', '$description', '$author', '$publisher', '$publish_year', '$language', '$copies', '$category_name')";

    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>