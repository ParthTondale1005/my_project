<?php
include 'connection.php';

// Collect POST values safely
$payment_id = isset($_POST['payment_id']) ? $_POST['payment_id'] : '';
$booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : '';
$amount = isset($_POST['amount']) ? $_POST['amount'] : '';
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
$payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : '';
$payment_date = isset($_POST['payment_date']) ? $_POST['payment_date'] : '';

// Insert into DB
$sql = "INSERT INTO payments (payment_id, booking_id, amount, payment_method, payment_status, payment_date)
        VALUES ('$payment_id', '$booking_id', '$amount', '$payment_method', '$payment_status', '$payment_date')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('Enquiry Submitted Successfully'); window.location.href='create_booking.html';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>