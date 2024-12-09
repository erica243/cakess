<?php
// Include necessary files and start session
include 'db_connect.php';


// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Check if admin is logged in
if (!isset($_SESSION['login_id']) || $_SESSION['login_type'] != 1) {
    header('Location: login.php');
    exit;
}

// Fetch messages that haven't been replied to by the admin yet
$stmt = $conn->prepare("SELECT * FROM messages WHERE admin_reply IS NULL ORDER BY created_at DESC");
$stmt->execute();
$messages = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin - Messages</title>
    <?php include './header.php'; ?>
</head>
<style>
    main#view-panel {
        margin: 20px;
        padding: 20px;
        margin-left: 160px;
        float: left;
    }

    .table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
    }

    .table th, .table td {
        text-align: left;
        padding: 8px;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #f4f4f4;
    }

    .table img {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
    }
</style>

<body>
    <?php include 'topbar.php'; ?>
    <?php include 'navbar.php'; ?>

    <main id="view-panel">
        <h1>Admin Messages</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Message ID</th>
                    <th>Email</th>
                    <th>Order Number</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Image</th>
                    <th>User Reply</th>
                    <th>Reply</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $messages->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['order_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo date('Y-m-d H:i:s', strtotime($row['created_at'])); ?></td>
                    <td>
                        <?php
                        // Check if the photo exists and is readable
                        $photo_path = htmlspecialchars($row['photo_path']);
                        if (!empty($photo_path)) {
                            $full_image_path = "../uploads/" . $photo_path;

                            // Full server path to check file existence
                            $full_server_path = $_SERVER['DOCUMENT_ROOT'] . $full_image_path;

                            if (file_exists($full_server_path) && is_readable($full_server_path)) {
                                // Mime type check
                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                $mime_type = finfo_file($finfo, $full_server_path);
                                finfo_close($finfo);

                                if (strpos($mime_type, 'image') === 0) {
                                    echo '<a href="' . $full_image_path . '" data-fancybox="gallery" data-caption="User Image">';
                                    echo '<img src="' . $full_image_path . '" alt="User Image">';
                                    echo '</a>';
                                } else {
                                    echo 'Invalid file type';
                                }
                            } else {
                                echo 'Image file not found or not readable';
                            }
                        } else {
                            echo 'No image available';
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['user_reply']) ?: 'No reply from user'; ?>
                    </td>
                    <td>
                        <button class="btn btn-primary" onclick="showReplyForm(<?php echo $row['user_id']; ?>)">Reply</button>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>    
    </main>

    <!-- Modal for replying to messages -->
    <div class="modal fade" id="reply_modal" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reply to Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="reply_form" method="post">
                        <input type="hidden" name="message_id" id="message_id">
                        <div class="form-group">
                            <label for="reply_message">Reply Message:</label>
                            <textarea class="form-control" name="reply_message" id="reply_message" rows="4" required></textarea>
                        </div>
                        <button type="submit" name="reply" class="btn btn-primary">Send Reply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="path/to/jquery.js"></script> <!-- Adjust the path to your jQuery file -->
    <script src="path/to/bootstrap.js"></script> <!-- Adjust the path to your Bootstrap JS file -->
    <script>
        function showReplyForm(messageId) {
            $('#message_id').val(messageId);
            $('#reply_message').val(''); // Clear previous reply
            $('#reply_modal').modal('show');
        }
    </script>
</body>
</html>
