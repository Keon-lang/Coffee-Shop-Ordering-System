<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dessert Menu</title>
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
      padding: 8px 14px;
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
      padding: 12px 25px;
      background-color: #007BFF;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 16px;
    }

    .return-btn:hover { background-color: #0056b3; }

    /* ✅ Mobile Responsive */
    @media (max-width: 768px) {
      .item {
        width: 80%;
        display: block;
        margin: 15px auto;
      }

      .return-btn {
        width: 80%;
        display: block;
        margin: 10px auto;
      }

      input[type="text"] {
        width: 50px;
        text-align: center;
        font-size: 16px;
      }

      button {
        padding: 10px 16px;
        font-size: 18px;
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

<h1>Dessert Menu</h1>

<form method="post" action="Checkout_Page.php">
  <div class="item">
    <img src="Croissant.jpg" width="200" height="200" alt="Croissant">
    <p>Croissant - RM 9</p>
    <div class="qty-controls">
      <button type="button" class="minus" onclick="updateQty('Croissant', -1)">-</button>
      <input type="text" name="Croissant" id="Croissant" value="0" size="2" readonly>
      <button type="button" class="plus" onclick="updateQty('Croissant', 1)">+</button>
    </div>
  </div>

  <div class="item">
    <img src="Muffinn.jpg" width="200" height="200" alt="Muffin">
    <p>Muffin - RM 8</p>
    <div class="qty-controls">
      <button type="button" class="minus" onclick="updateQty('Muffin', -1)">-</button>
      <input type="text" name="Muffin" id="Muffin" value="0" size="2" readonly>
      <button type="button" class="plus" onclick="updateQty('Muffin', 1)">+</button>
    </div>
  </div>

  <div class="item">
    <img src="stawberry.jpg" width="200" height="200" alt="Strawberry Cake">
    <p>Strawberry Cake - RM 8</p>
    <div class="qty-controls">
      <button type="button" class="minus" onclick="updateQty('stawberry', -1)">-</button>
      <input type="text" name="stawberry" id="stawberry" value="0" size="2" readonly>
      <button type="button" class="plus" onclick="updateQty('stawberry', 1)">+</button>
    </div>
  </div>

  <div class="item">
    <img src="Tiramisuuu.jpg" width="200" height="200" alt="Tiramisu">
    <p>Tiramisu - RM 8</p>
    <div class="qty-controls">
      <button type="button" class="minus" onclick="updateQty('Tiramisu', -1)">-</button>
      <input type="text" name="Tiramisu" id="Tiramisu" value="0" size="2" readonly>
      <button type="button" class="plus" onclick="updateQty('Tiramisu', 1)">+</button>
    </div>
  </div>

  <br>
  <button type="submit" class="return-btn">Add to Cart</button>
</form>

<a href="Second_Page.php" class="return-btn">Home</a>

</body>
</html>
