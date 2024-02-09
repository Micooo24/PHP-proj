<?php
// Include your necessary files
include('../includes/connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == "client" || $_SESSION["user_type"] == "admin")) {
    // Ensure job_id is set and not empty
    if (isset($_GET['job_id']) && !empty($_GET['job_id'])) {
        $job_id = $_GET['job_id'];

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Delete child rows first (adjust table and foreign key names accordingly)
            $sql_delete_child = "DELETE FROM bids WHERE job_id = '$job_id'";
            $conn->query($sql_delete_child);

            // Delete the parent row
            $sql_delete_parent = "DELETE FROM jobs WHERE job_id = '$job_id'";
            $conn->query($sql_delete_parent);

            // Commit the transaction
            $conn->commit();

            // Redirect to the clientpage.php with a success message
            header("Location: ../pages/clientpage.php");
            exit();
        } catch (Exception $e) {
            // Rollback the transaction on error
            $conn->rollback();

            // Redirect to the clientpage.php with an error message
            header("Location: ../pages/clientpage.php" . urlencode($e->getMessage()));
            exit();
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
