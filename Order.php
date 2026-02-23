<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Choose Your Side Dish</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      text-align: center;
      margin: 0;
      padding: 20px;
      background: linear-gradient(135deg, #ffffffff, #e0eafc);
      min-height: 100vh;
    }

    h1 {
      margin-bottom: 40px;
      color: #333;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
      font-size: 2em;
      letter-spacing: 1px;
    }

    .option {
      margin: 20px;
      display: inline-block;
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      overflow: hidden;
      width: 230px;
    }

    .option:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 18px rgba(0,0,0,0.25);
    }

    img {
      border-bottom: 3px solid #007BFF;
      border-radius: 15px 15px 0 0;
      cursor: pointer;
      transition: transform 0.3s ease;
      width: 100%;
      height: auto;
    }

    img:hover {
      transform: scale(1.05);
    }

    p {
      margin: 15px 0;
      font-weight: 600;
      color: #333;
      font-size: 1.1em;
      letter-spacing: 0.5px;
    }

    .return-btn {
      display: inline-block;
      margin-top: 40px;
      padding: 12px 25px;
      background-color: #007BFF;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      letter-spacing: 0.5px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.2);
      transition: background 0.3s ease, transform 0.3s ease;
    }

    .return-btn:hover {
      background-color: #0056b3;
      transform: translateY(-2px);
    }

    footer {
      margin-top: 60px;
      font-size: 14px;
      color: #666;
    }

    /* Optional glow hover for a modern touch */
    .option:hover img {
      box-shadow: 0 0 15px rgba(0,123,255,0.5);
    }
  </style>
</head>
<body>

  <h1>Choose Your Order</h1>

  <div class="option">
    <a href="Customer_Page.php">
      <img src="Take_Awayy.png" alt="Take_Away" width="210" height="150">
      <p>Take Away</p>
    </a>
  </div>

  <div class="option">
    <a href="First_Page.php">
      <img src="Dine_In.png" alt="Coffee" width="200" height="150">
      <p>Dine In</p>
    </a>
  </div>

  <footer>
    &copy; 2025 Kopi Bonet Café — All Rights Reserved
  </footer>

</body>
</html>
