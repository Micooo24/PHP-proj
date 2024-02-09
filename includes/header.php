<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="../css/header.css">
    <style>
        /* Add this style to make the welcome message and username white */
        header ul li:last-child {
            color: white;
        }
    </style>
</head>
<body>

<header>
    <div class="logo"><h1>Tech Hire</h1></div>
    <div class="search-box">
        <form>
            <input type="text" name="search" id="srch" placeholder="Search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <ul>
        <li><a href="/project-root/index.php">Home</a></li>
        <li><a href="/project-root/pages/services.php">Services</a></li>
        <li><a href="/project-root/pages/about.php">About</a></li>
        <li>
            <?php
            // Check if the user is logged in
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                echo '<a href="/project-root/actions/logout.php" onclick="return confirm(\'Are you sure you want to log out?\')">Logout</a>';
            } else {
                echo '<a href="/project-root/actions/login.php">Login</a>';
            }
            ?>
        </li>
        <li>
            <?php
            // Display a welcome message based on user role
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && isset($_SESSION['username'])) {
                echo '<span style="color: white;">Welcome, ';
                if ($_SESSION['user_type'] === 'freelancer') {
                    echo 'Freelancer ' . $_SESSION['username'];
                } elseif ($_SESSION['user_type'] === 'client') {
                    echo 'Client ' . $_SESSION['username'];
                }
                echo '</span>';
            }
            ?>
        </li>
    </ul>
    <div class="menu">
        <label for="chk1">
            <i class="fa fa-bars"></i>
        </label>
    </div>
</header>     