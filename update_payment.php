<?php
include 'conn.php';

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$method   = isset($_GET['method']) ? mysqli_real_escape_string($conn, $_GET['method']) : '';

if ($order_id <= 0 || empty($method)) {
    die("❌ Invalid payment request.");
}

$updateSql = "UPDATE orders SET status='Paid (Simulation)', payment_method='$method' WHERE id=$order_id";
if (mysqli_query($conn, $updateSql)) {
    header("Location: payment_success.php?order_id=$order_id");
    exit;
} else {
    die("❌ Failed to update payment: " . mysqli_error($conn));
}
?>



