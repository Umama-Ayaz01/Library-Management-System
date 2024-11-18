<?php
include 'db.php';

if (isset($_POST['action']) && $_POST['action'] == 'loadBooks') {
    $sql = "SELECT * FROM books"; // Fetch books from the database
    $stmt = $pdo->query($sql);
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($books as $book) {
        echo "<option value='{$book['book_id']}'>{$book['title']}</option>";
    }
}
?>
