    <?php
   require_once('admin/db_connect.php'); // Database connection
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   
   require 'vendor/autoload.php'; // Autoload PHPMailer using Composer
   
    // Check if it's a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        exit;
    }

    // Validate incoming email
    if (!isset($_POST['email'])) {
        echo json_encode(['status' => 'error', 'message' => 'Email is required']);
        exit;
    }

    $email = trim($_POST['email']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email address']);
        exit;
    }

    try {
        // Check database connection
        if (!$conn) {
            throw new Exception('Database connection failed');
        }

        // Prepare and execute email check
        $stmt = $conn->prepare("SELECT user_id FROM user_info WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo json_encode(['status' => 'error', 'message' => 'Email not found in our system']);
            exit;
        }

        // Generate OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));
        $expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        // Update user with OTP
        $update_stmt = $conn->prepare("UPDATE user_info SET otp = ?, otp_expiry = ? WHERE email = ?");
        $update_stmt->bind_param("iss", $otp, $expiry, $email);
        
        if (!$update_stmt->execute()) {
            throw new Exception('Failed to store OTP: ' . $update_stmt->error);
        }

        // Send email
        $mail = new PHPMailer(true);
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
            <p>This OTP will expire in 15 minutes.</p>
        ";

        $mail->send();

        echo json_encode(['status' => 'success', 'message' => 'OTP sent to your email']);

    } catch (Exception $e) {
        // Log full error details
        error_log('Forgot Password Error: ' . $e->getMessage(), 3, 'forgot_password_errors.log');
        
        echo json_encode([
            'status' => 'error', 
            'message' => 'An unexpected error occurred. Please try again later.',
            'debug' => $e->getMessage()  // Only for development, remove in production
        ]);
    }
    ?>