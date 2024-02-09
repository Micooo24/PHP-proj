<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service - Tech Hire</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/createservice.css">

    <!-- Include your other CSS files as needed -->
</head>
<body>

<?php
// Include your header and other necessary files
include('../includes/header.php');
include('../includes/connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in as a freelancer or admin
if (isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == "freelancer" || $_SESSION["user_type"] == "admin")) {
    // Ensure service_id is set and not empty
    if (isset($_GET['service_id']) && !empty($_GET['service_id'])) {
        $service_id = $_GET['service_id'];

        // Fetch the service data based on the service_id
        $sqlService = "SELECT * FROM services WHERE service_id = '$service_id'";
        $resultService = $conn->query($sqlService);

        if ($resultService->num_rows > 0) {
            $rowService = $resultService->fetch_assoc();

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Retrieve form data
                $service_id = $_POST['service_id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $deliveryTime = $_POST['initialDays'];

                // Update data in the "services" table
                $sql = "UPDATE services 
                        SET title = '$title', descriptions = '$description', price = '$price', delivery_time = '$deliveryTime'
                        WHERE service_id = '$service_id'";

                if ($conn->query($sql) === TRUE) {
                    // Redirect to the createservice.php with a success message
                    header("Location: ../actions/createservice.php?service_id={$service_id}");
                    exit();
                } else {
                    // Redirect to the createservice.php with an error message
                    header("Location: ../actions/createservice.php?error=" . urlencode($conn->error));
                    exit();
                }
            }

            // Display the edit service form
            echo "<div class='form-container'>";
            echo "<h2>Edit Service</h2>";

            // Display the form
            echo "<form action='' method='post'>";
            
            // Hidden input for service_id
            echo "<input type='hidden' name='service_id' value='{$rowService['service_id']}'>";

            // Title textbox
            echo "<label for='title'>Title:</label>";
            echo "<input type='text' id='title' name='title' value='{$rowService['title']}' required><br>";
            
            // Description textbox
            echo "<label for='description'>Description:</label>";
            echo "<textarea id='description' name='description' rows='4' required>{$rowService['descriptions']}</textarea><br>";

            // Price textbox
            echo "<label for='price'>Price:</label>";
            echo "<input type='number' id='price' name='price' min='0' step='100' value='{$rowService['price']}' required><br>";

            // Initial Delivery Days dropdown
            echo "<label for='initialDays'>Initial Delivery Days:</label>";
            echo "<select id='initialDays' name='initialDays' required>";
            for ($i = 1; $i <= 100; $i++) {
                $selected = ($i == $rowService['delivery_time']) ? 'selected' : '';
                echo "<option value='{$i}' {$selected}>{$i}</option>";
            }
            echo "</select><br>";

            // Submit button
            echo "<input type='submit' value='Save Changes'>";
            echo "</form>";

            echo "</div>"; // Close the form-container
        } else {
            echo "<p>Service not found.</p>";
        }
    } else {
        echo "<p>Invalid request. Service ID not provided.</p>";
    }
} else {
    // Display a message if the user is not logged in as a freelancer or admin
    echo "<p>Access denied. Please log in as a freelancer or admin.</p>";
}
?>

</body>
</html>