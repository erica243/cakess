<?php
session_start();
include 'admin/db_connect.php';

if (!isset($_SESSION['login_user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$userId = $_SESSION['login_user_id'];
$notificationId = $_POST['notification_id'];

// Update specific notification as read
$updateQuery = "UPDATE notifications SET is_read = 1 WHERE order_number = ? AND user_id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("ii", $notificationId, $userId);

if ($stmt->execute()) {
    // Query to fetch the delivery status of the notification
    $statusQuery = "
        SELECT delivery_status
        FROM notifications 
        WHERE order_number = ? AND user_id = ?
    ";
    $statusStmt = $conn->prepare($statusQuery);
    $statusStmt->bind_param("ii", $notificationId, $userId);
    $statusStmt->execute();
    $statusResult = $statusStmt->get_result();
    $deliveryStatus = null;

    // If the notification is found, get the delivery status
    if ($statusResult->num_rows > 0) {
        $row = $statusResult->fetch_assoc();
        $deliveryStatus = $row['delivery_status'];
    }

    // Send success response with delivery status
    echo json_encode(['success' => true, 'delivery_status' => $deliveryStatus]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
