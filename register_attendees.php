<?php
include 'connection.php';

// Collect POST values safely
$attendee_id = isset($_POST['attendee_id']) ? $_POST['attendee_id'] : '';
$booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone_no = isset($_POST['phone_no']) ? $_POST['phone_no'] : '';

// Insert into DB
$sql = "INSERT INTO attendees (attendee_id, booking_id, name, email, phone_no)
        VALUES ('$attendee_id', '$booking_id', '$name', '$email', '$phone_no')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('Enquiry Submitted Successfully'); window.location.href='create_attendees.html';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>