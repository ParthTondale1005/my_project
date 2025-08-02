<?php
include 'connection.php';

$user_id    = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$name       = isset($_POST['name']) ? $_POST['name'] : '';
$email      = isset($_POST['email']) ? $_POST['email'] : '';
$password   = isset($_POST['password']) ? $_POST['password'] : '';
$phone_no   = isset($_POST['phone_no']) ? $_POST['phone_no'] : '';
$role       = isset($_POST['role']) ? $_POST['role'] : '';
$created_at = isset($_POST['created_at']) ? $_POST['created_at'] : date('Y-m-d H:i:s');



// Insert into DB
$sql = "INSERT INTO user ( user_id, name, email, password, phone_no, role, created_at)
        VALUES ('$user_id', '$name', '$email', '$password', '$phone_no', '$role', '$created_at')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('Enquiry Submitted Successfully'); window.location.href='create_user.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    
    <!-- DataTables CSS & JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Stylish Button CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        input[type=text], input[type=email] {
            padding: 8px;
            width: 300px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            margin: 2px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-edit {
            background-color: #2196F3;
            color: white;
        }

        .btn-edit:hover {
            background-color: #0b7dda;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c62828;
        }

        .btn-update {
            background-color: #4CAF50;
            color: white;
        }

        .btn-update:hover {
            background-color: #45a049;
        }

        form {
            margin-bottom: 20px;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#userTable').DataTable();
        });
    </script>
</head>
<body>

<?php
require("connection.php");

// ✅ Delete user
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM user WHERE user_id = '$delete_id'");
    header("Location: created_user.php");
    exit();
}

// ✅ Update user
if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    mysqli_query($conn, "UPDATE user SET name='$name', email='$email' WHERE user_id='$user_id'");
    header("Location: create_user.php");
    exit();
}

// ✅ Get user for editing
$edit_user = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$edit_id'");
    $edit_user = mysqli_fetch_assoc($result);
}
?>

<h2>User Management</h2>

<?php if ($edit_user): ?>
<h3>Edit User: <?php echo $edit_user['user_id']; ?></h3>
<form method="POST">
    <input type="hidden" name="user_id" value="<?php echo $edit_user['user_id']; ?>">
    Name:<br>
    <input type="text" name="name" value="<?php echo $edit_user['name']; ?>"><br>
    Email:<br>
    <input type="email" name="email" value="<?php echo $edit_user['email']; ?>"><br><br>
    <input type="submit" name="update" value="Update User" class="btn btn-update">
</form>
<?php endif; ?>

<!-- ✅ User Table -->
<table id="userTable" class="display">
    <thead>
        <tr>
            <th>user_id</th>
            <th>name</th>
            <th>email</th>
            <th>password</th>
            <th>phone_no</th>
            <th>role</th>
            <th>created_at</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT user_id, name, email, password, phone_no, role, created_at FROM user";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['user_id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['password']}</td>";
        echo "<td>{$row['phone_no']}</td>";
        echo "<td>{$row['role']}</td>";
        echo "<td>{$row['created_at']}</td>";
        echo "<td>
                <a class='btn btn-edit' href='?edit={$row['user_id']}'>Edit</a>
                <a class='btn btn-delete' href='?delete={$row['user_id']}' onclick=\"return confirm('Are you sure you want to delete this user?')\">Delete</a>
              </td>";
        echo "</tr>";
    }
    mysqli_close($conn);
    ?>
    </tbody>
</table>

</body>
</html>