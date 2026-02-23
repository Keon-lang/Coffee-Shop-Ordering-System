<?php
session_start();
include 'conn.php';

// Try to get order info if available
$order_id = $_GET['order_id'] ?? null;
$order = null;

if ($order_id) {

    // ✅ Update the payment status for this order
    $update_payment = $conn->prepare("
        UPDATE payments 
        SET payment_status = 'Paid', paid_at = NOW() 
        WHERE order_id = ?
    ");
    $update_payment->bind_param("i", $order_id);
    $update_payment->execute();
    $update_payment->close();

    // ✅ Update the order status to 'Paid' as well
    $update_order = $conn->prepare("
        UPDATE orders 
        SET status = 'Paid' 
        WHERE id = ?
    ");
    $update_order->bind_param("i", $order_id);
    $update_order->execute();
    $update_order->close();

    // ✅ Fetch updated order info
    $result = mysqli_query($conn, "SELECT * FROM orders WHERE id = '$order_id'");
    if ($result && mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Thank You | Kopi Bonet</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f0f4f8, #dfe9f3);
        text-align: center;
        padding: 60px 20px;
    }
    .box {
        background: white;
        display: inline-block;
        padding: 40px 60px;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        max-width: 450px;
        animation: fadeIn 0.6s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    h1 {
        color: #28a745;
        margin-bottom: 15px;
    }
    .details {
        text-align: left;
        background: #f8f9fa;
        border-left: 4px solid #28a745;
        padding: 15px;
        border-radius: 10px;
        margin-top: 15px;
    }
    .btn {
        display: inline-block;
        margin-top: 25px;
        background-color: #007BFF;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
</style>
</head>
<body>

<div class="box">
    <h1>Payment Successful!</h1>
    <p>Thank you for your payment. Your order has been recorded.</p>

    <?php if ($order): ?>
        <div class="details">
            <p><strong>Order Number:</strong> <?= htmlspecialchars($order['order_number']) ?></p>
            <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
            <p><strong>Payment Method:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
            <p><strong>Total:</strong> RM <?= number_format($order['total_price'], 2) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
        </div>
    <?php else: ?>
        <p></p>
    <?php endif; ?>

    <a href="Order.php" class="btn">Back to Menu</a>
</div>

</body>
</html>
