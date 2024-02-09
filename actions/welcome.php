<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: ../actions/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$password = $_SESSION["pass"];
$email = $_SESSION["email"];
$user_type = $_SESSION["user_type"];

?>

<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
    <header>
        <!-- Your header code with updated PHP to display username -->
        <?php if(isset($username)) { ?>
            <div class="user-welcome">Welcome, <?php echo $username; ?></div>
        <?php } ?>
    </header>

</body>
</html>
