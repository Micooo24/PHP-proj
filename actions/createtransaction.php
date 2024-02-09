<?php
// Include necessary files
include('../includes/connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "client") {
    // Check if all required GET data is present
    if (isset($_GET['bid_id']) && isset($_GET['job_id'])) {
        $bid_id = $_GET['bid_id'];
        $job_id = $_GET['job_id'];

        // Get the current date and time
        $transaction_date = date('Y-m-d H:i:s');

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Update the selected bid status to 'approved'
            $updateSelectedBid = "UPDATE bids SET status = 'approved' WHERE bid_id = '$bid_id'";
            if (!$conn->query($updateSelectedBid)) {
                throw new Exception("Error updating bid status: " . $conn->error);
            }

            // Update the other bids for the same job to 'rejected'
            $updateRejectedBids = "UPDATE bids SET status = 'rejected' WHERE job_id = '$job_id' AND bid_id != '$bid_id'";
            if (!$conn->query($updateRejectedBids)) {
                throw new Exception("Error updating other bid statuses: " . $conn->error);
            }

            // Fetch bid details to compute amount
            $sqlBid = "SELECT bid_amount FROM bids WHERE bid_id = '$bid_id'";
            $resultBid = $conn->query($sqlBid);

            if ($resultBid->num_rows > 0) {
                $rowBid = $resultBid->fetch_assoc();
                $bid_amount = $rowBid['bid_amount'];

                // Calculate total amount (bid amount + service fee)
                $total_amount = $bid_amount + 100;

                // Insert transaction into the transactions table
                $insertTransaction = "INSERT INTO transactions (bid_id, job_id, full_amount, status, transaction_date) 
                                        VALUES ('$bid_id', '$job_id', '$total_amount', 'completed', '$transaction_date')";

                if (!$conn->query($insertTransaction)) {
                    throw new Exception("Error creating transaction: " . $conn->error);
                }

                // Update job status to 'completed'
                $updateJobStatus = "UPDATE jobs SET status = 'completed' WHERE job_id = '$job_id'";
                if (!$conn->query($updateJobStatus)) {
                    throw new Exception("Error updating job status: " . $conn->error);
                }

                // Commit the transaction
                $conn->commit();
                header("Location: ../pages/clientpage.php");
            } else {
                throw new Exception("Bid details not found.");
            }
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            $conn->rollback();
            echo "Transaction failed: " . $e->getMessage();
        }
    } else {
        echo "Incomplete data provided.";
    }
} else {
    echo "You are not logged in as a client.";
}
?>
