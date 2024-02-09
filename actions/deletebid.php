<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel='stylesheet' href='../css/deletebid.css'>
</head>
<body>


<header class="my-header">
  </header>
<?php
// Include your necessary files
include('../includes/header.php');
include('../includes/connect.php');

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

      // Handle form submission for confirmation
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Delete the bid from the database
        $sqlDelete = "DELETE FROM bids WHERE bid_id = '$bid_id'";

        if ($conn->query($sqlDelete) === TRUE) {
          // Redirect to the bidhistory.php with a success message
          header("Location: ../pages/bidhistory.php");
          exit();
        } else {
          // Redirect to the bidhistory.php with an error message
          header("Location: ../pages/bidhistory.php?error=" . urlencode($conn->error));
          exit();
        }
      }

      // Display the confirmation form
      echo "<div class='form-container'>";
      echo "<h2>Delete Bid</h2>";

      // Display the bid details
      echo "<p>Are you sure you want to delete the bid with ID: {$rowBid['bid_id']}?</p>";

      // Display the confirmation form
      echo "<form action='' method='post'>";

      // Hidden input for bid_id
      echo "<input type='hidden' name='bid_id' value='{$rowBid['bid_id']}'>";

      // Confirm deletion button
      echo "<input type='submit' value='Confirm'>";
      echo "</form>";
      echo '<button onclick="window.location.href=\'../pages/bidhistory.php\'">Return</button>';

      echo "</div>"; // Close the form-container
    } else {
      echo "<p>Bid not found.</p>";
    }
  } else {
    echo "<p>Invalid request. Bid ID not provided.</p>";
  }
} else {
  // Display a message if the user is not logged in as a freelancer
  echo "<p class=\"access-denied\">Please log in to view services.</p>";
}

// ... (remaining code)
?>

</body>
</html>
