<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet'href="../css/edittransactions.css">
</head>
<body>
<?php
// Check if a transaction ID is received
if (isset($_POST['transaction_id'])) {
    include('../includes/connect.php');
    include('../includes/header.php');
    // Sanitize the received ID
    $transaction_id = mysqli_real_escape_string($conn, $_POST['transaction_id']);

    // Process the update when the form is submitted
    if (isset($_POST['update_transaction'])) {
        $bid_id = mysqli_real_escape_string($conn, $_POST['bid_id']);
        $amount = mysqli_real_escape_string($conn, $_POST['amount']);

        // Update statement
        $update_sql = "UPDATE transactions SET bid_id='$bid_id', amount='$amount' WHERE transaction_id='$transaction_id'";

        if ($conn->query($update_sql) === TRUE) {
            // Redirect to readtransactions.php with updated values
            header("Location: readtransactions.php");
            exit();
        } else {
            echo "Error updating transaction: " . $conn->error;
        }
    }

    // Fetch transaction details based on the ID
    $sql = "SELECT * FROM transactions WHERE transaction_id = '$transaction_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display a form with current values
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='transaction_id' value='" . $row['transaction_id'] . "'>";
        echo "Transaction ID: " . $row['transaction_id'] . "<br>";
        echo "Bid ID: <input type='text' name='bid_id' value='" . $row['bid_id'] . "'><br>";
        echo "Amount: <input type='text' name='amount' value='" . $row['full_amount'] . "'><br>";
        echo "Transaction Date: " . $row['transaction_date'] . "<br>";
        echo "<input type='submit' name='update_transaction' value='Update'>";
        echo "</form>";
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