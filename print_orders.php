<?php
include 'conn.php';

// Handle date picker filter
$selectedDate = $_GET['date'] ?? '';
$filterSql = '';

if (!empty($selectedDate)) {
    $filterSql = "WHERE DATE(created_at) = '" . mysqli_real_escape_string($conn, $selectedDate) . "'";
}

// Fetch orders based on date filter
$sql = "SELECT * FROM orders $filterSql ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Print Orders | Kopi Bonet</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 20px;
        background: white;
        color: #000;
    }
    h1 {
        text-align: center;
        color: #007BFF;
        margin-bottom: 10px;
    }
    .filter {
        text-align: center;
        margin-bottom: 20px;
    }
    input[type="date"] {
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 15px;
        margin-right: 10px;
    }
    button {
        background: #007BFF;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
    }
    button:hover {
        background: #0056b3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: auto;
    }
    th, td {
        padding: 10px;
        border: 1px solid #000;
        text-align: center;
    }
    th {
        background: #007BFF;
        color: white;
    }
    tr:nth-child(even) {
        background: #f9f9f9;
    }
    .no-data {
        text-align: center;
        font-size: 18px;
        margin-top: 20px;
    }
    .print-btn {
        background: #28a745;
    }
    .print-btn:hover {
        background: #218838;
    }
    @media print {
        .filter, .print-all, .print-single {
            display: none;
        }
    }
</style>
</head>
<body>

<h1>Kopi Bonet - Order Report</h1>

<div class="filter">
    <form method="get" action="">
        <input type="date" name="date" value="<?= htmlspecialchars($selectedDate) ?>">
        <button type="submit">Filter by Date</button>
        <a href="print_orders.php" style="text-decoration:none;">
            <button type="button" style="background:#6c757d;">Clear</button>
        </a>
    </form>
</div>

<?php if (mysqli_num_rows($result) > 0): ?>
<table>
    <thead>
        <tr>
            <th>Order / Table</th>
            <th>Customer</th>
            <th>Type</th>
            <th>Items</th>
            <th>Total (RM)</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $totalSales = 0;
    while ($row = mysqli_fetch_assoc($result)): 
        $orderDisplay = ($row['pickup_type'] === 'Dine-in' && !empty($row['table_number']))
            ? 'Table ' . htmlspecialchars($row['table_number'])
            : htmlspecialchars($row['order_number']);
        $totalSales += $row['total_price'];
    ?>
        <tr>
            <td><?= $orderDisplay ?></td>
            <td><?= htmlspecialchars($row['customer_name']) ?></td>
            <td><?= htmlspecialchars($row['pickup_type']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['order_items'])) ?></td>
            <td><?= number_format($row['total_price'], 2) ?></td>
            <td><?= htmlspecialchars($row['payment_method'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= htmlspecialchars(date("d M Y, h:i A", strtotime($row['created_at']))) ?></td>
            <td>
                <a href="print_single_order.php?id=<?= $row['id'] ?>" target="_blank">
                    <button type="button" class="print-btn">🖨️ Print</button>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align:right; font-weight:bold;">Total Sales:</td>
            <td colspan="4" style="font-weight:bold;">RM <?= number_format($totalSales, 2) ?></td>
        </tr>
    </tfoot>
</table>

<div style="text-align:center; margin-top:30px;">
    <button class="print-all" onclick="window.print()">🖨️ Print All Orders</button>
</div>

<?php else: ?>
    <p class="no-data">No orders found for <?= $selectedDate ? htmlspecialchars($selectedDate) : 'this period' ?>.</p>
<?php endif; ?>

</body>
</html>
