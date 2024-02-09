<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link rel='stylesheet' href="../css/readtransactions.css">
</head>


<body>
 
    <h2>Transaction Details</h2>

    <?php
    include('../includes/connect.php');
    include('../includes/header.php');
    $sql = "SELECT * FROM transactions"; // Assuming your table name is 'transactions'
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Transaction ID</th><th>Bid ID</th><th>Amount</th><th>Transaction Date</th><th>Edit</th><th>Delete</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['transaction_id'] . "</td>";
            echo "<td>" . $row['bid_id'] . "</td>";
            echo "<td>" . $row['full_amount'] . "</td>";
            echo "<td>" . $row['transaction_date'] . "</td>";
            echo "<td><form action='edit_transactions.php' method='post'><input type='hidden' name='transaction_id' value='" . $row['transaction_id'] . "'><input type='submit' value='Edit'></form></td>";
            echo "<td><form action='delete_transactions.php' method='post'><input type='hidden' name='transaction_id' value='" . $row['transaction_id'] . "'><input type='submit' value='Delete'></form></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No transactions found.";
    }

    $conn->close();
    ?>
</body>
</html>
