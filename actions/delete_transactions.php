<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Transaction</title>
    <!-- Include your CSS files as needed -->
</head>
<body>
    <?php
    // Check if a transaction ID is received
    if (isset($_POST['transaction_id'])) {
        include('../includes/connect.php');

        // Sanitize the received ID
        $transaction_id = mysqli_real_escape_string($conn, $_POST['transaction_id']);

        // Fetch transaction details based on the ID
        $sql = "SELECT * FROM transactions WHERE transaction_id = '$transaction_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display confirmation message and form
            ?>
            <h1>Delete Transaction Confirmation</h1>
            <p>Are you sure you want to delete this transaction?</p>
            <form action="" method="post">
                <input type="hidden" name="transaction_id" value="<?php echo $row['transaction_id']; ?>">
                <input type="submit" name="confirm_delete" value="Confirm Delete">
            </form>
            <?php
            // Process the deletion when the confirmation is submitted
            if (isset($_POST['confirm_delete'])) {
                // Delete statement
                $delete_sql = "DELETE FROM transactions WHERE transaction_id='$transaction_id'";

                if ($conn->query($delete_sql) === TRUE) {
                    // Redirect to readtransactions.php after successful deletion
                    header("Location: readtransactions.php");
                    exit();
                } else {
                    echo "Error deleting transaction: " . $conn->error;
                }
            }
        } else {
            echo "Transaction not found.";
        }

        $conn->close();
    } else {
        echo "No transaction ID received.";
    }
    ?>
</body>
</html>
