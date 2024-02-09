<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/createuser.css">
</head>

<body>
<div class="banner-area">
  <h1>Create User</h1>

  <section class="card create-user">
  <div class="icon">
    <img src="../images/createacct.svg" alt="Create User">
  </div>

  <h3>Create User Account</h3>

  <form action="" method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" class="form-control" required>
    </div>

    <div class="form-group">
      <label for="pass">Password:</label>
      <input type="password" id="pass" name="pass" class="form-control" required>
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="form-group">
      <label for="user_type">User Type:</label>
      <select id="user_type" name="user_type" class="form-control" required>
        <option value="client">Client</option>
        <option value="freelancer">Freelancer</option>
      </select>
    </div>

    <button type="submit" name="create_user" class="btn btn-primary">Create User</button>
  </form>
</section>






    <?php  
    include('../includes/header.php'); 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_user'])) {
        $usern = $_POST['username'];
        $pass = $_POST['pass']; // Note: Hash the password before storing in a real application
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];

        // Include the connection to your database
        include('../includes/connect.php');

        // Insert new user into the database
        $sql = "INSERT INTO users (username, pass, email, user_type) VALUES ('$usern', '$pass', '$email', '$user_type')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>

</html>
