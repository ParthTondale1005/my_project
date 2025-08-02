<!-- File: enquiry_insert.php -->
<?php
include 'connection.php';

$category_id = $_POST['category_id'];
$name = $_POST['name'];
$description = $_POST['description'];

// Insert into DB
$sql = "INSERT INTO categories (category_id, name, description)
        VALUES ('$category_id', '$name', '$description')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('Enquiry Submitted Successfully'); window.location.href='create_category.html';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<?php
include 'connection.php';

$sql = "SELECT * FROM categories";
$result = mysqli_query($conn, $sql);
?>

