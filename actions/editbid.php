<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href="../css/editbid.css">
</head>
<body>
    
<?php
// Include your necessary files
include('../includes/connect.php');
//include('../includes/header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in as a freelancer
if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "freelancer") {
    // Ensure bid_id is set and not empty
    if (isset($_GET['bid_id']) && !empty($_GET['bid_id'])) {
        $bid_id = $_GET['bid_id'];

        // Fetch the bid data based on the bid_id
        $sqlBid = "SELECT * FROM bids WHERE bid_id = '$bid_id'";
        $resultBid = $conn->query($sqlBid);

        if ($resultBid->num_rows > 0) {
            $rowBid = $resultBid->fetch_assoc();

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Retrieve form data
                $bid_id = $_POST['bid_id'];
                $bid_amount = $_POST['bid_amount'];

                // Update data in the "bids" table
                $sql = "UPDATE bids 
                        SET bid_amount = '$bid_amount'
                        WHERE bid_id = '$bid_id'";

                if ($conn->query($sql) === TRUE) {
                    // Redirect to the bidhistory.php with a success message
                    header("Location: ../pages/bidhistory.php");
                    exit();
                } else {
                    // Redirect to the bidhistory.php with an error message
                    header("Location: ../pages/bidhistory.php?error=" . urlencode($conn->error));
                    exit();
                }
            }

            // Display the edit bid form
            echo "<div class='form-container'>";
            echo "<h2>Edit Bid</h2>";

            // Display the form
            echo "<form action='' method='post'>";
            
            // Hidden input for bid_id
            echo "<input type='hidden' name='bid_id' value='{$rowBid['bid_id']}'>";

            // Bid Amount textbox
            echo "<label for='bid_amount'>Bid Amount:</label>";
            echo "<input type='number' id='bid_amount' name='bid_amount' value='{$rowBid['bid_amount']}' required><br>";

            // Submit button
            echo "<input type='submit' value='Save Changes'>";
            echo "</form>";

            echo "</div>"; // Close the form-container
        } else {
            echo "<p>Bid not found.</p>";
        }
    } else {
        echo "<p>Invalid request. Bid ID not provided.</p>";
    }
} else {
    // Display a message if the user is not logged in as a freelancer
    echo "<p class=\"access-denied\">Access Denied Pleas Login as Freelancer.</p>";
}

// ... (remaining code)
?>

</body>
</html>