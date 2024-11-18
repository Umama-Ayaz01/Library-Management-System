<?php
include 'db.php';

if (isset($_POST['issue_id'])) {
    $issueId = $_POST['issue_id'];

    try {
        $sql = "DELETE FROM book_members WHERE issue_id = :issue_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':issue_id' => $issueId]);
        echo "Issue deleted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
