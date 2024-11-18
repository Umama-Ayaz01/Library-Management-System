<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'issue') {
            
            $memberId = $_POST['member_id'];
            $bookId = $_POST['book_id'];

            if ($memberId && $bookId) {
                try {
                    $sql = "INSERT INTO book_members (book_id, member_id) VALUES (:book_id, :member_id)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':book_id' => $bookId, ':member_id' => $memberId]);
                    echo "Book issued successfully!";
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "Please select both a member and a book.";
            }
        } elseif ($action == 'update') {
            $memberId = $_POST['member_id'];
            $bookId = $_POST['book_id'];
            $issueId = $_POST['issue_id'];

            if ($issueId && $memberId && $bookId) {
                try {
                    $sql = "UPDATE book_members SET book_id = :book_id, member_id = :member_id WHERE issue_id = :issue_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':book_id' => $bookId, ':member_id' => $memberId, ':issue_id' => $issueId]);
                    echo "Book issue updated successfully!";
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "Please select both a member and a book.";
            }
        } elseif ($action == 'deleteIssue') {
            $issueId = $_POST['issue_id'];

            if ($issueId) {
                try {
                    $sql = "DELETE FROM book_members WHERE issue_id = :issue_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':issue_id' => $issueId]);
                    echo "Book issue deleted successfully!";
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "Invalid issue ID.";
            }
        }
    }
}
?>
