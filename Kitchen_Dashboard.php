<?php
include 'conn.php';
session_start();

// ------------------------------------------------------------
// ✅ 1. Handle order updates and deletions
// ------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['order_id'])) {
    $orderId = intval($_POST['order_id']);
    $action = $_POST['action'];

    if ($action === 'delete') {
        // Permanently delete the order
        $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
    } else {
        // Update order status (Pending / Completed / Cancelled)
        $status = ($action === 'complete') ? 'Completed' :
                  (($action === 'cancel') ? 'Cancelled' : 'Pending');

        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $orderId);
        $stmt->execute();
    }
}

// ------------------------------------------------------------
// ✅ 2. Handle search and filter functionality
// ------------------------------------------------------------
$selectedDate = $_GET['date'] ?? '';
$searchTerm   = trim($_GET['search'] ?? '');

$conditions = [];

// Filter by date
if (!empty($selectedDate)) {
    $conditions[] = "DATE(created_at) = '" . mysqli_real_escape_string($conn, $selectedDate) . "'";
}

// Filter by keywords (matches multiple columns)
if (!empty($searchTerm)) {
    $safeSearch = mysqli_real_escape_string($conn, $searchTerm);
    $conditions[] = "(
        order_number LIKE '%$safeSearch%' OR 
        customer_name LIKE '%$safeSearch%' OR 
        pickup_type LIKE '%$safeSearch%' OR 
        order_items LIKE '%$safeSearch%' OR 
        payment_method LIKE '%$safeSearch%'
    )";
}

// Combine WHERE clause
$whereSQL = '';
if (!empty($conditions)) {
    $whereSQL = 'WHERE ' . implode(' AND ', $conditions);
}

// ------------------------------------------------------------
// ✅ 3. Fetch all orders (Newest first)
// ------------------------------------------------------------
$sql = "SELECT * FROM orders $whereSQL ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kitchen Dashboard | Kopi Bonet</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 20px;
        text-align: center;
    }
    h1 {
        color: #007BFF;
        margin-bottom: 10px;
    }
    .filters {
        margin-bottom: 25px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    input[type="date"], input[type="text"] {
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 15px;
    }
    button.filter-btn {
        background: #007BFF;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
    }
    button.filter-btn:hover {
        background: #0056b3;
    }
    .table-container {
        overflow-x: auto;
        margin-top: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }
    th {
        background: #007BFF;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .btn {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }
    .done { background-color: #28a745; color: white; }
    .cancel { background-color: #dc3545; color: white; }
    .delete { background-color: #fd7e14; color: white; }
    .done:hover { background-color: #218838; }
    .cancel:hover { background-color: #c82333; }
    .delete:hover { background-color: #e36b00; }
    .print, .logout {
        background: #17a2b8;
        color: white;
        padding: 8px 15px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        margin-top: 20px;
        margin-right: 5px;
    }
    .logout { background: #6c757d; }
    .print:hover { background: #138496; }
    .logout:hover { background: #5a6268; }
    .reload-timer {
        color: #6c757d;
        font-size: 14px;
        margin-top: 10px;
    }
    @media (max-width: 768px) {
        table, thead, tbody, th, td, tr { display: block; }
        th { display: none; }
        tr {
            margin-bottom: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        td {
            text-align: right;
            padding: 10px 15px;
            position: relative;
        }
        td::before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            width: 50%;
            text-align: left;
            font-weight: bold;
            color: #007BFF;
        }
    }
</style>
</head>
<body>

<h1>Kitchen Dashboard — Kopi Bonet</h1>
<p>Monitor live orders, update their status, and track progress in real time.</p>

<div class="filters">
    <form method="get" action="">
        <input type="date" name="date" value="<?= htmlspecialchars($selectedDate) ?>">
        <input type="text" name="search" placeholder="Search Order / Name / Type" value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit" class="filter-btn">Search</button>
        <a href="kitchen_dashboard.php" class="logout">Clear</a>
    </form>
</div>

<div class="table-container">
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
                <th>Order Status</th>
                <th>Date & Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td data-label="Order #"><?= htmlspecialchars($row['order_number']) ?></td>
                <td data-label="Customer"><?= htmlspecialchars($row['customer_name']) ?></td>
                <td data-label="Type"><?= htmlspecialchars($row['pickup_type']) ?></td>
                <td data-label="Items"><?= nl2br(htmlspecialchars($row['order_items'])) ?></td>
                <td data-label="Total"><?= number_format($row['total_price'], 2) ?></td>
                <td data-label="Payment Method"><?= htmlspecialchars($row['payment_method'] ?? '-') ?></td>
                <td data-label="Order Status"><?= htmlspecialchars($row['status']) ?></td>
                <td data-label="Date"><?= htmlspecialchars(date("d M Y, h:i A", strtotime($row['created_at']))) ?></td>
                <td data-label="Actions">
                    <form method="post" style="display:inline;" onsubmit="return confirm('Confirm this action?');">
                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                        <?php if ($row['status'] === 'Pending'): ?>
                            <button class="btn done" type="submit" name="action" value="complete">Done</button>
                            <button class="btn cancel" type="submit" name="action" value="cancel">Cancel</button>
                            <button class="btn delete" type="submit" name="action" value="delete">Delete</button>
                        <?php elseif ($row['status'] === 'Cancelled'): ?>
                            <span class="btn cancel">Cancelled</span>
                            <button class="btn delete" type="submit" name="action" value="delete">Delete</button>
                        <?php else: ?>
                            <span class="btn done">Completed</span>
                            <button class="btn delete" type="submit" name="action" value="delete">Delete</button>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No orders found <?= ($selectedDate || $searchTerm) ? 'for the selected filters.' : 'today.' ?></p>
<?php endif; ?>
</div>

<a href="print_orders.php" class="print" target="_blank">🖨️ Print Orders</a>
<a href="kitchen_logout.php" class="logout">Logout</a>

<div class="reload-timer">
    Auto-refreshing in <span id="timer">30</span> seconds...
</div>

<script>
let timeLeft = 30;
const timer = document.getElementById("timer");
const countdown = setInterval(() => {
    timeLeft--;
    timer.textContent = timeLeft;
    if (timeLeft <= 0) {
        clearInterval(countdown);
        location.reload();
    }
}, 1000);
</script>

</body>
</html>
