<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../css/login.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <div class="wrapper">
        <form action="" method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder ="Username" required>
                
                <box-icon name='user'></box-icon>
            </div>
            <div class="input-box">
               <input type="password" name="password" placeholder ="Password" required>
               <box-icon name='lock'></box-icon>
            </div>

            <div class="remember-forgot">
             <input type="checkbox" id="remember-me">
             <label for="remember-me">Remember Me</label>
             <a href="#">Forgot Password?</a>
             </div>
            <button type="submit" class="btn">Login</button>

            <div class="register-link">
                <p>Don't have an account? <a href="signup.php">Register</a></p>
            </div>
        </form>
        
        <div class="error-message">
        <?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../includes/connect.php";
    include('../includes/header.php');

    // Get username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // SQL query to check if the user exists
    $sql = "SELECT * FROM users WHERE username='$username' AND pass='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, set session variable and redirect to welcome page
        $user = $result->fetch_assoc();
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["pass"] = $user["pass"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["user_type"] = $user["user_type"];
        $_SESSION["logged_in"] = true;

        header("Location: ../index.php");
        exit();
    } else {
        // User does not exist, handle accordingly (e.g., display an error message)
        echo "Invalid username or password";
    }
}
?>

        </div>
    </div>
</body>
</html>