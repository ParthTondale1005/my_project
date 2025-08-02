<?php
include 'connection.php';

$venue_id    = isset($_POST['venue_id']) ? $_POST['venue_id'] : '';
$name       = isset($_POST['name']) ? $_POST['name'] : '';
$address      = isset($_POST['address']) ? $_POST['address'] : '';
$city   = isset($_POST['city']) ? $_POST['city'] : '';
$state   = isset($_POST['state']) ? $_POST['state'] : '';
$capacity       = isset($_POST['capacity']) ? $_POST['capacity'] : '';



// Insert into DB
$sql = "INSERT INTO venues ( venue_id, name, address, city, state, capacity)
        VALUES ('$venue_id', '$name', '$address', '$city', '$state', '$capacity')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('Enquiry Submitted Successfully'); window.location.href='create_venue.html';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

