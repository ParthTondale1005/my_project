<?php
include 'connection.php';

$booking_id    = isset($_POST['booking_id']) ? $_POST['booking_id'] : '';
$event_id       = isset($_POST['event_id']) ? $_POST['event_id'] : '';
$user_id      = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$tickets   = isset($_POST['tickets']) ? $_POST['tickets'] : '';
$status   = isset($_POST['status']) ? $_POST['status'] : '';


// Insert into DB
$sql = "INSERT INTO bookings ( booking_id, event_id, user_id, tickets, status)
        VALUES ('$booking_id', '$event_id', '$user_id', '$tickets', '$status')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('Enquiry Submitted Successfully'); window.location.href='create_booking.html';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
