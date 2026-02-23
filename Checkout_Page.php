<?php
session_start();

// FIX: Ensure the cart is initialized as an array if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Prices for all items
$prices = [
    "cappuccino" => 9,
    "icechoco" => 8,
    "caramel" => 8,
    "espresso" => 8,
    "Croissant" => 9,
    "Muffin" => 8,
    "stawberry" => 8, // Note: Typo 'stawberry' is preserved for ID consistency
    "Tiramisu" => 8
];

// Handle all POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? null;
    $item = $_POST['item'] ?? null;
    
    if ($action && $item && isset($_SESSION['cart'][$item])) {
        if ($action === "plus") {
            $_SESSION['cart'][$item]++;
        } elseif ($action === "minus") {
            $_SESSION['cart'][$item]--;
            if ($_SESSION['cart'][$item] <= 0) {
                unset($_SESSION['cart'][$item]);
            }
        } elseif ($action === "remove") {
            unset($_SESSION['cart'][$item]);
        }
    } else {
        foreach ($prices as $menu_item => $price) {
            $qty = (int)($_POST[$menu_item] ?? 0);
            if ($qty > 0) {
                $_SESSION['cart'][$menu_item] = ($_SESSION['cart'][$menu_item] ?? 0) + $qty;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            max-width: 700px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .return-btn {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .return-btn:hover { background-color: #0056b3; }

        form.inline { display:inline; }

        button {
            padding: 6px 12px;
            margin: 2px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .plus { background-color: #28a745; color: white; }
        .minus { background-color: #ffc107; color: black; }
        .remove { background-color: #dc3545; color: white; }

        /* ✅ Mobile Responsive */
        @media (max-width: 768px) {
            table {
                width: 95%;
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }

            button {
                font-size: 13px;
                padding: 5px 8px;
            }

            .return-btn {
                width: 90%;
                display: block;
                margin: 8px auto;
                font-size: 15px;
            }

            h1 {
                font-size: 22px;
            }
        }

        @media (max-width: 480px) {
            th, td {
                font-size: 12px;
                padding: 6px;
            }

            button {
                font-size: 12px;
                padding: 5px 7px;
            }
        }
    </style>
</head>
<body>

<h1>Checkout Summary</h1>

<?php if (!empty($_SESSION['cart'])): ?>
<table>
    <tr>
        <th>Item</th>
        <th>Qty</th>
        <th>Price (RM)</th>
        <th>Subtotal (RM)</th>
        <th>Action</th>
    </tr>
    <?php 
        $grandTotal = 0;
        function getItemDisplayName($key) {
            $map = [
                'cappuccino' => 'Cappuccino', 
                'icechoco' => 'Ice Chocolate', 
                'caramel' => 'Caramel Latte', 
                'espresso' => 'Espresso', 
                'Croissant' => 'Croissant', 
                'Muffin' => 'Muffin', 
                'stawberry' => 'Strawberry Cake', 
                'Tiramisu' => 'Tiramisu'
            ];
            return $map[$key] ?? ucfirst($key);
        }

        foreach ($_SESSION['cart'] as $item => $qty):
            if (!isset($prices[$item])) continue;
            $subtotal = $prices[$item] * $qty;
            $grandTotal += $subtotal;
    ?>
        <tr>
            <td><?= getItemDisplayName($item) ?></td>
            <td><?= $qty ?></td>
            <td><?= $prices[$item] ?></td>
            <td><?= $subtotal ?></td>
            <td>
                <form method="post" class="inline">
                    <input type="hidden" name="item" value="<?= $item ?>">
                    <button type="submit" name="action" value="plus" class="plus">+</button>
                    <button type="submit" name="action" value="minus" class="minus">-</button>
                    <button type="submit" name="action" value="remove" class="remove">Remove</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <th colspan="3">Total</th>
        <th>RM <?= number_format($grandTotal, 2) ?></th>
        <th></th>
    </tr>
</table>
<?php else: ?>
    <p>No items in your cart.</p>
<?php endif; ?>

<a href="Coffee_Page.php" class="return-btn">Back to Coffee</a>
<a href="Dessert_Page.php" class="return-btn">Back to Dessert</a>
<a href="Order.php" class="return-btn">Home</a>
<a href="Number_Order.php" class="return-btn">Submit Order</a> 

</body>
</html>
