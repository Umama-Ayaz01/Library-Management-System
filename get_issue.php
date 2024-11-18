<?php
include 'db.php';

if (isset($_GET['issue_id'])) {
    $issueId = $_GET['issue_id'];

    try {
        $sql = "SELECT * FROM book_members WHERE issue_id = :issue_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':issue_id' => $issueId]);
        $issue = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($issue ? $issue : []);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
}
?>
