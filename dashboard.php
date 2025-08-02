<?php
include("connection.php");

$users = mysqli_query($conn, "SELECT * FROM user");
$venues = mysqli_query($conn, "SELECT * FROM venues");
$events = mysqli_query($conn, "SELECT * FROM events");
$categories = mysqli_query($conn, "SELECT * FROM categories");
$bookings = mysqli_query($conn, "SELECT * FROM bookings");
$payments = mysqli_query($conn, "SELECT * FROM payments");
$attendees = mysqli_query($conn, "SELECT * FROM attendees");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Event Management Dashboard</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 
</head>
<body class="bg-light">

<div class="container py-5">
  <h1 class="mb-4 text-center">Event Management Dashboard</h1>

  <!-- Reusable function -->
  <?php
  function renderTable($title, $result) {
    if (mysqli_num_rows($result) > 0) {
      echo "<h3 class='mt-5 mb-3'>$title</h3>";
      echo "<div class='table-responsive'>";
      echo "<table class='table table-bordered table-hover'>";
      echo "<thead class='table-dark'><tr>";
      foreach ($result->fetch_fields() as $field) {
        echo "<th>" . htmlspecialchars($field->name) . "</th>";
      }
      echo "<th>Actions</th></tr></thead><tbody>";

      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $col) {
          echo "<td>" . htmlspecialchars($col) . "</td>";
        }
        echo "<td>
                <a href='#' class='btn btn-sm btn-primary me-2'>Edit</a>
                <a href='#' class='btn btn-sm btn-danger'>Delete</a>
              </td>";
        echo "</tr>";
      }

      echo "</tbody></table></div>";
    } else {
      echo "<p class='text-muted'>No records found for $title.</p>";
    }
  }
  ?>

  <!-- Render all tables -->
  <?php
    renderTable("Users", $users);
    renderTable("Venues", $venues);
    renderTable("Events", $events);
    renderTable("Categories", $categories);
    renderTable("Bookings", $bookings);
    renderTable("Payments", $payments);
    renderTable("Attendees", $attendees);
  ?>

</div>

<!-- Bootstrap JS (optional if you use dropdowns, modals, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>