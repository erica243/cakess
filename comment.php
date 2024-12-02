<?php
// Include necessary files and start session
include 'admin/db_connect.php';
session_start();

// Check if `order_id` is provided in the URL
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    die("Order ID is required to leave a comment.");
}

// Fetch the `order_id` from the URL and sanitize
$order_id = intval($_GET['order_id']);

// Check database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Query to fetch the email and order_number for the given order_id
$stmt = $conn->prepare("SELECT order_number, email FROM orders WHERE id = ?");
if (!$stmt) {
    die("Failed to prepare query: " . $conn->error);
}

$stmt->bind_param("i", $order_id);
if (!$stmt->execute()) {
    die("Failed to execute query: " . $stmt->error);
}

$result = $stmt->get_result();
$order = $result->fetch_assoc();

// Check if the order exists
if (!$order) {
    die("Order not found.");
}

// Variables for order details
$order_number = htmlspecialchars($order['order_number']);
$email = htmlspecialchars($order['email']);

// Handle the form submission
$message = ""; // To store success messages
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = htmlspecialchars($_POST['comment']);
    $uploaded_file = $_FILES['photo'] ?? null;
    $photo_path = null;

    // Handle optional photo upload
    if ($uploaded_file && $uploaded_file['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($uploaded_file['name']);
        $target_path = $upload_dir . time() . '_' . $file_name;

        // Ensure upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move uploaded file
        if (move_uploaded_file($uploaded_file['tmp_name'], $target_path)) {
            $photo_path = $target_path;
        } else {
            $message = "Failed to upload the photo.";
        }
    }

    // Insert comment into the database
    $stmt = $conn->prepare("INSERT INTO messages (order_number, email, message, photo_path) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Failed to prepare insert query: " . $conn->error);
    }
    $stmt->bind_param("ssss", $order_number, $email, $comment, $photo_path);
    if ($stmt->execute()) {
        $message = "Comment successfully submitted!";
    } else {
        $message = "Failed to submit comment: " . $stmt->error;
    }
}

// Fetch the comments and admin replies
$stmt = $conn->prepare("SELECT message, image_path, admin_reply FROM messages WHERE order_number = ? ORDER BY created_at DESC");
if (!$stmt) {
    die("Failed to prepare comments query: " . $conn->error);
}
$stmt->bind_param("s", $order_number);
if (!$stmt->execute()) {
    die("Failed to fetch comments: " . $stmt->error);
}
$comments = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave a Comment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    
    <div class="container mt-5">
    <button onclick="history.back()" class="btn btn-secondary">Back</button>
        <h2>Leave a Message for Order #<?php echo $order_number; ?></h2>
        <p>Email: <?php echo $email; ?></p>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="comment">Your Message:</label>
                <textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Write your comment here..." required></textarea>
            </div>
            <div class="form-group">
                <label for="photo">Upload a Photo (optional):</label>
                <input type="file" id="photo" name="photo" class="form-control-file" accept="image/*">
            </div>
            <button type="submit" class="btn btn-success">Submit Message</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>

        <!-- Display previous comments and admin replies -->
        <hr>
        <h3>Previous Messages:</h3>
        <?php while ($row = $comments->fetch_assoc()): ?>
            <div class="comment-box">
                <p><strong>You:</strong> <?php echo htmlspecialchars($row['message']); ?></p>
                
                <?php if (!empty($row['photo_path'])): ?>
                    <p><strong>Photo:</strong> <img src="<?php echo htmlspecialchars($row['photo_path']); ?>" alt="Uploaded Image" style="max-width: 100px;"></p>
                <?php endif; ?>
                
                <?php if (!empty($row['admin_reply'])): ?>
                    <div class="admin-reply mt-3">
                        <strong>Admin Reply:</strong>
                        <p><?php echo htmlspecialchars($row['admin_reply']); ?></p>
                    </div>
                <?php else: ?>
                    <p><em>No reply from admin yet.</em></p>
                <?php endif; ?>
            </div>
            <hr>
        <?php endwhile; ?>
    </div>
</body>
</html>
