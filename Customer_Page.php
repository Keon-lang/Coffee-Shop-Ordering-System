<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['customer_name'] = $_POST['fname'];
    $_SESSION['customer_phone'] = $_POST['phone'];

    if ($_POST['pickup'] == "now") {
        $_SESSION['pickup_type'] = "Take Away";
    } else {
        $_SESSION['pickup_type'] = "Later at " . $_POST['pickupTime'];
    }

    // Redirect to menu page
    header("Location: Second_Page.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Customer Detail</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f9f9f9;
    }
    h1 {
      text-align: center;
      color: #333;
      padding: 20px;
      margin: 0;
      font-size: 1.8em;
    }
    form {
      max-width: 400px;
      margin: 30px auto;
      padding: 25px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
      color: #444;
    }
    input[type="text"],
    input[type="tel"],
    input[type="datetime-local"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      box-sizing: border-box;
    }
    input[type="radio"] {
      margin-right: 6px;
      transform: scale(1.2);
    }
    .radio-group {
      margin-bottom: 15px;
    }
    input[type="submit"] {
      background-color: #0056b3;
      border: none;
      padding: 14px 20px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      color: #fff;
      cursor: pointer;
      width: 100%;
      transition: 0.3s;
    }
    input[type="submit"]:hover {
      background-color: #004099;
    }
    #laterBox {
      margin-top: 10px;
    }
    @media (max-width: 500px) {
      form { margin: 20px; padding: 20px; }
      h1 { font-size: 1.5em; padding: 15px; }
      input[type="text"],
      input[type="tel"],
      input[type="datetime-local"] { font-size: 14px; padding: 10px; }
      input[type="submit"] { font-size: 15px; padding: 12px; }
    }
  </style>
</head>
<body>

<h1>Customer Detail</h1>

<form method="post" onsubmit="return validatePickupTime()">
  <!-- Customer Info -->
  <label for="fname">Name:</label>
  <input type="text" id="fname" name="fname" placeholder="Enter Your Name" required>

  <label for="phone">Phone number:</label>
  <input type="tel" id="phone" name="phone" placeholder="012-3456789" 
         pattern="(01[0-9]-[0-9]{7,8}|0[3-9]-[0-9]{7,8})" required>

  <!-- Order Timing -->
  <div class="radio-group">
    <label>Pickup Time:</label>
    <input type="radio" id="now" name="pickup" value="now" checked onclick="toggleLater(false)">
    <label for="now" style="display:inline; font-weight:normal;">Now</label><br>

    <input type="radio" id="later" name="pickup" value="later" onclick="toggleLater(true)">
    <label for="later" style="display:inline; font-weight:normal;">Later</label>
  </div>

  <!-- Date/Time (only shows if 'Later' selected) -->
  <div id="laterBox" style="display:none;">
    <label for="pickupTime">Select Pickup Time:</label>
    <input type="datetime-local" id="pickupTime" name="pickupTime">
  </div>

  <input type="submit" value="Submit">
</form>

<script>
function toggleLater(show) {
  document.getElementById("laterBox").style.display = show ? "block" : "none";
  if (show) setDateTimeLimits();
}

function setDateTimeLimits() {
  let now = new Date();
  let today = now.toISOString().split("T")[0];
  let min = today + "T10:00";
  let max = today + "T22:00";

  let input = document.getElementById("pickupTime");
  input.min = min;
  input.max = max;
  input.value = "";
}

function validatePickupTime() {
  if (document.getElementById("later").checked) {
    let input = document.getElementById("pickupTime");
    if (!input.value) {
      alert("Please select a pickup time.");
      return false;
    }
    let pickupDate = new Date(input.value);
    let now = new Date();
    if (pickupDate < now) {
      alert("Pickup time cannot be in the past.");
      return false;
    }
  }
  return true;
}
</script>

</body>
</html>






