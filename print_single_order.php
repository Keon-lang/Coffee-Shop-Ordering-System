<?php
include 'conn.php';

if (!isset($_GET['id'])) {
    die("Order ID missing.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Print Order #<?= htmlspecialchars($order['order_number']) ?> | Kopi Bonet</title>
<style>
    /* Thermal printer width: 58mm */
    body {
        font-family: 'Courier New', monospace;
        font-size: 12px;
        width: 58mm;
        margin: 0 auto;
        padding: 0;
        color: #000;
        background: #fff;
    }

    h2, h3 {
        text-align: center;
        margin: 2px 0;
        padding: 0;
    }

    .line {
        border-top: 1px dashed #000;
        margin: 4px 0;
    }

    .info {
        margin: 0;
        padding: 0 4px;
    }
    .info p {
        margin: 1px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 4px;
    }
    th, td {
        padding: 2px 4px;
        text-align: left;
        vertical-align: top;
    }

    .total {
        font-weight: bold;
        text-align: right;
        border-top: 1px dashed #000;
        margin-top: 4px;
        padding-top: 4px;
    }

    .footer {
        text-align: center;
        font-size: 11px;
        margin-top: 6px;
        border-top: 1px dashed #000;
        padding-top: 4px;
    }

    button {
        display: block;
        width: 100%;
        background: #007bff;
        color: #fff;
        border: none;
        padding: 8px 0;
        cursor: pointer;
        font-weight: bold;
        margin-top: 8px;
        border-radius: 3px;
    }

    button:hover {
        background: #0056b3;
    }

    @media print {
        button {
            display: none;
        }
        body {
            margin: 0;
            padding: 0;
            background: #fff;
        }
    }
</style>
</head>
<body>

<h2>☕ KOPI BONET</h2>
<h3>Order Receipt</h3>
<div class="line"></div>

<div class="info">
    <p><strong>Order #:</strong> <?= htmlspecialchars($order['order_number']) ?></p>
    <?php if ($order['pickup_type'] === 'Dine-in' && !empty($order['table_number'])): ?>
        <p><strong>Table:</strong> <?= htmlspecialchars($order['table_number']) ?></p>
    <?php endif; ?>
    <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
    <p><strong>Type:</strong> <?= htmlspecialchars($order['pickup_type']) ?></p>
    <p><strong>Payment:</strong> <?= htmlspecialchars($order['payment_method'] ?? 'N/A') ?></p>
    <p><strong>Date:</strong> <?= date("d M Y, h:i A", strtotime($order['created_at'])) ?></p>
</div>

<div class="line"></div>

<table>
    <tr><th>Items</th></tr>
    <tr><td><?= nl2br(htmlspecialchars($order['order_items'])) ?></td></tr>
</table>

<div class="total">
    Total: RM <?= number_format($order['total_price'], 2) ?>
</div>

<div class="footer">
    <p>Status: <?= htmlspecialchars($order['status']) ?></p>
    <p>Thank you! ☕</p>
</div>

<button onclick="window.print()">🖨️ Print Order</button>

</body>
</html>
