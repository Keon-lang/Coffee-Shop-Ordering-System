<?php
session_start();
include 'conn.php'; // ✅ database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method'])) {
    $payment_method = $_POST['payment_method'] ?? '';
    $order_id = $_SESSION['order_id'] ?? ($_GET['order_id'] ?? null);

    if (empty($order_id)) {
        echo "<script>alert('Order ID not found.'); window.location.href='cart.php';</script>";
        exit;
    }

    // ✅ Save payment method into orders table
    $stmt = $conn->prepare("UPDATE orders SET payment_method = ? WHERE id = ?");
    $stmt->bind_param("si", $payment_method, $order_id);
    $stmt->execute();
    $stmt->close();

    // ✅ Also record into payments table (for tracking)
    $stmt2 = $conn->prepare("INSERT INTO payments (order_id, payment_method, payment_status) VALUES (?, ?, 'Unpaid')");
    $stmt2->bind_param("is", $order_id, $payment_method);
    $stmt2->execute();
    $stmt2->close();

    // ✅ Redirect user to correct page
    if ($payment_method === 'Pay at Counter') {
        header('Location: pay_at_counter.php?order_id=' . urlencode($order_id));
        exit;
    } elseif ($payment_method === 'Online Bank') {
        // stays on same page and shows the payment form
    } else {
        echo "<script>alert('Please select a payment method.'); window.history.back();</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Form | Kopi Bonet</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f0f4f8, #dfe9f3);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      width: 400px;
      text-align: center;
      animation: fadeIn 0.6s ease;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    h1 { color: #007BFF; margin-bottom: 25px; }
    h3 { margin-bottom: 8px; }
    .input-field input, select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
    }
    .cards img {
      width: 50px;
      margin: 0 5px;
    }
    .confirm-btn {
      display: inline-block;
      background: #28a745;
      color: white;
      padding: 12px 25px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      margin-top: 15px;
      transition: 0.3s;
      border: none;
      cursor: pointer;
    }
    .confirm-btn:hover {
      background: #218838;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <form class="container" action="thank_you.php" method="post">
    <h1>Confirm Your Payment</h1>

    <div class="first-row">
      <div class="owner">
        <h3>Owner</h3>
        <div class="input-field">
          <input type="text" name="owner" placeholder="Card Owner Name" required>
        </div>
      </div>
      <div class="cvv">
        <h3>CVV</h3>
        <div class="input-field">
          <input type="password" name="cvv" placeholder="•••" required>
        </div>
      </div>
    </div>

    <div class="second-row">
      <div class="card-number">
        <h3>Card Number</h3>
        <div class="input-field">
          <input type="text" name="cardnumber" placeholder="XXXX XXXX XXXX XXXX" required>
        </div>
      </div>
    </div>

    <div class="third-row">
      <h3>Expiry Date</h3>
      <div class="selection">
        <div class="date">
          <select name="months" required>
            <option value="">Month</option>
            <option>Jan</option><option>Feb</option><option>Mar</option><option>Apr</option>
            <option>May</option><option>Jun</option><option>Jul</option><option>Aug</option>
            <option>Sep</option><option>Oct</option><option>Nov</option><option>Dec</option>
          </select>
          <select name="years" required>
            <option value="">Year</option>
            <option>2025</option><option>2026</option><option>2027</option>
            <option>2028</option><option>2029</option><option>2030</option>
          </select>
        </div>
        <div class="cards">
          <img src="mc.png" alt="MasterCard">
          <img src="vi.png" alt="Visa">
          <img src="pp.png" alt="PayPal">
        </div>
      </div>
    </div>

    <button type="submit" class="confirm-btn">Confirm</button>
  </form>
</body>
</html>
