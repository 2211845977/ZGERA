<?php

include '../db_connct.php';

$query = "SELECT * FROM books";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $counter = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $counter++ . '</td>';
        echo '<td>' . ($row['title']) . '</td>';
        echo '<td>' . ($row['description']) . '</td>';
        echo '<td>' . ($row['author']) . '</td>';
        echo '<td>' . ($row['publisher']) . '</td>';
        echo '<td style="text-align: center;">' . ($row['publish_year']) . '</td>';
        echo '<td>' . ($row['category_name']) . '</td>';
        echo '<td>' . ($row['language']) . '</td>';
        echo '<td>' . ($row['copies']) . '</td>';
        echo '<td><a href="edit.php?id=' . $row['id'] . '" class="btn btn-warning">Edit</a></td>';
        echo '<td><button class="btn btn-danger delete-btn" data-id="' . $row['id'] . '">Delete</button></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="10" class="text-center">No books found</td></tr>';
}
?>

<body>
    <!-- سكربت خاص بالضغط علي زر الحذف -->
    <script>
        $(document).ready(function () {

            $('.delete-btn').click(function () {

                var bookId = $(this).data('id');


                if (confirm('Are you sure you want to delete this book?')) {

                    $.ajax({

                        url: 'delete_book.php',    // الصفحة التي تحتوي علي اوامر الحذف
                        method: 'GET',
                        data: { id: bookId },
                        success: function (response) {
                            if (response === 'success') {
                                alert('Book deleted successfully!');
                                $('button[data-id="' + bookId + '"]').closest('tr').remove();   // حذف الصف الخاص بالكتاب المحذوف من الجدول مباشرة
                            } else {
                                alert('Error deleting the book.');
                            }
                        }
                    });
                }
            });
        });

    </script>
</body>