<?php
include 'conn.php';

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id <= 0) {
    die("❌ Invalid order ID.");
}

// 🟢 Fetch order details
$sql = "SELECT * FROM orders WHERE id = $order_id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("❌ Order not found.");
}

$order = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Successful | Kopi Bonet</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #d4fc79, #96e6a1);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .success-box {
      background: white;
      padding: 40px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      animation: fadeIn 0.6s ease;
      width: 400px;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .success-icon {
      font-size: 70px;
      color: #28a745;
      margin-bottom: 20px;
    }
    h1 {
      color: #28a745;
      margin-bottom: 10px;
    }
    p {
      color: #333;
      margin: 5px 0;
    }
    .order-summary {
      text-align: left;
      background: #f9f9f9;
      padding: 15px;
      border-radius: 10px;
      margin-top: 15px;
    }
    .back-btn {
      display: inline-block;
      margin-top: 20px;
      background: #007BFF;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }
    .back-btn:hover {
      background: #0056b3;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="success-box">
    <div class="success-icon">✅</div>
    <h1>Payment Successful!</h1>
    <p>Thank you for your payment.</p>
    <p><strong>Order ID:</strong> <?= htmlspecialchars($order['id']) ?></p>
    <p><strong>Payment Method:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>

    <div class="order-summary">
      <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
      <p><strong>Total:</strong> RM <?= number_format($order['total_price'], 2) ?></p>
      <p><strong>Pickup Type:</strong> <?= htmlspecialchars($order['pickup_type']) ?></p>
      <p><strong>Created At:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
    </div>

    <a href="Order.php" class="back-btn">Return to Menu</a>
  </div>
</body>
</html>
