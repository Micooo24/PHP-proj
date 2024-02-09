<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jobs</title>
  <link rel='stylesheet' href="../css/freelancerpage.css"> 
</head>

<body>
  <?php 
  include('../includes/header.php'); ?>

<div class="container">
    <section class="splash-section">
        <div class="splash-content">
            <h1>Welcome to Freelancer Homepage</h1>
            <p>Discover exciting freelance opportunities and showcase your skills.</p>
            <?php
               echo '<div class="post-service-buttons">';
               echo '  <a class="post-service-button" href="../actions/createservice.php">Post Service</a>';
               echo '  <a class="post-service-button" href="../pages/bidhistory.php">Bids History</a>';
               echo '</div>';
            ?>
        </div>
    </section>
</div>

<div class="splash-content">
<?php
include('../includes/connect.php');

if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "freelancer") {
    $freelancerId = $_SESSION["user_id"];
    $freelancerQuery = "SELECT * FROM freelancers WHERE freelancer_id = $freelancerId";
    $freelancerResult = $conn->query($freelancerQuery);

    if ($freelancerResult->num_rows > 0) {
        $freelancerData = $freelancerResult->fetch_assoc();
        $freelancerImage = $freelancerData['img'];

        // Check if the image file exists before displaying it
        $imagePath = '../images/profile/' . $freelancerImage;

        if (file_exists($imagePath)) {
            echo "<img src='$imagePath' alt='Freelancer Image' class='freelancer-image'>";
        } else {
            echo "<p>Freelancer image not found. Image path: $imagePath</p>";
        }
    }
}
?>

    <h1>Welcome to Freelancer Homepage</h1>
    <p>Discover exciting freelance opportunities and showcase your skills.</p>

    <?php
    // Generate the "Post Service" link dynamically
    $postServiceLink = '../actions/createservice.php';
    echo "<a class='post-service-button' href='$postServiceLink'>Post Service</a>";

    // Generate the "Bids History" link dynamically
    $bidHistoryLink = '../pages/bidhistory.php';
    echo "<a class='post-service-button' href='$bidHistoryLink'>Bids History</a>";

    if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "freelancer") {
      $editProfileLink = '../actions/updatefreelancer.php';
      echo "<a class='post-service-button' href='$editProfileLink'>Edit Profile</a>";
  }

    ?>
</div>

  <section id="featured-jobs" class="featured-jobs-section">
    <?php
    // Your PHP code for fetching and displaying featured jobs here
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    include($_SERVER['DOCUMENT_ROOT'] . '/project-root/includes/connect.php');

    // Check if the user is logged in as a freelancer
    if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "freelancer") {
      // Fetch jobs data for freelancers from the database
      // Replace the following with your actual database query

      // Sample query to fetch jobs for the logged-in freelancer
      $freelancerId = $_SESSION["user_id"];
      $sql = "SELECT * FROM jobs WHERE status = 'pending';";
      //$sql = "SELECT * FROM jobs WHERE freelancer_id = $freelancerId";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        echo "<div class='table-container'>";

        while ($row = $result->fetch_assoc()) {
          echo "<div class='job-box'>
                  <h2 class='job-title'>{$row['title']}</h2>
                  <p class='job-details'>{$row['descriptions']}</p>
                  <p class='job-details'>Budget: {$row['budget']}</p>
                  <p class='job-details'>Created at: {$row['created_at']}</p>
                  <a class='bid-button' href='bid.php?job_id={$row['job_id']}'>Bid</a>";

          // Check if there's a file associated with the job
          if (!empty($row['files'])) {
            $file_name = $row['files'];
            echo "<a class='view-file-button' href='../uploads/{$file_name}' target='_blank'>View File</a>";
          }

          echo "</div>";
        }

        echo "</div>"; // Close the table container
      } else {
        echo "<div class='no-jobs'>
          <p>No jobs found for this freelancer.</p>
        </div>";
      }
    } else {
      echo "<p class=\"access-denied\">You are not logged in. Log in to access more features.</p>";
    }
    ?>
  </section>
</body>

</html>
