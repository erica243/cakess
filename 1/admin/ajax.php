<?php
//ajax.php
ob_start();
include 'db_connect.php'; // This should define $conn for database operations
include 'admin_class.php';
require '../vendor/autoload.php';

// Use PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$crud = new Action();

// Check if 'action' exists in either GET or POST
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
    // Handle missing action case
    echo "Error: Action not specified.";
    exit();
}
if ($action == 'login') {
    $login = $crud->login();
    if ($login) echo $login;
}

if ($action == 'login2') {
    $login = $crud->login2();
    if ($login) echo $login;
}

if ($action == 'logout') {
    $logout = $crud->logout();
    if ($logout) echo $logout;
}

if ($action == 'logout2') {
    $logout = $crud->logout2();
    if ($logout) echo $logout;
}

if ($action == 'save_user') {
    $save = $crud->save_user();
    if ($save) echo $save;
}

if ($action == 'signup') {
    $save = $crud->signup();
    if ($save) echo $save;
}

if ($action == "save_settings") {
    $save = $crud->save_settings();
    if ($save) echo $save;
}

if ($action == "save_category") {
    $save = $crud->save_category();
    if ($save) echo $save;
}

if ($action == "delete_category") {
    $save = $crud->delete_category();
    if ($save) echo $save;
}

if ($action == "save_menu") {
    $save = $crud->save_menu();
    if ($save) echo $save;
}

if ($action == "delete_menu") {
    $save = $crud->delete_menu();
    if ($save) echo $save;
}

if ($action == "add_to_cart") {
    $save = $crud->add_to_cart();
    if ($save) echo $save;
}

if ($action == "get_cart_count") {
    $save = $crud->get_cart_count();
    if ($save) echo $save;
}

if ($action == "delete_cart") {
    $delete = $crud->delete_cart();
    if ($delete) echo $delete;
}

if ($action == "update_cart_qty") {
    $save = $crud->update_cart_qty();
    if ($save) echo $save;
}

if ($action == "save_order") {
    $save = $crud->save_order();
    if ($save) echo $save;
}

if ($action == "confirm_order") {
    $save = $crud->confirm_order();
    if ($save) echo $save;
}

if ($action == "cancel_order") {
    $cancel = $crud->cancel_order();
    if ($cancel) echo $cancel;
}

if ($action == 'delete_order') {
    include 'db_connect.php';
    $orderId = $_POST['id']; // Get the order ID from POST

    // Use prepared statements for security
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
        echo 1; // Success
    } else {
        echo $conn->error; // Return the error message for debugging
    }

    $stmt->close();
    $conn->close();
    exit();
}


// Handle delete_user action
if ($action == 'delete_user') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $result = $conn->query("DELETE FROM users WHERE id = $id");
        if ($result) {
            echo 1; // Success
        } else {
            error_log("SQL Error: " . $conn->error);
            echo 0; // Failure
        }
    } else {
        echo 0; // Missing ID
    }
}

if($action == 'submit_rating'){
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];
    $user_id = 1; // Replace with actual user ID logic

    // Validate inputs
    if(empty($product_id) || empty($rating)){
        echo 0; // Invalid inputs
        exit;
    }

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO product_ratings (product_id, user_id, rating, feedback) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $product_id, $user_id, $rating, $feedback);
    
    if($stmt->execute()){
        echo 1; // Success
    } else {
        echo 0; // Failure
    }

    $stmt->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] == 'update_delivery_status') {
    $orderId = $_POST['id'];
    $status = $_POST['status'];

    // Validate input
    $allowed_statuses = ['pending', 'confirmed', 'preparing', 'ready', 'in_transit', 'delivered'];
    if (!in_array($status, $allowed_statuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid delivery status.']);
        exit;
    }

    // Prepare the statement
    $stmt = $conn->prepare("UPDATE orders SET delivery_status = ? WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . $conn->error]);
        exit;
    }

    // Bind parameters
    $stmt->bind_param("si", $status, $orderId);

    // Execute the statement
    if ($stmt->execute()) {
        error_log("Delivery status updated for order ID $orderId to '$status'.");

        if ($status === 'confirmed') {
            // Fetch customer details and send email
            $stmt = $conn->prepare("SELECT name, email, order_number FROM orders WHERE id = ?");
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $order = $stmt->get_result()->fetch_assoc();

            $name = $order['name'];
            $email = $order['email'];
            $orderNumber = $order['order_number'];

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
                $mail->addAddress($email, $name);

                $mail->isHTML(true);
                $mail->Subject = 'Order Confirmation';
                $mail->Body = "
                    <h3>Dear $name,</h3>
                    <p>Your order (Order Number: $orderNumber) has been <strong>confirmed</strong>.</p>
                    <p>Thank you for shopping with us!</p>
                    <br>
                    <p>Best Regards,<br>M&M Cake Ordering System</p>";

                $mail->send();
                error_log("Confirmation email sent to $email for order ID $orderId.");
            } catch (Exception $e) {
                error_log("Failed to send email: " . $mail->ErrorInfo);
                echo json_encode(['success' => false, 'message' => "Delivery status updated, but email could not be sent. Error: {$mail->ErrorInfo}"]);
                exit;
            }
        }

        echo json_encode(['success' => true, 'message' => 'Delivery status updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating delivery status: ' . $stmt->error]);
    }

    $stmt->close();
}
if ($action == 'send_otp') {
    $email = $_POST['email']; // Get email from POST
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Generate OTP
        $otp = rand(100000, 999999); // Generate a random 6-digit OTP
        
        // Store OTP in the database or session (you can decide how to store it)
        // Example of storing in the session (if you have session started):
        // session_start();
        // $_SESSION['otp'] = $otp;

        // Use PHPMailer or similar to send the OTP to the user's email
        // Assuming you have a function sendOtpEmail($email, $otp)
        $send_status = sendOtpEmail($email, $otp); // Replace with your actual sending function

        if ($send_status) {
            echo json_encode(['success' => true, 'otp' => $otp]); // Send success response
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send OTP.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    }
}
if ($action == "forgot_password") {
    // Validate email input
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $resp['status'] = 'failed';
        $resp['message'] = 'Invalid email format.';
        echo json_encode($resp);
        exit;
    }

    // Check if the email exists in the database
    $query = $conn->prepare("SELECT * FROM user_info WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Generate a secure random code with expiration
        $code = bin2hex(random_bytes(16));
        $reset_time = date('Y-m-d H:i:s');
        $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour')); // Link valid for 1 hour
        
        // Store the code, reset time, and expiry time in the database
        $update_query = $conn->prepare("UPDATE user_info SET reset_code = ?, reset_time = ?, reset_expiry = ? WHERE email = ?");
        $update_query->bind_param("ssss", $code, $reset_time, $expiry_time, $email);
        $update_query->execute();

        // Construct the reset password link (use HTTPS)
        $reset_link = "https://mandm-lawis.com/1/reset_password.php?code=" . urlencode($code) . "&email=" . urlencode($email);

        // Prepare email content
        $subject = "Password Reset Request";
        $message = "
            <html>
            <body>
                <p>Hi,</p>
                <p>You requested a password reset. Click the link below to reset your password:</p>
                <p><a href='$reset_link'>Reset Password</a></p>
                <p>This link will expire in 1 hour.</p>
                <p>If you did not request this, please ignore this email.</p>
            </body>
            </html>
        ";

        // Send the email using PHPMailer
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
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();

            $resp['status'] = 'success';
            $resp['message'] = 'Password reset instructions have been sent to your email.';
        } catch (Exception $e) {
            error_log("Email send error: " . $e->getMessage());
            $resp['status'] = 'failed';
            $resp['message'] = 'Could not send reset instructions. Please try again later.';
        }
    } else {
        $resp['status'] = 'failed';
        $resp['message'] = 'Email not found in our records.';
    }

    echo json_encode($resp);
}

if(isset($_GET['action'])) {
    $action = $_GET['action'];
    
    // Handle forgot_password action
    if ($action == "forgot_password") {
        $save = $crud->forgot_password();
        if ($save) {
            echo $save; // Send the response (success/error) back to the client
        }
    }

    // Handle reset_password action
    if ($action == "reset_password") {
        $save = $crud->reset_password();
        if ($save) {
            echo $save; // Send the response (success/error) back to the client
        }
    }
}if($action == "mark_notification_read"){
    $notification_id = $_POST['notification_id'];
    $success = mark_notification_as_read($notification_id);
    
    if($success){
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error'));
    }
    exit;
}
if($action == "update_order_status") {
    $order = $conn->query("SELECT * FROM orders where id = $order_id")->fetch_array();
    $user_id = $order['user_id'];
    
    // Update order status
    $update = $conn->query("UPDATE orders set status = $status where id = $order_id");
    
    // Create notification based on status
    if($status == 1) {
        createNotification($user_id, $order_id, "Your order #" . $order['ref_no'] . " has been confirmed!");
    } elseif($status == 2) {
        createNotification($user_id, $order_id, "Your order #" . $order['ref_no'] . " is being prepared!");
    } elseif($status == 3) {
        createNotification($user_id, $order_id, "Your order #" . $order['ref_no'] . " is ready for pickup/delivery!");
    } elseif($status == 4) {
        createNotification($user_id, $order_id, "Your order #" . $order['ref_no'] . " has been delivered!");
    }
    
    if($update)
        echo 1;
}

if (isset($_POST['action']) && $_POST['action'] == 'send_receipt') {
    $orderId = $_POST['order_id']; // Get order ID
    $email = $_POST['email']; // Get customer email
    
    // Fetch order details from the database based on $orderId
    // Example: You can retrieve the receipt HTML or generate it from data
    $receiptHtml = "<h1>Receipt for Order #$orderId</h1>";
    $receiptHtml .= "<p>Details of the order...</p>"; // Add order details here

    // Send email
    sendEmail($email, $receiptHtml);
}
// Login Action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'login2') {
    $recaptchaToken = $_POST['g-recaptcha-response'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!ReCaptcha::verify($recaptchaToken, 'login')) {
        sendResponse('error', 'Bot verification failed');
    }

    $db = new Database();
    
    if (empty($email) || empty($password)) {
        sendResponse('error', 'Email and password are required');
    }

    $userId = $db->verifyUser($email, $password);
    
    if ($userId) {
        $_SESSION['user_id'] = $userId;
        sendResponse('success', 'Login successful');
    } else {
        sendResponse('error', 'Invalid email or password');
    }
}

?>