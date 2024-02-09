<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid History</title>
    <link rel='stylesheet' href="../css/bidhistory.css">
</head>

<body>
    <?php
    // Include necessary files
    include('../includes/connect.php');
    include('../includes/header.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in as a freelancer
    if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "freelancer") {
        // Fetch the freelancer ID from the freelancers table
        $user_id = $_SESSION["user_id"];
        $sqlFreelancer = "SELECT freelancer_id FROM freelancers WHERE user_id = '$user_id'";
        $resultFreelancer = $conn->query($sqlFreelancer);

        if ($resultFreelancer->num_rows > 0) {
            $rowFreelancer = $resultFreelancer->fetch_assoc();
            $freelancerId = $rowFreelancer['freelancer_id'];

            // Fetch bids made by the freelancer from the bids table
            $sqlBids = "SELECT * FROM bids WHERE freelancer_id = '$freelancerId'";
            $resultBids = $conn->query($sqlBids);

            echo "<h2>Bid History</h2>";

            if ($resultBids->num_rows > 0) {
                // Display bid history table
                echo "<table id='bidHistoryTable'>";
                echo "<tr>
                        <th>Job Title</th>
                        <th>Bid Amount</th>
                        <th>Proposal</th>
                        <th>Bid Time</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>";

                while ($rowBid = $resultBids->fetch_assoc()) {
                    $job_id = $rowBid['job_id'];

                    // Fetch job details for each bid
                    $sqlJob = "SELECT title FROM jobs WHERE job_id = '$job_id'";
                    $resultJob = $conn->query($sqlJob);

                    if ($resultJob->num_rows > 0) {
                        $rowJob = $resultJob->fetch_assoc();

                        echo "<tr>
                                <td>{$rowJob['title']}</td>
                                <td>{$rowBid['bid_amount']}</td>
                                <td>{$rowBid['proposal']}</td>
                                <td>{$rowBid['created_at']}</td>
                                <td>{$rowBid['status']}</td> <!-- Adjust this to your actual status column -->
                                <td><a href='../actions/editbid.php?bid_id={$rowBid['bid_id']}' class='edit-button'>Edit</a></td>
                                <td><a href='../actions/deletebid.php?bid_id={$rowBid['bid_id']}' class='delete-button'>Delete</a></td>
                              </tr>";
                    } else {
                        echo "<tr><td colspan='7'>Job details not found</td></tr>";
                    }
                }

                echo "</table>";
            } else {
                echo "<p>No bid history found for this freelancer.</p>";
            }
        } else {
            echo "Freelancer not found.";
        }
    } else {
        // Display a message if the user is not logged in as a freelancer
        echo "<p class=\"access-denied\">You are not logged in as a freelancer. Log in to access this feature.</p>";
    }
    ?>

</body>

</html>
