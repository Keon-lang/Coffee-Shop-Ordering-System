<?php
include 'conn.php';
$id = $_GET['id'];
$status = $_GET['status'];
$conn->query("UPDATE orders SET status='$status' WHERE order_id=$id");
header("Location: kitchen_dashboard.php");
exit();
?>
