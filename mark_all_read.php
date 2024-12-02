<?php
session_start();
include 'admin/db_connect.php';

if (!isset($_SESSION['login_user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$userId = $_SESSION['login_user_id'];

// Mark all notifications as read
$updateQuery = "UPDATE notifications SET is_read = 1 WHERE user_id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
Write to Erica Chavez
