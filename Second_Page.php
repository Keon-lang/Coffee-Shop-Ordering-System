<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Choose Your Side Dish</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      margin: 20px;
    }
    .option {
      margin: 20px;
      display: inline-block;
    }
    img {
      border-radius: 8px;
      cursor: pointer;
      transition: transform 0.2s;
    }
    img:hover {
      transform: scale(1.1);
    }
    .return-btn {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .return-btn:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

  <h1>Choose Your Side Dish</h1>

  <div class="option">
    <a href="Dessert_Page.php">
      <img src="Dessert.jpg" alt="Dessert" width="200" height="150">
      <p>Dessert</p>
    </a>
  </div>

  <div class="option">
    <a href="Coffee_Page.php">
      <img src="Coffee.jpg" alt="Coffee" width="200" height="150">
      <p>Coffee</p>
    </a>
  </div>

  <br>
  <a href="Order.php" class="return-btn">Return</a>

</body>
</html>
