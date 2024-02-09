<?php
// Retrieve user_id from the URL parameter
if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Retrieve user information from the database based on user_id
    include('../includes/connect.php');

    $sql = "SELECT * FROM users WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        // Handle the case where user is not found
    }
} else {
    echo "User ID not specified.";
    // Handle the case where user_id is not passed
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Add your CSS stylesheets here -->
</head>

<body>
    <!-- Display user information for editing -->
    <form action="" method="post">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>">
        </div>
        <div>
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="pass" value="<?php echo $user['pass']; ?>">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>">
        </div>
        <div>
            <label for="user_type">User Type:</label>
            <select id="user_type" name="user_type">
                <option value="client" <?php if($user['user_type'] === 'client') echo 'selected'; ?>>Client</option>
                <option value="freelancer" <?php if($user['user_type'] === 'freelancer') echo 'selected'; ?>>Freelancer</option>
            </select>
        </div>
        <!-- Include the user_id in a hidden field to be sent when updating -->
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
        <input type="submit" value="Update">
    </form>
</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        $usern = $_POST['username'];
        $pass = $_POST['pass']; // NOTE: It's recommended to use encryption/hashing for passwords in a real application
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];

        include('../includes/connect.php');

        // Update user information in the database
        $sql = "UPDATE users SET username='$usern', pass='$pass', email='$email', user_type='$user_type' WHERE user_id='$user_id'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
            // Redirect back to admin.php after updating
            header("Location: ../pages/admin.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
        

        $conn->close();
    }
}
?>

</html>
