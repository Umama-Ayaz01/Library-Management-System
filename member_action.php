<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';


if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'addMember':
        case 'updateMember':
            addUpdateMember();
            break;

        case 'deleteMember':
            deleteMember();
            break;

        case 'loadMembers':
            loadMembers();
            break;

        case 'getMember':
            getMember();
            break;
    }
}

function addUpdateMember() {
    global $pdo; 
    $memberId = $_POST['member_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $gender = $_POST['gender'];
    $profilePic = '';

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profilePic = 'uploads/' . $_FILES['profile_picture']['name'];
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profilePic);
    }

    if ($memberId) {
        if ($profilePic) {
            $sql = "UPDATE members SET name = :name, email = :email, phone_number = :phone, gender = :gender, profile_picture = :profilePic WHERE member_id = :memberId";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'gender' => $gender, 'profilePic' => $profilePic, 'memberId' => $memberId]);
        } else {
            $sql = "UPDATE members SET name = :name, email = :email, phone_number = :phone, gender = :gender WHERE member_id = :memberId";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'gender' => $gender, 'memberId' => $memberId]);
        }
        echo "Updated successfully!";
    } else {
        $sql = "INSERT INTO members (name, email, phone_number, profile_picture, gender) VALUES (:name, :email, :phone, :profilePic, :gender)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'profilePic' => $profilePic, 'gender' => $gender]);
        echo "Added successfully!";
    }
}

// Function to delete a member
function deleteMember() {
    global $pdo;
    $memberId = $_POST['member_id'];
    $sql = "DELETE FROM members WHERE member_id = :memberId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['memberId' => $memberId]);
    echo "Deleted successfully!";
}

// Function to load all members
function loadMembers() {
    global $pdo; 
    $sql = "SELECT * FROM members";
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows) {
        foreach ($rows as $row) {
            $profilePic = $row['profile_picture'] ? $row['profile_picture'] : 'path/to/default-image.jpg';
            echo "<tr>
                    <td><img src='$profilePic' alt='Profile Picture' width='50' height='50'></td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone_number']}</td>
                    <td>{$row['gender']}</td>
                    <td>
                        <button class='editBtn' data-id='{$row['member_id']}'>Edit</button>
                        <button class='deleteBtn' data-id='{$row['member_id']}'>Delete</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No members found</td></tr>";
    }
}


// Function to get a member by ID
function getMember() {
    global $pdo; 
    $memberId = $_POST['member_id'];
    $sql = "SELECT * FROM members WHERE member_id = :memberId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['memberId' => $memberId]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($member ? $member : []);
}
?>
