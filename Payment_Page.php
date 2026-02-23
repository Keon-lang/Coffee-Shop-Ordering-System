<?php
include 'conn.php';
session_start();

// Get latest order
$order = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC LIMIT 1");
$orderData = ($order && mysqli_num_rows($order) > 0) ? mysqli_fetch_assoc($order) : null;
$order_id = $orderData['id'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Select Payment Method | Kopi Bonet</title>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #f0f4f8, #dfe9f3);
    text-align: center;
    padding: 60px 20px;
  }
  .container {
    background: #fff;
    display: inline-block;
    padding: 40px 50px;
    border-radius: 15px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    max-width: 400px;
    animation: fadeIn 0.6s ease;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  h2 {
    color: #007BFF;
    margin-bottom: 25px;
  }
  label {
    display: block;
    background: #f8f9fa;
    border: 2px solid transparent;
    border-radius: 10px;
    padding: 15px;
    margin: 10px 0;
    cursor: pointer;
    transition: 0.3s;
  }
  input[type="radio"] {
    display: none;
  }
  input[type="radio"]:checked + label {
    border-color: #007BFF;
    background: #e8f0fe;
  }
  button {
    background: #28a745;
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    margin-top: 20px;
    cursor: pointer;
    transition: 0.3s;
  }
  button:hover {
    background: #218838;
    transform: scale(1.05);
  }
</style>
</head>
<body>

<div class="container">
  <h2>Select Your Payment Method</h2>
  
  <form action="process_payment.php" method="POST">
    <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">

    <input type="radio" id="paycounter" name="payment_method" value="Pay at Counter">
    <label for="paycounter">Pay at Counter</label>

    <input type="radio" id="onlinebank" name="payment_method" value="Online Bank">
    <label for="onlinebank">Online Bank Transfer</label>

    <button type="submit">Continue</button>
  </form>
</div>

</body>
</html>
