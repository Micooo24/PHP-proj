<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Tech Hire</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="..\css\index.css">  
    <link rel="stylesheet" href="..\css\about.css">  
    <link rel="stylesheet" href="..\css\clientpage.css">
</head>

<body>  
    <?php
    include('../includes/header.php');
   


    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include($_SERVER['DOCUMENT_ROOT'] . '/project-root/includes/connect.php');

    // Check if the user is logged in as a client
    if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "client") {
        // Fetch services data for clients from the database
        // Replace the following with your actual database query
    
        // Sample query to fetch services for the logged-in client
        $clientId = $_SESSION["user_id"];
        $sql = "SELECT * FROM services"; 
        //WHERE client_id = $clientId";
        $result = $conn->query($sql);
        if (isset($_SESSION["user_type"])) {
            // ... (previous code)
        
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
            // ... (remaining code)
            
            // Fetch and display jobs for the client in a table
            if ($client_id !== null) {
                $jobsSql = "SELECT * FROM jobs WHERE client_id = '$client_id'";
                $jobsResult = $conn->query($jobsSql);

                if ($jobsResult->num_rows > 0) {
                    echo "<div class='container'>";
                    echo "<div class='table-container'>";
                    echo "<h2>Your Created Jobs</h2>";
                    echo "<table border='1'>
                        <tr>
                            <th>Job ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Budget</th>
                            <th>Created At</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Show</th>
                            <th>Status</th>
                            <th>Files</th>
                        </tr>";

                    while ($rowJob = $jobsResult->fetch_assoc()) {
                        echo "<tr>
                                <td>{$rowJob['job_id']}</td>
                                <td>{$rowJob['title']}</td>
                                <td>{$rowJob['descriptions']}</td>
                                <td>{$rowJob['budget']}</td>
                                <td>{$rowJob['created_at']}</td>
                                <td><a href='../actions/editjob.php?job_id={$rowJob['job_id']}'>Edit</a></td>
                                <td><a href='../actions/deletejob.php?job_id={$rowJob['job_id']}'>Delete</a></td>
                                <td>";
                                if ($rowJob['status'] === 'completed') {
                                    echo "<a href='../actions/showtransaction.php?job_id={$rowJob['job_id']}'>Transactions</a>";
                                } else {
                                    echo "<a href='../actions/showbids.php?job_id={$rowJob['job_id']}'>Bids</a>";
                                }
                                
                                echo "</td>
                                <td>{$rowJob['status']}</td>
                                <td><a href='../actions/view_file.php?file_name={$rowJob['files']}'>View</a></td>
                            </tr>";
                    }

                    echo "</table>";
                    echo "</div>"; // Close the table-container
                } else {
                    // Display a message if no jobs found for the client
                    echo "<p>No jobs found for this client.</p>";
                }

                // Close the table-container
                echo "</div>";

                // Add a line break before the "Post Job" button
                echo "<br>";

            }

            // Display success or error messages
            if (isset($_GET['delete_success'])) {
                echo "<p>Job deleted successfully!</p>";
            } elseif (isset($_GET['delete_error'])) {
                echo "<p>Error deleting job: " . htmlspecialchars($_GET['delete_error']) . "</p>";
            }
        }
        
        if ($result->num_rows > 0) {
          
            echo '<div class="offer-container">';
            echo '  <p>Want to add offers?</p>';
            echo '  <button class="add-service-button" onclick="window.location.href=\'../actions/createjob.php\'">Post Job</button>';
            echo '  <div class="profile-container">';
            echo '    <p>Edit your profile here:</p>';
            echo '    <a href="../actions/updateclient.php" class="edit-profile-button">Update</a>';
            echo '  </div>';
            echo '</div>';
        } 

    } else {
        // Display a message if the user is not logged in as a client
        echo "<p class=\"access-denied\">Access denied please login as a client.</p>";
    }
    ?>
</body>
</html>
