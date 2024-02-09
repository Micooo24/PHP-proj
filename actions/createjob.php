<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Job - Tech Hire</title>
    <link rel="stylesheet" href="../css/createjob.css">
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

// Check if the user is logged in
if (isset($_SESSION["user_type"])&& $_SESSION["user_type"] == "client") {
    // Initialize $client_id
    $client_id = null;

    // Fetch the client_id based on the logged-in user's user_id
    $user_id = $_SESSION["user_id"];
    $clientSql = "SELECT client_id FROM clients WHERE user_id = '$user_id'";
    $clientResult = $conn->query($clientSql);

    if ($clientResult->num_rows > 0) {
        $clientRow = $clientResult->fetch_assoc();
        $client_id = $clientRow['client_id'];
    } else {
        echo "Client not found for the logged-in user.";
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $client_id !== null) {
        // Retrieve form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $budget = $_POST['budget'];

        // Get the current date and time
        $created_at = date('Y-m-d H:i:s');

        // File handling
        $file_name = $_FILES['attached_file']['name']; // Get the name of the file
        $file_temp = $_FILES['attached_file']['tmp_name']; // Get the temporary location of the file

        // Set the destination path for the file
        $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . '/project-root/uploads/';
        $destination = $uploads_dir . $file_name;

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($file_temp, $destination)) {
            // Insert data into the "jobs" table with the file name
            $jobSql = "INSERT INTO jobs (client_id, title, descriptions, budget, created_at, files) 
                        VALUES ('$client_id', '$title', '$description', '$budget', '$created_at', '$file_name')";

            if ($conn->query($jobSql) === TRUE) {
                // Redirect to a success page or perform other actions
                echo "<p class=\"access-denied\">Job created successfully.</p>";
            } else {
                // Display an error message
                echo "Error: " . $conn->error;
            }
        } else {
            echo "File upload failed.";
        }
    }

    // Fetch and display jobs for the client in a table
    if ($client_id !== null) {
        // ... (existing code)

        echo "<div class='form-container'>";
        echo "<h2>Create New Job</h2>";

        // Display the form including file input
        echo "<form action='' method='post' enctype='multipart/form-data'>
                <label for='title'>Job Title:</label>
                <input type='text' id='title' name='title' required><br>
                <label for='description'>Job Description:</label>
                <textarea id='description' name='description' rows='4' required></textarea><br>
                <label for='budget'>Budget:</label>
                <input type='number' id='budget' name='budget' min='0' step='100' required><br>
                <label for='attached_file'>Attach File:</label>
                <input type='file' id='attached_file' name='attached_file'><br>
                <input type='submit' value='Submit'>
              </form>";
        echo "</div>"; // Close the form-container
    }
} elseif (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "admin") {
    // Display jobs table for admin users
    echo "<div class='table-container'>";
    echo "<h2>Jobs Table</h2>";

    // Fetch and display jobs from the table for admins
    //Read from the jobs table
    $sqlJobs = "SELECT * FROM jobs";
    $resultJobs = $conn->query($sqlJobs);

    if ($resultJobs && $resultJobs->num_rows > 0) {
        // Display jobs table
        echo "<table id='jobsTable' style='color: black;'>";
        echo "<tr>
                  <th>Job ID</th>
                  <th>Client ID</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Budget</th>
                  <th>Status</th>
                  <th>Files</th>
                  <th>Created At</th>
                  <th>Edit</th>
                  <th>Delete</th>
                  <!-- Add more columns if needed -->
              </tr>";

        while ($rowJob = $resultJobs->fetch_assoc()) {
            echo "<tr> 
                      <td>{$rowJob['job_id']}</td>
                      <td>{$rowJob['client_id']}</td>
                      <td>{$rowJob['title']}</td>
                      <td>{$rowJob['descriptions']}</td>
                      <td>{$rowJob['budget']}</td>
                      <td>{$rowJob['status']}</td>
                      <td><a href='../actions/view_file.php?file_name={$rowJob['files']}'>View File</a></td>
                      <td>{$rowJob['created_at']}</td>
                      <td><form action='editjob.php' method='get'>
                            <input type='hidden' name='job_id' value='{$rowJob['job_id']}'>
                            <input type='submit' value='Edit'>
                          </form></td>
                      <td><form action='deletejob.php' method='get'>
                            <input type='hidden' name='job_id' value='{$rowJob['job_id']}'>
                            <input type='submit' value='Delete'>
                          </form></td>
                      <!-- Add more cells for additional columns -->
                  </tr>";
        }

        echo "</table>";
    } else {
        // Display a message if no jobs found
        echo "<p>No jobs found.</p>";
    }
} else {
    // Display a message if the user is not logged in
    echo "<p class=\"access-denied\">Access Denied Please Login.</p>";
}
?>
</body>
</html>
