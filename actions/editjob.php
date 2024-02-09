<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link rel="stylesheet" href="../css/editjob.css">
</head>
<body>

<?php
// Include your header and other necessary files
include('../includes/header.php');
include('../includes/connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "client") {
    // Ensure job_id is set and not empty
    if (isset($_GET['job_id']) && !empty($_GET['job_id'])) {
        $job_id = $_GET['job_id'];

        // Fetch the job data based on the job_id
        $sqlJob = "SELECT * FROM jobs WHERE job_id = '$job_id'";
        $resultJob = $conn->query($sqlJob);

        if ($resultJob->num_rows > 0) {
            $rowJob = $resultJob->fetch_assoc();

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Retrieve form data
                $job_id = $_POST['job_id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $budget = $_POST['budget'];

                // Update data in the "jobs" table
                $sql = "UPDATE jobs 
                        SET title = '$title', descriptions = '$description', budget = '$budget'
                        WHERE job_id = '$job_id'";

                if ($conn->query($sql) === TRUE) {
                    // Redirect to the createjob.php with a success message
                    header("Location: ../actions/createjob.php");
                    exit();
                } else {
                    // Redirect to the createjob.php with an error message
                    header("Location: ../actions/createjob.php?error=" . urlencode($conn->error));
                    exit();
                }
            }

            // Display the edit job form
            echo "<div class='form-container'>";
            echo "<h2>Edit Job</h2>";

            // Display the form
            echo "<form action='' method='post'>";

            // Hidden input for job_id
            echo "<input type='hidden' name='job_id' value='{$rowJob['job_id']}'>";

            // Title textbox
            echo "<label for='title'>Title:</label>";
            echo "<input type='text' id='title' name='title' value='{$rowJob['title']}' required><br>";

            // Description textbox
            echo "<label for='description'>Description:</label>";
            echo "<textarea id='description' name='description' rows='4' required>{$rowJob['descriptions']}</textarea><br>";

            // Budget textbox
            echo "<label for='budget'>Budget:</label>";
            echo "<input type='number' id='budget' name='budget' min='0' step='100' value='{$rowJob['budget']}' required><br>";

            // Submit button
            echo "<input type='submit' value='Save Changes'>";
            echo "</form>";

            echo "</div>"; // Close the form-container
        } else {
            echo "<p>Job not found.</p>";
        }
    } else {
        echo "<p>Invalid request. Job ID not provided.</p>";
    }
}  elseif (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "admin") {
    // Ensure job_id is set and not empty
    if (isset($_GET['job_id']) && !empty($_GET['job_id'])) {
        $job_id = $_GET['job_id'];

        // Fetch the job data based on the job_id
        $sqlJob = "SELECT * FROM jobs WHERE job_id = '$job_id'";
        $resultJob = $conn->query($sqlJob);

        if ($resultJob->num_rows > 0) {
            $rowJob = $resultJob->fetch_assoc();

            // Display the edit job form for admin users
            echo "<div class='form-container'>";
            echo "<h2>Edit Job</h2>";

            // Display the form
            echo "<form action='' method='post'>";

            // Hidden input for job_id
            echo "<input type='hidden' name='job_id' value='{$rowJob['job_id']}'>";

            // Title textbox
            echo "<label for='title'>Title:</label>";
            echo "<input type='text' id='title' name='title' value='{$rowJob['title']}' required><br>";

            // Description textbox
            echo "<label for='description'>Description:</label>";
            echo "<textarea id='description' name='description' rows='4' required>{$rowJob['descriptions']}</textarea><br>";

            // Budget textbox
            echo "<label for='budget'>Budget:</label>";
            echo "<input type='number' id='budget' name='budget' min='0' step='100' value='{$rowJob['budget']}' required><br>";

            // Submit button
            echo "<input type='submit' value='Save Changes'>";
            echo "</form>";

            echo "</div>"; // Close the form-container
        } else {
            echo "<p>Job not found.</p>";
        }
    } else {
        echo "<p>Invalid request. Job ID not provided.</p>";
    }
} else {
    // Display a message if the user is not logged in
    echo "<p>Access denied. Please log in.</p>";
}
?>

<!-- Include your footer and other necessary files if needed -->

</body>
</html>
