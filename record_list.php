<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Issued Books</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJpE6H6VmdmVX9R7fyyD5Yfuim72FVv5vbp+e6w/a4mIQhxL0vfsHGtONDAy" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <?php
        include 'db.php'; 

        // Query to fetch issued books with member details
        $sql = "SELECT bm.issue_id, bm.book_id, b.title AS book_name, b.author, 
                    m.name AS member_name, m.email
                FROM book_members bm
                JOIN books b ON bm.book_id = b.book_id
                JOIN members m ON bm.member_id = m.member_id";

        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

       
        $issuedBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        if ($issuedBooks) {
            echo "<h3>Issued Books List</h3>";
            echo "<table class='table table-striped'>
                    <thead class='table-dark'>
                        <tr>
                            <th>Issue ID</th>
                            <th>Book ID</th>
                            <th>Book Name</th>
                            <th>Author</th>
                            <th>Member Name</th>
                            <th>Member Email</th>
                        </tr>
                    </thead>
                    <tbody>";

            
            foreach ($issuedBooks as $row) {
                echo "<tr>
                        <td>" . $row['issue_id'] . "</td>
                        <td>" . $row['book_id'] . "</td>
                        <td>" . $row['book_name'] . "</td>
                        <td>" . $row['author'] . "</td>
                        <td>" . $row['member_name'] . "</td>
                        <td>" . $row['email'] . "</td>
                      </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning'>No issued books found.</div>";
        }
        ?>
    </div>

  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybOly2ChGQU6HhvZhnxQpS6nZYAGpG7l31yyMklz5gsXLMc7p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFjcJ1eYw6aJfLfH4U5zDtbD3aWktD/hbkw0p7w2JloO" crossorigin="anonymous"></script>
</body>
</html>
