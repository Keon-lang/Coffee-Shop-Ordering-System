<?php
session_start();

// If form is submitted, save Table ID into session
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION['table_id'] = $_POST['fname'];
    $_SESSION['pickup_type'] = "Dine-In"; // mark as dine-in order
    header("Location: Second_Page.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Table ID Entry</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f9f9f9;
    }
    .form-container {
      text-align: center;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    }
    input[type="text"] {
      padding: 10px;
      width: 80%;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-top: 10px;
    }
    input[type="submit"] {
      margin-top: 20px;
      padding: 10px 20px;
      border: none;
      background: #007BFF;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background: #0056b3;
    }
    .error {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <header>
      <h1>Enter Your Table ID</h1>
    </header> 
    <form method="POST" onsubmit="return validateForm()">
      <label for="fname">Table ID:</label><br>
      <input type="text" id="fname" name="fname" placeholder="Please Enter Your ID" required><br>
      <input type="submit" value="Next">
      <p id="errorMsg" class="error"></p>
    </form>
  </div>

  <script>
function validateForm() {
  const tableID = document.getElementById("fname").value.trim();
  const errorMsg = document.getElementById("errorMsg");

  // Clear previous message
  errorMsg.textContent = "";

  // Must be a number
  if (!/^[0-9]+$/.test(tableID)) {
    errorMsg.textContent = "❌ Table number must be numbers only.";
    return false;
  }

  // Convert to integer
  const tableNum = parseInt(tableID, 10);

  // Limit between 1 and 30
  if (tableNum < 1 || tableNum > 30) {
    errorMsg.textContent = "❌ Table number must be between 1 and 30.";
    return false;
  }

  return true; // ✅ valid
}
</script>

</body>
</html>
