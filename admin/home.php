<?php
require_once("./db_connect.php");

// Fetch data for total sales including shipping for confirmed, delivered, or other specified statuses
$total_sales_result = $conn->query("
    SELECT 
        SUM((p.price * ol.qty) + IFNULL(s.shipping_amount, 0)) AS total_sales
    FROM 
        orders o
    JOIN 
        order_list ol ON o.id = ol.order_id
    JOIN 
        product_list p ON ol.product_id = p.id
    LEFT JOIN 
        shipping_info s ON o.address = s.address
    WHERE 
        o.delivery_status IN ('pending','confirmed', 'preparing', 'ready','in_transit','delivered') -- Replace 'other_status' with any additional status
");
$total_sales = $total_sales_result->fetch_assoc()['total_sales'];

$cancelled_orders = $conn->query("SELECT * FROM orders WHERE status = 0")->num_rows;
$confirmed_orders = $conn->query("SELECT * FROM orders WHERE status = 1")->num_rows;

// Fetch data for pie chart (sales by address)
$sales_by_address_data = $conn->query("
    SELECT o.address AS address, SUM((p.price * ol.qty) + IFNULL(s.shipping_amount, 0)) AS total_sales 
    FROM order_list ol
    JOIN product_list p ON ol.product_id = p.id
    JOIN orders o ON ol.order_id = o.id
    LEFT JOIN 
        shipping_info s ON o.address = s.address
    WHERE o.delivery_status IN ('pending','confirmed', 'preparing', 'ready','in_transit','delivered')
    GROUP BY o.address
    ORDER BY total_sales DESC
");

$data = [];
while ($row = $sales_by_address_data->fetch_assoc()) {
    $data[] = $row;
}

// Fetch monthly sales data for the last 12 months
$monthly_sales_data = [];
for ($i = 0; $i < 12; $i++) {
    $date = date('Y-m', strtotime("-$i months"));
    $monthly_sales_result = $conn->query("SELECT SUM((p.price * ol.qty) + IFNULL(s.shipping_amount, 0)) AS monthly_sales 
                                          FROM orders o 
                                          JOIN order_list ol ON o.id = ol.order_id
                                          JOIN product_list p ON ol.product_id = p.id 
                                          LEFT JOIN 
        shipping_info s ON o.address = s.address
                                          WHERE  o.delivery_status IN ('pending','confirmed', 'preparing', 'ready','in_transit','delivered') AND DATE_FORMAT(o.created_at, '%Y-%m') = '$date'");
    $monthly_sales = $monthly_sales_result->fetch_assoc()['monthly_sales'];
    $month_name = date('F', strtotime($date));

    $monthly_sales_data[$month_name] = $monthly_sales ?: 0;
}

// Query to fetch total number of categories
$sql = "SELECT COUNT(*) AS total_categories FROM category_list";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_categories = $row['total_categories'];
} else {
    $total_categories = 0; // Default value if no categories found
}

// Query to fetch total number of products
$sql = "SELECT COUNT(*) AS total_products FROM product_list";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_products = $row['total_products'];
} else {
    $total_products = 0; // Default value if no products found
}

// Fetch total number of users
$sql = "SELECT COUNT(*) as total_users FROM user_info";
$result = $conn->query($sql);

$total_users = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_users = $row['total_users'];
}
// Fetch total number of orders
$sql = "SELECT COUNT(*) as total_orders FROM orders";
$result = $conn->query($sql);

$total_orders = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_orders = $row['total_orders'];
}
// Fetch the number of Pending Orders (where delivery status is 'pending', NULL, or empty)
$pending_orders_result = $conn->query("
    SELECT * 
    FROM orders 
    WHERE delivery_status = 'pending' 
       OR delivery_status IS NULL 
       OR delivery_status = ''
");
$pending_orders = $pending_orders_result->num_rows;

 
/// Fetch the number of Confirmed Orders (including statuses: confirmed, preparing, read, in_transit, delivered)
$confirmed_orders_result = $conn->query("
SELECT * 
FROM orders 
WHERE delivery_status IN ('confirmed', 'preparing', 'ready', 'in_transit', 'delivered')
");
$confirmed_orders = $confirmed_orders_result->num_rows;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Responsive Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


    <style>
        /* Enhanced Responsiveness */
        body {
            overflow-x: hidden;
        }

        .dashboard-container {
            width: 100%;
            max-width: 100%;
        }

        /* Card Responsive Adjustments */
        @media (max-width: 768px) {
            .row-cols-md-4 > .col {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 15px;
            }

            .card-responsive {
                display: flex;
                flex-direction: row;
                align-items: center;
            }

            .card-body {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
            }

            .media {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .media-left {
                margin-right: 10px;
            }

            .media-body {
                text-align: right;
            }

            .bounce-icon {
                font-size: 2rem;
            }
        }

        /* Chart Container Responsiveness */
        .chart-container {
            position: relative;
            width: 100%;
            height: 300px;
        }

        @media (max-width: 576px) {
            .chart-container {
                height: 250px;
            }
        }

        /* Scrollable Cards on Small Screens */
        @media (max-width: 768px) {
            .card-responsive {
                overflow-x: auto;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10">
                
                    <div class="card-body">
                        
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-3">
    <!-- Total Sales Card -->
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
        <div class="card rounded-0 shadow card-custom bg-blue">
            <div class="card-body" style="background: #4d94ff; color: green;">
                <div class="media">
                    <div class="media-left meida media-middle"> 
                    <span>
    <i class="fa fa-money-bill-wave animate__animated animate__bounce" style="height: 50px; width: 50px;" aria-hidden="true"></i>
</span>

                    </div>
                    <div class="media-body media-text-center">
                        <h5 class="text-right" style="color: black; font-size: 30px; font-family: courier-new;">Total Sales</h5>
                        <h2 class="text-right" style="color: black;"><b>₱<?= number_format($total_sales, 2) ?></b></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Pending Orders Card -->
<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
    <div class="card rounded-0 shadow card-custom bg-light-red">
        <div class="card-body" style="background: #ff99ff; color: red;">
            <div class="media">
                <div class="media-left meida media-middle"> 
                    <span><i class="fa fa-times-circle bounce" style="height: 50px; width: 50px;" aria-hidden="true"></i></span>
                </div>
                <div class="media-body media-text-center">
                    <h5 class="text-right" style="color: black; font-size: 30px; font-family: courier-new;">Pending Orders</h5>
                    <h2 class="text-right" style="color: black;"><b><?= number_format($pending_orders) ?></b></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmed Orders Card -->
<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
    <div class="card rounded-0 shadow card-custom bg-light-green">
        <div class="card-body" style="background: #80ff80; color: green;">
            <div class="media">
                <div class="media-left meida media-middle"> 
                    <span><i class="fa fa-check-circle bounce" style="height: 50px; width: 50px;" aria-hidden="true"></i></span>
                </div>
                <div class="media-body media-text-center">
                    <h5 class="text-right" style="color: black; font-size: 30px; font-family: courier-new;">Confirmed Orders</h5>
                    <h2 class="text-right" style="color: black;"><b><?= number_format($confirmed_orders) ?></b></h2>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Sales This Month Card -->
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
        <div class="card rounded-0 shadow card-custom bg-light-yellow">
            <div class="card-body" style="background: #ffff99; color: orange;">
                <div class="media">
                    <div class="media-left meida media-middle"> 
                        <span><i class="fa fa-chart-bar bounce" style="height: 50px; width: 50px;" aria-hidden="true"></i></span>
                    </div>
                    <div class="media-body media-text-center">
                        <h5 class="text-right" style="color: black; font-size: 30px; font-family: courier-new;">Sales This Month</h5>
                        <h2 class="text-right" style="color: black;"><b>₱<?= number_format(array_sum($monthly_sales_data)) ?></b></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row m-3">
    <!-- Total Categories Card -->
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
        <div class="card rounded-0 shadow card-custom bg-blue">
            <div class="card-body" style="background:#d1c7b5; color: #26bf33;">
                <div class="media">
                    <div class="media-left meida media-middle"> 
                        <span><i class="fa fa-folder-open bounce" style="height: 50px; width: 50px;" aria-hidden="true"></i></span>
                    </div>
                    <div class="media-body media-text-center">
                        <h5 class="text-right" style="color: black; font-size: 30px; font-family: courier-new;">Total Categories</h5>
                        <h2 class="text-right" style="color: black;"><b><?= $total_categories ?></b></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Products Card -->
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
        <div class="card rounded-0 shadow card-custom bg-blue">
            <div class="card-body" style="background:#cce5ff; color: #0056b3;">
                <div class="media">
                    <div class="media-left meida media-middle"> 
                        <span><i class="fa fa-cube bounce" style="height: 50px; width: 50px;" aria-hidden="true"></i></span>
                    </div>
                    <div class="media-body media-text-center">
                        <h5 class="text-right" style="color: black; font-size: 30px; font-family: courier-new;">Total Products</h5>
                        <h2 class="text-right" style="color: black;"><b><?= $total_products ?></b></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Users Card -->
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
        <div class="card rounded-0 shadow card-custom bg-blue">
            <div class="card-body" style="background:#d1ecf1; color: #0c5460;">
                <div class="media">
                    <div class="media-left meida media-middle"> 
                        <span><i class="fa fa-users bounce" style="height: 50px; width: 50px;" aria-hidden="true"></i></span>
                    </div>
                    <div class="media-body media-text-center">
                        <h5 class="text-right" style="color: black; font-size: 30px; font-family: courier-new;">Total Users</h5>
                        <h2 class="text-right" style="color: black;"><b><?= $total_users ?></b></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Orders Card -->
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
        <div class="card rounded-0 shadow card-custom bg-blue">
            <div class="card-body" style="background:#f8d7da; color: #721c24;">
                <div class="media">
                    <div class="media-left meida media-middle"> 
                        <span><i class="fa fa-shopping-cart bounce" style="height: 50px; width: 50px;" aria-hidden="true"></i></span>
                    </div>
                    <div class="media-body media-text-center">
                        <h5 class="text-right" style="color: black; font-size: 30px; font-family: courier-new;">Total Orders</h5>
                        <h2 class="text-right" style="color: black;"><b><?= $total_orders ?></b></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row m-3">
    <!-- Pie Chart for Sales by Address -->
    <div class="col-lg-6 col-md-12 mb-3">
        <div class="card rounded-0 shadow">
            <div class="card-body">
                <h5 class="card-title">Sales by Address</h5>
                <canvas id="salesByAddressChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Sales Chart -->
    <div class="col-lg-6 col-md-12 mb-3">
        <div class="card rounded-0 shadow">
            <div class="card-body">
                <h5 class="card-title">Monthly Sales for the Last 12 Months</h5>
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
  // Sales by Address Chart
const salesByAddressCtx = document.getElementById('salesByAddressChart').getContext('2d');
const salesByAddressData = {
    labels: <?= json_encode(array_column($data, 'address')) ?>,
    datasets: [{
        label: 'Total Sales',
        data: <?= json_encode(array_column($data, 'total_sales')) ?>,
        backgroundColor: [
            ' #ff4dff',
            '#4d4dff',
            '#e699ff', // Red
            ' #ff4da6', // Blue
            '#FFCE56', // Yellow
            '#4BC0C0', // Teal
            '#9966FF', // Purple
            '##b84dff', // Orange
            '#E7E9ED', // Gray
            '#C9CBCF'  // Light Gray
        ],
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
    }]
};
const salesByAddressChart = new Chart(salesByAddressCtx, {
    type: 'pie',
    data: salesByAddressData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Sales by Address'
            }
        }
    }
});


   // Monthly Sales Chart
const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
const monthlySalesData = {
    labels: <?= json_encode(array_keys($monthly_sales_data)) ?>,
    datasets: [{
        label: 'Monthly Sales',
        data: <?= json_encode(array_values($monthly_sales_data)) ?>,
        backgroundColor: [
            '#c266ff',  // Red
            '#64b4b4',  // Blue
            'rgba(255, 206, 86, 0.6)',  // Yellow
            'rgba(75, 192, 192, 0.6)',  // Teal
            'rgba(153, 102, 255, 0.6)', // Purple
            'rgba(255, 159, 64, 0.6)',  // Orange
            ' #ff471a',  // Red
            'rgba(54, 162, 235, 0.6)',  // Blue
            'rgba(255, 206, 86, 0.6)',  // Yellow
            'rgba(75, 192, 192, 0.6)',  // Teal
            'rgba(153, 102, 255, 0.6)', // Purple
            'rgba(255, 159, 64, 0.6)'   // Orange
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
    }]
};
const monthlySalesChart = new Chart(monthlySalesCtx, {
    type: 'bar',
    data: monthlySalesData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Monthly Sales for the Last 12 Months'
            }
        }
    }
});

</script>

</body>
</html>
