<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/services.css">
</head>
<body>
<?php
// Include your necessary files
include('../includes/connect.php');
include('../includes/header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
    // Fetch all services from the database
    $sqlServices = "SELECT * FROM services";
    $resultServices = $conn->query($sqlServices);

    if ($resultServices->num_rows > 0) {
        // Display services table
        echo "<h2>All Services</h2>";

        // Display services in a table
        echo "<table id='servicesTable'>";
        echo "<tr>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Delivery Time</th>
                  <th>Created At</th>
              </tr>";

        while ($rowService = $resultServices->fetch_assoc()) {
            echo "<tr>
                      <td>{$rowService['title']}</td>
                      <td>{$rowService['descriptions']}</td>
                      <td>{$rowService['price']}</td>
                      <td>{$rowService['delivery_time']}</td>
                      <td>{$rowService['created_at']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        // Display a message if no services found
        echo "<p>No services found.</p>";
    }
} else {
      // Display a styled message if the user is not logged in
      echo "<p class=\"access-denied\">You are not logged in. Log in to access more features.</p>";
}


?>
</body>
</html>