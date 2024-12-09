<?php
// Include necessary files
require 'db_connect.php'; // Database connection
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Use PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Display errors for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

// Get the email from the POST request and validate it
$email = trim($_POST['email']);

// Validate the email address
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address']);
    exit;
}

global $conn;

// Check if the email exists in the database
$stmt = $conn->prepare("SELECT user_id FROM user_info WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email not found']);
    exit;
}

// Generate a random 6-digit OTP
$otp = rand(100000, 999999);

// Set OTP expiry time (15 minutes from now)
$expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));

// Store the OTP and expiry time in the database
$stmt = $conn->prepare("UPDATE user_info SET otp = ?, otp_expiry = ? WHERE email = ?");
$stmt->bind_param("iss", $otp, $expiry, $email);
if (!$stmt->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to store OTP']);
    exit;
}

// Create a PHPMailer instance to send the OTP email
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'mandmcakeorderingsystem@gmail.com'; // Your Gmail address
    $mail->Password = 'dgld kvqo yecu wdka'; // App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('mandmcakeorderingsystem@gmail.com', 'M&M Cake Ordering System');
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset OTP';
    $mail->Body = "
        <h2>Password Reset Request</h2>
        <p>Your OTP is: <strong>$otp</strong></p>
        <p>This OTP expires in 15 minutes.</p>
    ";

    // Send email
    $mail->send();

    // Respond with success message
    echo json_encode(['status' => 'success', 'message' => 'OTP sent to your email']);
} catch (Exception $e) {
    // Log error details if email fails
    error_log($e->getMessage(), 3, 'errors.log'); // Log the error in 'errors.log'

    // Respond with error message
    echo json_encode(['status' => 'error', 'message' => 'Failed to send email: ' . $mail->ErrorInfo]);
}

?>
