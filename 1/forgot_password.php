<?php
require 'db_connect.php'; // Include your database connection
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ensure request is POST
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

// Check if email exists in the database
$stmt = $conn->prepare("SELECT user_id FROM user_info WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email not found']);
    exit;
}

// Generate OTP
$otp = rand(100000, 999999);
$expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));

// Store OTP and expiry in the database
$stmt = $conn->prepare("UPDATE user_info SET otp = ?, otp_expiry = ?, reset_time = CURRENT_TIME() WHERE email = ?");
$stmt->bind_param("iss", $otp, $expiry, $email);
if (!$stmt->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to store OTP']);
    exit;
}

// Send email with PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mandmcakeorderingsystem@gmail.com'; 
    $mail->Password = 'dgld kvqo yecu wdka'; // Ensure correct credentials
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 3306;

    $mail->setFrom('mandmcakeorderingsystem@gmail.com', 'M&M Cake Ordering System');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset OTP';
    $mail->Body = "
        <h2>Password Reset Request</h2>
        <p>Your OTP for password reset is: <strong>$otp</strong></p>
        <p>This OTP will expire in 15 minutes.</p>
        <p>If you didn't request this, please ignore this email.</p>
    ";

    $mail->send();
    echo json_encode(['status' => 'success', 'message' => 'OTP sent to your email']);
} catch (Exception $e) {
    error_log("PHPMailer Error: " . $mail->ErrorInfo);
    echo json_encode(['status' => 'error', 'message' => 'Email could not be sent. Error: ' . $mail->ErrorInfo]);
}
?>