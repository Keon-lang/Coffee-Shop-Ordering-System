<?php
include 'conn.php';

$order_number = $_GET['order'] ?? '';

if (empty($order_number)) {
    die("Invalid order number. <a href='Main_Page.php'>Go back</a>");
}

// ✅ Fetch order details
$sql = "SELECT * FROM orders WHERE order_number = '$order_number'";
$result = mysqli_query($conn, $sql);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    die("Order not found. <a href='Main_Page.php'>Go back</a>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Method | Kopi Bonet</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f7f9fc;
        text-align: center;
        padding: 40px;
    }
    .card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        display: inline-block;
        max-width: 450px;
    }
    h2 {
        color: #007BFF;
    }
    .info {
        text-align: left;
        background: #f1f3f5;
        border-radius: 8px;
        padding: 15px;
        margin: 15px 0;
    }
    .btn {
        display: inline-block;
        background: #28a745;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn:hover {
        background: #218838;
    }
</style>
</head>
<body>

<div class="card">
    <h2>💳 Test Payment</h2>
    <p>Order: <strong><?= htmlspecialchars($order['order_number']) ?></strong></p>
    <div class="info">
        <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
        <p><strong>Total:</strong> RM <?= number_format($order['total_price'], 2) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    </div>

    <?php if ($order['status'] !== 'Paid'): ?>
        <form method="post" action="process_payment.php">
            <input type="hidden" name="order_number" value="<?= htmlspecialchars($order['order_number']) ?>">
            <button type="submit" class="btn">✅ Complete Test Payment</button>
        </form>
    <?php else: ?>
        <p style="color:green; font-weight:bold;">✅ This order has already been paid.</p>
        <a href="Main_Page.php" class="btn">Back to Home</a>
    <?php endif; ?>
</div>

</body>
</html>
