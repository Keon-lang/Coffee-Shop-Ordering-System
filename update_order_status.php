<?php
include 'conn.php';
if (isset($_POST['order_id'], $_POST['status'])) {
    $id = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $sql = "UPDATE orders SET status='$status' WHERE id=$id";
    mysqli_query($conn, $sql);
}
header("Location: kitchen_dashboard.php");
exit;
?>

