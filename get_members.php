<?php
include 'db.php';

if (isset($_POST['action']) && $_POST['action'] == 'loadMembers') {
    $sql = "SELECT * FROM members"; 
    $stmt = $pdo->query($sql);
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($members as $member) {
        echo "<option value='{$member['member_id']}'>{$member['name']}</option>";
    }
}
?>
