<?php
// mark_all_read.php
session_start();
require_once 'admin/db_connect.php';
require_once 'notifications.php';

header('Content-Type: application/json');

if (!isset($_SESSION['login_user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

if (!isset($_POST['notification_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Notification ID required']);
    exit();
}

$notificationSystem = new NotificationSystem($conn);
$result = $notificationSystem->markAsRead(
    $_POST['notification_id'],
    $_SESSION['login_user_id']
);

if (!$result['success']) {
    http_response_code(500);
}

echo json_encode($result);
$conn->close();