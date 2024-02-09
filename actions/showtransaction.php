<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href="../css/showtransaction.css">
</head>
<body>
<?php
// Include necessary files
include('../includes/connect.php');
include('../includes/header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "client") {
    // Check if job_id is set
    if (isset($_GET['job_id'])) {
        $job_id = $_GET['job_id'];

        // Fetch transactions related to the specific job
        $sqlTransactions = "SELECT * FROM transactions WHERE job_id = '$job_id'";
        $resultTransactions = $conn->query($sqlTransactions);

        if ($resultTransactions->num_rows > 0) {
            echo "<h2>Transactions for Job ID: $job_id</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Full Amount</th>
                        <th>Status</th>
                        <th>Transaction Date</th>
                    </tr>";

            while ($rowTransaction = $resultTransactions->fetch_assoc()) {
                echo "<tr>
                        <td>{$rowTransaction['transaction_id']}</td>
                        <td>{$rowTransaction['full_amount']}</td>
                        <td>{$rowTransaction['status']}</td>
                        <td>{$rowTransaction['transaction_date']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "No transactions found for Job ID: $job_id";
        }
    } else {
        echo "Job ID not provided.";
    }
} else {
    echo "You are not logged in as a client.";
}
?>

</body>
</html>