<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee Menu</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      margin: 0;
      padding: 0;
      background-color: #fafafa;
    }

    h1 {
      color: black;
      padding: 15px;
      margin: 0 0 20px 0;
    }

    .item {
      display: inline-block;
      margin: 15px;
      border: 1px solid #ccc;
      padding: 15px;
      border-radius: 10px;
      background-color: white;
      width: 220px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    img {
      display: block;
      margin: 0 auto 10px;
      border-radius: 8px;
      max-width: 100%;
      height: auto;
    }

    .qty-controls {
      margin: 10px 0;
    }

    button {
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .plus { background-color: #28a745; color: white; }
    .minus { background-color: #ffc107; color: black; }

    .return-btn {
      display: inline-block;
      margin: 15px;
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 16px;
    }

    .return-btn:hover {
      background-color: #0056b3;
    }

    /* ✅ Responsive Design */
    @media (max-width: 768px) {
      .item {
        width: 80%;
        margin: 10px auto;
        display: block;
      }

      .return-btn {
        width: 80%;
        display: block;
        margin: 10px auto;
      }

      input[type="text"] {
        width: 40px;
        text-align: center;
      }
    }
  </style>

  <script>
    function updateQty(id, change) {
      let input = document.getElementById(id);
      let newVal = parseInt(input.value) + change;
      if (newVal < 0) newVal = 0;
      input.value = newVal;
    }
  </script>
</head>
<body>

<h1>Coffee Menu</h1>

<form method="post" action="Checkout_Page.php">
  <div class="item">
    <img src="Cappuccinooo.jpg" width="200" height="200" alt="Cappuccino">
    <p>Cappuccino - RM 9</p>
    <div class="qty-controls">
      <button type="button" class="minus" onclick="updateQty('cappuccino', -1)">-</button>
      <input type="text" name="cappuccino" id="cappuccino" value="0" size="2" readonly>
      <button type="button" class="plus" onclick="updateQty('cappuccino', 1)">+</button>
    </div>
  </div>

  <div class="item">
    <img src="Ice_Chocolateee.jpg" width="200" height="200" alt="Ice Chocolate">
    <p>Ice Chocolate - RM 8</p>
    <div class="qty-controls">
      <button type="button" class="minus" onclick="updateQty('icechoco', -1)">-</button>
      <input type="text" name="icechoco" id="icechoco" value="0" size="2" readonly>
      <button type="button" class="plus" onclick="updateQty('icechoco', 1)">+</button>
    </div>
  </div>

  <div class="item">
    <img src="hot-caramel.jpg" width="200" height="200" alt="Caramel Latte">
    <p>Caramel Latte - RM 8</p>
    <div class="qty-controls">
      <button type="button" class="minus" onclick="updateQty('caramel', -1)">-</button>
      <input type="text" name="caramel" id="caramel" value="0" size="2" readonly>
      <button type="button" class="plus" onclick="updateQty('caramel', 1)">+</button>
    </div>
  </div>

  <div class="item">
    <img src="Hot_Espresso_Coffee.jpg" width="200" height="200" alt="Espresso">
    <p>Espresso - RM 8</p>
    <div class="qty-controls">
      <button type="button" class="minus" onclick="updateQty('espresso', -1)">-</button>
      <input type="text" name="espresso" id="espresso" value="0" size="2" readonly>
      <button type="button" class="plus" onclick="updateQty('espresso', 1)">+</button>
    </div>
  </div>

  <br>
  <button type="submit" class="return-btn">Add to Cart</button>
</form>

<a href="Second_Page.php" class="return-btn">Home</a>

</body>
</html>






