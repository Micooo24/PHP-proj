<?php
session_start();
include('includes/connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css\index.css">

  <?php
  // Inline CSS for the video background
  echo "<style>";
  echo "body, html {";
  echo "  height: 100%;";
  echo "  margin: 0;";
  echo "}";

  echo "#video-bg {";
  echo "  position: fixed;";
  echo "  top: 0;";
  echo "  left: 0;";
  echo "  width: 100%;";
  echo "  height: 100%;";
  echo "  object-fit: cover;";
  echo "}";

  echo "</style>";
  ?>
</head>

<body>
  <?php
  include('includes/header.php');

  // Check user role
  if (isset($_SESSION["user_type"])) {
    if ($_SESSION["user_type"] == "freelancer") {
      header("Location: pages/freelancerpage.php");
      exit();
    } elseif ($_SESSION["user_type"] == "client") {
      header("Location: pages/clientpage.php");
      exit();
    } elseif ($_SESSION["user_type"] == "admin") {
      header("Location: pages/admin.php");
      exit();
    } else {
      // Handle other roles or leave it blank
    }
  } else {
    // User not logged in, display welcome message and video background
    echo "<div class='content'>";
    echo "<video autoplay muted loop id='video-bg'>";
    echo "  <source src='images/freelance.mp4' type='video/mp4'>";
    echo "  Your browser does not support the video tag.";
    echo "</video>";
    echo "<h1>Welcome to the Home Page</h1>";
    echo "<p>Please login or register to access the website.</p>";
    echo "<div class='btncontain buttons'>";
    echo "  <div class='btn-container'>";
    echo "    <button class='toggle-btn' onclick='location.href=\"actions/login.php\";'>Login</button>";
    echo "    <button class='toggle-btn' onclick='location.href=\"actions/signup.php\";'>Signup</button>";
    echo "  </div>";
    echo "</div>";
  }
  ?>
</body>

</html>
