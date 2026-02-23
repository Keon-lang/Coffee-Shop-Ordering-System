<?php
// Kitchen_Dashboard.php

session_start();
// The required fix: ensure cart is initialized if needed, though less critical here
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// --------------------------------------------------------------------------------
// NOTE: Database connection and fetching logic goes here
// --------------------------------------------------------------------------------

// 1. Database Connection (e.g., using mysqli or PDO)
// $conn = new mysqli($servername, $username, $password, $dbname);

// 2. Query to fetch all PENDING orders
// $sql = "SELECT * FROM orders WHERE status = 'Pending' ORDER BY order_id ASC";
// $result = $conn->query($sql);
// $orders = $result->fetch_all(MYSQLI_ASSOC);

// MOCK DATA for demonstration without a database:
$orders = [
    [
        'order_id' => 101,
        'order_time' => '07:05 AM',
        'items' => [
            ['name' => 'Cappuccino', 'qty' => 2],
            ['name' => 'Croissant', 'qty' => 1],
        ]
    ],
    [
        'order_id' => 102,
        'order_time' => '07:08 AM',
        'items' => [
            ['name' => 'Ice Chocolate', 'qty' => 1],
            ['name' => 'Tiramisu', 'qty' => 1],
            ['name' => 'Espresso', 'qty' => 1],
        ]
    ],
];

// PHP to handle status updates (e.g., when a "Complete" button is clicked)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['complete_order_id'])) {
    $order_id_to_complete = (int)$_POST['complete_order_id'];
    
    // 3. Database Update Logic (e.g., changing status to 'Ready' or 'Completed')
    // $update_sql = "UPDATE orders SET status = 'Completed' WHERE order_id = $order_id_to_complete";
    // $conn->query($update_sql);

    // After updating the database, refresh the page to show the change
    header("Location: Kitchen_Dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kitchen Dashboard</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #34495e; /* Dark blue background */
            color: #ecf0f1; /* Light text */
            text-align: center; 
            padding: 20px;
        }
        h1 {
            color: #f1c40f; /* Yellow accent for title */
            margin-bottom: 30px;
        }
        .order-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
        }
        .order-card {
            background-color: #2c3e50; /* Slightly lighter card background */
            border: 5px solid #e74c3c; /* Red border for new orders */
            border-radius: 12px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
            text-align: left;
            transition: transform 0.2s;
        }
        .order-card:hover {
            transform: translateY(-5px);
        }
        .order-header {
            border-bottom: 2px solid #3498db; /* Blue separator */
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .order-header h2 {
            margin: 0;
            font-size: 1.8em;
            color: #3498db;
        }
        .order-header p {
            margin: 5px 0 0;
            font-size: 0.9em;
            color: #bdc3c7;
        }
        .item-list {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
        }
        .item-list li {
            background-color: #34495e;
            padding: 8px;
            margin-bottom: 5px;
            border-radius: 4px;
            font-size: 1.1em;
            display: flex;
            justify-content: space-between;
        }
        .qty {
            font-weight: bold;
            color: #2ecc71; /* Green for quantity */
            margin-right: 10px;
        }
        .complete-btn {
            width: 100%;
            padding: 12px;
            background-color: #2ecc71; /* Green "Complete" button */
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .complete-btn:hover {
            background-color: #27ae60;
        }
    </style>
    <script>
        setInterval(function() {
            window.location.reload();
        }, 10000); // Refreshes every 10 seconds (10000 milliseconds)
    </script>
</head>
<body>

<h1>Kitchen Order Dashboard</h1>

<div class="order-container">
    <?php if (empty($orders)): ?>
        <p style="color: #2ecc71; font-size: 1.5em;">All clear! Awaiting new orders.</p>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-card">
                <div class="order-header">
                    <h2>Order #<?= $order['order_id'] ?></h2>
                    <p>Time Placed: <?= $order['order_time'] ?></p>
                </div>
                
                <ul class="item-list">
                    <?php foreach ($order['items'] as $item): ?>
                        <li>
                            <span class="qty">x<?= $item['qty'] ?></span>
                            <span><?= $item['name'] ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                
                <form method="post">
                    <input type="hidden" name="complete_order_id" value="<?= $order['order_id'] ?>">
                    <button type="submit" class="complete-btn">Order Ready / Complete</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>