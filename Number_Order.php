<?php
session_start();
include 'conn.php';

// ✅ Ensure the cart is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "No items in your cart. <a href='Second_Page.php'>Go back to menu</a>";
    exit;
}

// ✅ Price list (you can edit these as needed)
$prices = [
    "cappuccino" => 9,
    "icechoco"   => 8,
    "caramel"    => 8,
    "espresso"   => 8,
    "Croissant"  => 9,
    "Muffin"     => 8,
    "stawberry"  => 8,
    "Tiramisu"   => 8
];

// ✅ Calculate total and build order summary
$grandTotal = 0;
$orderItemsText = "";

foreach ($_SESSION['cart'] as $item => $qty) {
    if (isset($prices[$item])) {
        $subtotal = $prices[$item] * $qty;
        $grandTotal += $subtotal;
        $orderItemsText .= ucfirst($item) . " x" . $qty . " (RM" . $subtotal . ")\n";
    }
}

// ✅ Get order details
$pickup_type   = $_SESSION['pickup_type'] ?? 'Take Away';
$customer_name = $_SESSION['customer_name'] ?? 'Guest';
$table_id      = $_SESSION['table_id'] ?? null;

// ✅ Decide display ID and DB value based on pickup type
if ($pickup_type === "Dine-In" && !empty($table_id)) {
    $display_id = "Table " . htmlspecialchars($table_id);
    $order_number = $table_id; // Save table number instead of random order number
} else {
    $order_number = rand(100, 999);
    $display_id = $order_number;
}

// ✅ Insert order into database
$sql = "INSERT INTO orders (order_number, customer_name, pickup_type, order_items, total_price, status) 
        VALUES ('$order_number', '$customer_name', '$pickup_type', '$orderItemsText', '$grandTotal', 'Pending')";

if (mysqli_query($conn, $sql)) {
    // ✅ Clear only the cart, keep other info until after page loads
    unset($_SESSION['cart']);
} else {
    die("❌ Error saving order: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f0f4f8, #dfe9f3);
      margin: 0;
      padding: 20px;
      text-align: center;
    }
    .box {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.15);
      display: inline-block;
      padding: 30px;
      max-width: 450px;
      width: 90%;
      margin-top: 60px;
      animation: fadeIn 0.6s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    h2 {
      color: #007BFF;
    }
    .order-number {
      font-size: 20px;
      font-weight: bold;
      color: #dc3545;
      margin: 10px 0;
    }
    .details {
      background: #f8f9fa;
      border-left: 4px solid #007BFF;
      padding: 15px;
      border-radius: 8px;
      text-align: left;
    }
    pre {
      background: #f1f3f5;
      padding: 8px;
      border-radius: 6px;
      font-family: monospace;
      font-size: 14px;
    }
    .btn {
      display: inline-block;
      margin-top: 20px;
      background: #28a745;
      color: white;
      padding: 12px 25px;
      border-radius: 8px;
      text-decoration: none;
      transition: 0.3s;
    }
    .btn:hover {
      background: #218838;
      transform: scale(1.05);
    }
    @media (max-width: 480px) {
      .box { padding: 20px; width: 95%; }
      .btn { width: 100%; }
    }
  </style>
</head>
<body>

  <div class="box">
    <h2>✅ Order Submitted Successfully!</h2>
    <p class="order-number">
      <?= ($pickup_type === "Dine-In") ? "Table Number: " . htmlspecialchars($table_id) : "Order No: " . htmlspecialchars($order_number); ?>
    </p>

    <div class="details">
      <p><strong>Customer:</strong> <?= htmlspecialchars($customer_name) ?></p>
      <p><strong>Order Type:</strong> <?= htmlspecialchars($pickup_type) ?></p>
      <p><strong>Total Amount:</strong> RM <?= number_format($grandTotal, 2) ?></p>
      <p><strong>Items:</strong></p>
      <pre><?= htmlspecialchars($orderItemsText) ?></pre>
      <p><strong>Status:</strong> Pending (Sent to Kitchen)</p>
    </div>

    <a href="Payment_Page.php" class="btn">Proceed to Pay</a>
  </div>

</body>
</html>

<?php
// ✅ Clear all order-related session data after order confirmation
unset($_SESSION['order_number']);
unset($_SESSION['pickup_type']);
unset($_SESSION['table_id']);
unset($_SESSION['customer_name']);
unset($_SESSION['customer_phone']);
unset($_SESSION['pickup_time']);
?>

