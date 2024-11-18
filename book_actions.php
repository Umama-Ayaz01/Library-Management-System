<?php
include 'db.php';

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'add_or_update':
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre'];
        $publication_year = $_POST['publication_year'];
        $book_id = $_POST['book_id'] ?? null;

        if (!empty($book_id)) {
            $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, genre = ?, publication_year = ? WHERE book_id = ?");
            $stmt->execute([$title, $author, $genre, $publication_year, $book_id]);
            echo "Book updated successfully!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO books (title, author, genre, publication_year) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $author, $genre, $publication_year]);
            echo "Book added successfully!";
        }
        break;

    case 'list':
        $stmt = $pdo->query("SELECT * FROM books");
        if ($stmt->rowCount() == 0) {
            echo "<p class='alert alert-warning'>No books available.</p>";
        } else {
            echo "<table class='table table-bordered'>
                    <thead class='table-dark'>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th>Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $stmt->fetch()) {
                echo "<tr>
                        <td>{$row['title']}</td>
                        <td>{$row['author']}</td>
                        <td>{$row['genre']}</td>
                        <td>{$row['publication_year']}</td>
                        <td>
                            <button class='btn btn-warning btn-sm edit-book' data-id='{$row['book_id']}'>Edit</button>
                            <button class='btn btn-danger btn-sm delete-book' data-id='{$row['book_id']}'>Delete</button>
                        </td>
                    </tr>";
            }
            echo "</tbody></table>";
        }
        break;

    case 'delete':
        $book_id = $_POST['book_id'];
        $stmt = $pdo->prepare("DELETE FROM books WHERE book_id = ?");
        $stmt->execute([$book_id]);
        echo "Book deleted successfully!";
        break;

    case 'fetch':
        $book_id = $_GET['book_id'];
        $stmt = $pdo->prepare("SELECT * FROM books WHERE book_id = ?");
        $stmt->execute([$book_id]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        break;
}
?>
