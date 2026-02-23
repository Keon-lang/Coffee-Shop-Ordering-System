<?php
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Form | Kopi Bonet</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
    a.confirm-btn {
      display: inline-block;
      background: #28a745;
      color: white;
      padding: 12px 25px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      margin-top: 15px;
      transition: 0.3s;
    }
    a.confirm-btn:hover {
      background: #218838;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Confirm Your Payment</h1>

    <div class="first-row">
      <div class="owner">
        <h3>Owner</h3>
        <div class="input-field">
          <input type="text" id="owner" placeholder="Card Owner Name" required>
        </div>
      </div>
      <div class="cvv">
        <h3>CVV</h3>
        <div class="input-field">
          <input type="password" id="cvv" placeholder="•••" required>
        </div>
      </div>
    </div>

    <div class="second-row">
      <div class="card-number">
        <h3>Card Number</h3>
        <div class="input-field">
          <input type="text" id="cardnumber" placeholder="XXXX XXXX XXXX XXXX" required>
        </div>
      </div>
    </div>

    <div class="third-row">
      <h3>Expiry Date</h3>
      <div class="selection">
        <div class="date">
          <select id="months">
            <option>Jan</option><option>Feb</option><option>Mar</option><option>Apr</option>
            <option>May</option><option>Jun</option><option>Jul</option><option>Aug</option>
            <option>Sep</option><option>Oct</option><option>Nov</option><option>Dec</option>
          </select>
          <select id="years">
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

    <a href="#" id="confirmBtn" class="confirm-btn">Confirm</a>
  </div>

  <script>
    const confirmBtn = document.getElementById('confirmBtn');
    confirmBtn.addEventListener('click', (e) => {
      e.preventDefault();
      const owner = document.getElementById('owner').value.trim();
      const card = document.getElementById('cardnumber').value.trim();
      const cvv = document.getElementById('cvv').value.trim();

      if (!owner || !card || !cvv) {
        alert("⚠️ Please fill in all card details.");
        return;
      }

      alert("💳 Processing Payment...");
      setTimeout(() => {
        window.location.href = "update_payment.php?order_id=<?= $order_id ?>&method=Online Bank";
      }, 1500);
    });
  </script>
</body>
</html>

