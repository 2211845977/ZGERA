<?php
include "../db_connct.php"; 


$userId = $_SESSION['user_id']; 
$sql = "SELECT 
        borrowedbooks.book_id, 
        Books.title, 
        borrowedbooks.borrowed_date, 
        borrowedbooks.due_date 
    FROM 
        borrowedbooks 
    INNER JOIN 
        books 
    ON 
        borrowedbooks.book_id = books.id 
    WHERE 
        borrowedbooks.borrowed_id = ?
        AND borrowedbooks.returned_date IS NULL";
        echo "Binding User ID: " . $userId; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <th scope='row'>{$counter}</th>
                <td>{$row['title']}</td>
                <td>{$row['borrowed_date']}</td>
                <td>{$row['due_date']}</td>
              </tr>";
        $counter++;
    }
} else {
    echo "<tr><td colspan='4'>No books borrowed.</td></tr>";
}

?>
<script>
    // طباعة user_id في الكونسول باستخدام JavaScript
    var userId = <?php echo json_encode($userId); ?>;
    console.log("User ID: ", userId);
</script>
