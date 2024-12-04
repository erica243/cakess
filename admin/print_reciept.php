<?php
include 'db_connect.php';

$orderId = $_GET['id']; // Get the order ID from the query parameter

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Fetch order items
$stmt = $conn->prepare("SELECT o.qty, p.name, p.description, p.price, 
                                (o.qty * p.price) AS amount
                        FROM order_list o 
                        INNER JOIN product_list p ON o.product_id = p.id 
                        WHERE o.order_id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$orderItems = $stmt->get_result();

// Fetch shipping information
$address = $order['address'];
$shippingStmt = $conn->prepare("SELECT shipping_amount FROM shipping_info WHERE address = ?");
$shippingStmt->bind_param("s", $address);
$shippingStmt->execute();
$shippingResult = $shippingStmt->get_result();
$shippingAmount = $shippingResult->fetch_assoc()['shipping_amount'] ?? 0;

// Total calculation
$total = 0;
$orderItems->data_seek(0);
while ($row = $orderItems->fetch_assoc()) {
    $total += $row['amount'];
}

// Receipt HTML
echo "<html><head><title>Receipt</title>
    <style>body { font-family: Arial, sans-serif; }</style></head><body>";
echo '<div style="text-align: center;">';
echo '<img src="assets/img/logo.jpg" style="width: 200px;"><br>';
echo '<h2>Receipt</h2></div>';
echo '<p>Order Number: ' . $order['order_number'] . '</p>';
echo '<p>Order Date: ' . date("m-d-Y", strtotime($order['order_date'])) . '</p>';
echo '<p>Customer Name: ' . $order['name'] . '</p>';
echo '<p>Address: ' . $order['address'] . '</p>';
echo '<p>Delivery Method: ' . $order['delivery_method'] . '</p>';
echo '<p>Payment Method: ' . $order['payment_method'] . '</p>';

echo '<br><br>';
echo '<table border="1" style="width: 100%; text-align: left; border-collapse: collapse;">';
echo '<tr><th>Product</th><th>Description</th><th>Qty</th><th>Price</th><th>Amount</th></tr>';

$orderItems->data_seek(0); // Reset pointer
while ($row = $orderItems->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['description'] . '</td>';
    echo '<td>' . $row['qty'] . '</td>';
    echo '<td>' . number_format($row['price'], 2) . '</td>';
    echo '<td>' . number_format($row['amount'], 2) . '</td>';
    echo '</tr>';
}

echo '</table>';
echo '<br><br>';
echo '<p>Shipping Amount: ' . number_format($shippingAmount, 2) . '</p>';
echo '<h3>Total: ' . number_format($total + $shippingAmount, 2) . '</h3>';
echo '</body></html>';
?>
