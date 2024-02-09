<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid on Job - Tech Hire</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href="../css/bid.css">
</head>
<body>

<?php
// Include your header and other necessary files
include('../includes/header.php');
include('../includes/connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if the user is logged in as a freelancer
if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "freelancer") {
    // Check if the job ID is provided in the query parameters
    if (isset($_GET['job_id']) && is_numeric($_GET['job_id'])) {
        // Retrieve job ID from the query parameters
        $jobId = $_GET['job_id'];

        // Display the bid form
        echo "<div class='form-container'>";
        echo "<h2>Bid on Job</h2>";

        // Display the form
        echo "<form action='../actions/submitbid.php' method='post' enctype='multipart/form-data'>";

        // Hidden input for job ID
        echo "<input type='hidden' name='job_id' value='$jobId'>";

        // Bid Amount textbox
        echo "<label for='bidAmount'>Bid Amount:</label>";
        echo "<input type='number' id='bidAmount' name='bidAmount' min='0' step='0.01' required><br>";

        // Proposal textbox
        echo "<label for='proposal'>Proposal:</label>";
        echo "<textarea id='proposal' name='proposal' rows='4' required></textarea><br>";

        // File upload input
        echo "<label for='fileUpload'>Attach File:</label>";
        echo "<input type='file' id='fileUpload' name='attachment'><br>";

        // Submit button
        echo "<input type='submit' value='Submit Bid'>";
        echo "</form>";

        echo "</div>"; // Close the form-container
    } else {
        echo "<p>Invalid job ID.</p>";
    }
} else {
    // Display a message if the user is not logged in as a freelancer
    echo "<p>Access denied. Please log in as a freelancer.</p>";
}
?>

</body>
</html>
