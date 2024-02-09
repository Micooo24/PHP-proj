<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href="../css/showbids.css">
</head>
<body>

<?php
// Include necessary files
include('../includes/connect.php');
include('../includes/header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (isset($_SESSION["user_type"])) {
    // Ensure job_id is set and not empty
    if (isset($_GET['job_id']) && !empty($_GET['job_id'])) {
        $job_id = $_GET['job_id'];

        // Fetch bids for the specific job from the bids table
        $sqlBids = "SELECT * FROM bids WHERE job_id = '$job_id'";
        $resultBids = $conn->query($sqlBids);
        echo "<h1 class='job-heading'>Bids for Job #$job_id</h1>";

        if ($resultBids->num_rows > 0) {
            // Display bids table
            echo "<table id='bidsTable'>";
            echo "<tr>
                      <th>Bidder</th>
                      <th>Bid Amount</th>
                      <th>Proposal</th>
                      <th>Files</th>
                      <th>Bid Time</th>
                      <th>Select Bidder</th>
                  </tr>";

            while ($rowBid = $resultBids->fetch_assoc()) {
                echo "<tr>
                          <td>{$rowBid['freelancer_id']}</td>
                          <td>{$rowBid['bid_amount']}</td>
                          <td>{$rowBid['proposal']}</td>
                          <td>";
                    if (!empty($rowBid['files'])) {
                        echo "<a href='view_file.php?file_name={$rowBid['files']}'>View File</a>";
                    } else {
                        echo "No file uploaded";
                    }
                    echo "</td>
                          <td>{$rowBid['created_at']}</td>
                          <td><a href='javascript:void(0);' onclick='confirmSelection({$rowBid['bid_id']}, {$job_id})'>Select Bidder</a></td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No bids found for this job.</p>";
        }
    } else {
        echo "<p>Invalid request. Job ID not provided.</p>";
    }
} else {
    // Display a message if the user is not logged in
    echo "<p class=\"access-denied\">Access Denied Please log in.</p>";
}
?>

<script>
function confirmSelection(bidId, jobId) {
    if (confirm("Are you sure you want to select this bidder for the job?")) {
        // If confirmed, redirect to createtransaction.php with the bid and job IDs
        window.location.href = `createtransaction.php?bid_id=${bidId}&job_id=${jobId}`;
    }
}
</script>

</body>
</html>
