<?php
include 'connection.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
$event_id    = isset($_POST['event_id']) ? $_POST['event_id'] : '';
$organizer_id    = isset($_POST['organizer_id']) ? $_POST['organizer_id'] : '';
$title      = isset($_POST['title']) ? $_POST['title'] : '';
$description  = isset($_POST['description']) ? $_POST['description'] : '';
$Category   = isset($_POST['category']) ? $_POST['Category'] : '';
$date       = isset($_POST['date(format)']) ? $_POST['date(format)'] : '';
$start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '';
$end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '';
$venue_id = isset($_POST['venue_id']) ? $_POST['venue_id'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';


// Insert into DB
$sql = "INSERT INTO events (event_id, organizer_id, title, description, category, date, start_time, end_time, venue_id, status) 
        VALUES ('$event_id', '$organizer_id', '$title', '$description', '$category', '$date', '$start_time', '$end_time', '$venue_id', '$status')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('Enquiry Submitted Successfully'); window.location.href='create_event.html';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Management</title>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 100%; margin-top: 20px; }
        input[type=text], input[type=date], input[type=time], textarea {
            padding: 5px;
            width: 300px;
            margin-bottom: 10px;
        }
        input[type=submit] {
            padding: 6px 15px;
        }
        .btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 5px;
        }
        .btn-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>

<h1>Event details</h1>

<?php
require('connection.php');


if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM events WHERE event_id = '$delete_id'");
    header("Location: event_manage.php");
    exit();
}


if (isset($_POST['update'])) {
    $event_id   = $_POST['event_id'];
    $title      = $_POST['title'];
    $description= $_POST['description'];
    $category   = $_POST['category'];
    $date       = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time   = $_POST['end_time'];
    $venue_id   = $_POST['venue_id'];
    $status     = $_POST['status'];

    mysqli_query($conn, "UPDATE events SET 
        title='$title', 
        description='$description', 
        category='$category', 
        date='$date', 
        start_time='$start_time', 
        end_time='$end_time', 
        venue_id='$venue_id',
        status='$status'
        WHERE event_id='$event_id'");

    header("Location: event_manage.php");
    exit();
}


$edit_event = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM events WHERE event_id = '$edit_id'");
    $edit_event = mysqli_fetch_assoc($result);
}
?>

<?php if ($edit_event): ?>

<h3>Edit Event: <?php echo $edit_event['event_id']; ?></h3>
<form method="POST">
    <input type="hidden" name="event_id" value="<?php echo $edit_event['event_id']; ?>">
    Title:<br>
    <input type="text" name="title" value="<?php echo $edit_event['title']; ?>"><br>
    Description:<br>
    <textarea name="description"><?php echo $edit_event['description']; ?></textarea><br>
    Category:<br>
    <input type="text" name="category" value="<?php echo $edit_event['category']; ?>"><br>
    Date:<br>
    <input type="date" name="date" value="<?php echo $edit_event['date']; ?>"><br>
    Start Time:<br>
    <input type="time" name="start_time" value="<?php echo $edit_event['start_time']; ?>"><br>
    End Time:<br>
    <input type="time" name="end_time" value="<?php echo $edit_event['end_time']; ?>"><br>
    Venue ID:<br>
    <input type="text" name="venue_id" value="<?php echo $edit_event['venue_id']; ?>"><br>
    Status:<br>
    <input type="text" name="status" value="<?php echo $edit_event['status']; ?>"><br>
    <input type="submit" name="update" value="Update Event">
</form>
<hr>
<?php endif; ?>


<table id="userTable" class="display">
    <thead>
        <tr>
            <th>event_id</th>
            <th>organizer_id</th>
            <th>title</th>
            <th>description</th>
            <th>category</th>
            <th>date</th>
            <th>start_time</th>
            <th>end_time</th>
            <th>venue_id</th>
            <th>status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT event_id, organizer_id, title, description, category, date, start_time, end_time, venue_id, status FROM events";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['event_id']}</td>
                <td>{$row['organizer_id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['description']}</td>
                <td>{$row['category']}</td>
                <td>{$row['date']}</td>
                <td>{$row['start_time']}</td>
                <td>{$row['end_time']}</td>
                <td>{$row['venue_id']}</td>
                <td>{$row['status']}</td>
                <td>
                    <a class='btn' href='?edit={$row['event_id']}'>Edit</a>
                    <a class='btn btn-danger' href='?delete={$row['event_id']}' onclick=\"return confirm('Are you sure you want to delete this event?');\">Delete</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No events found</td></tr>";
    }

    mysqli_close($conn);
    ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
</script>

</body>
</html>
