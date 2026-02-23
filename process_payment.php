<?php
include 'conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';

    if (empty($payment_method)) {
        echo "<script>alert('Please select a payment method.'); window.history.back();</script>";
        exit;
    }

    // ✅ Update payment method in the database
    $sql = "UPDATE orders SET payment_method = '$payment_method' WHERE id = '$order_id'";
    if (mysqli_query($conn, $sql)) {
        if ($payment_method === 'Pay at Counter') {
            header("Location: pay_at_counter.php?order_id=$order_id");
        } else {
            header("Location: payment_form.php?order_id=$order_id");
        }
        exit;
    } else {
        echo "❌ Error updating payment method: " . mysqli_error($conn);
    }
}
?>
