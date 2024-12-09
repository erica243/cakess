<?php
require 'db_connect.php'; // Database connection
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$email = trim($_POST['email']);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address']);
    exit;
}

global $conn;

// Check if email exists
$stmt = $conn->prepare("SELECT user_id FROM user_info WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email not found']);
    exit;
}

// Generate OTP and expiry
$otp = rand(100000, 999999);
$expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));

// Store OTP in the database
$stmt = $conn->prepare("UPDATE user_info SET otp = ?, otp_expiry = ? WHERE email = ?");
$stmt->bind_param("iss", $otp, $expiry, $email);
if (!$stmt->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to store OTP']);
    exit;
}

// Send OTP email
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mandmcakeorderingsystem@gmail.com'; 
    $mail->Password = 'dgld kvqo yecu wdka'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('mandmcakeorderingsystem@gmail.com', 'M&M Cake Ordering System');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset OTP';
    $mail->Body = "
        <h2>Password Reset Request</h2>
        <p>Your OTP is: <strong>$otp</strong></p>
        <p>This OTP expires in 15 minutes.</p>
    ";

    $mail->send();
    echo json_encode(['status' => 'success', 'message' => 'OTP sent to your email']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send email: ' . $mail->ErrorInfo]);
}
?>
