<?php
include 'db.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'loadIssuedBooks':
            loadIssuedBooks();
            break;
        case 'getIssue':
            getIssue();
            break;
    }
}

// Function to load all issued books
function loadIssuedBooks() {
    global $pdo;
    $sql = "SELECT bm.issue_id, b.title AS book_title, m.name AS member_name FROM book_members bm
            JOIN books b ON bm.book_id = b.book_id
            JOIN members m ON bm.member_id = m.member_id";
    $stmt = $pdo->query($sql);
    $issuedBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($issuedBooks)) {
        echo "<tr><td colspan='3' class='text-center'>No books have been issued yet.</td></tr>";
    } else {
        foreach ($issuedBooks as $issue) {
            echo "<tr>
                    <td>{$issue['book_title']}</td>
                    <td>{$issue['member_name']}</td>
                    <td>
                        <button class='editBtn' data-id='{$issue['issue_id']}'>Edit</button>
                        <button class='deleteBtn' data-id='{$issue['issue_id']}'>Delete</button>
                    </td>
                  </tr>";
        }
    }
}

// Function to get details of a specific issue
function getIssue() {
    global $pdo;
    $issueId = $_POST['issue_id'];
    $sql = "SELECT * FROM book_members WHERE issue_id = :issue_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['issue_id' => $issueId]);
    $issue = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($issue);
}
?>
