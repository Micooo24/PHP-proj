<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    //<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    //<link rel="preconnect" href="https://fonts.googleapis.com">
    //<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    //<link href="https://fonts.googleapis.com/css2?family=Julius+Sans+One&display=swap" rel="stylesheet">
    //<link rel="stylesheet" href="../css/index.css"> 
    <link rel="stylesheet" href="../css/admin.css"> <!-- Assuming this is the path to your CSS file -->


</head>

<body>

<main class="cards">
  <section class="card contact">
    <div class="icon">
      <img src="../images/createacct.svg" alt="Create Account">
    </div>
    <h3>Create user account</h3>
    <span>Add new members in our community.</span>
    <form action="" method="post">
      <input type="submit" name="create_user" value="Create User" class="button2">
    </form>
  </section>

  <section class="card contact">
    <div class="icon">
      <img src="../images/list.svg" alt="Contact us">
    </div>
    <h3>User lists</h3>
    <span>See the list of our users.</span>
    <form action="" method="post">
      <input type="submit" name="list_users" value="List of Users" class="button1">
    </form>   
  </section>

  <section class="card contact">
  <div class="icon">
  <img src="../images/services.svg" alt="Services">
    </div>
    <h3>Services</h3>
    <span>See the details of services.</span>
    <form action="" method="post">
      <input type="submit" name="services" value="Services" class="button4">
    </form>
  </section>

  </section>


  <section class="card contact">
  <div class="icon">
  <img src="../images/jobs.svg" alt="Jobs">
    </div>
    <h3>Jobs</h3>
    <span>See the details of jobs.</span>
    <form action="" method="post">
      <input type="submit" name="jobs" value="Jobs" class="button5">
    </form>
  </section>

  <section class="card contact">
  <div class="icon">
  <img src="../images/transaction.svg" alt="Jobs">
    </div>
    <h3>Transactions</h3>
    <span>See details of transactions</span>
    <form action="" method="post">
      <input type="submit" name="transactions" value="Transactions" class="button3">
    </form>
</main>


<div class="banner-area">
  <h1>Admin Dashboard</h1>
</div>

    <?php include('../includes/header.php'); ?>

    <!-- Splash Page Section -->
    <section class="splash-section" style="margin-top: 100px;">
   
            <!-- PHP code to display users -->
            <?php
            if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
              // Admin is logged in, allow access to admin functionalities
              include('../includes/connect.php');

              if (isset($_POST['list_users'])) {
                header("Location: ../actions/readuser.php");
                exit();
              }
  
              if (isset($_POST['create_user'])) {
                  // Redirect to the page where you create a user
                  header("Location: ../actions/createuser.php");
                  exit();
              }
  
              if (isset($_POST['transactions'])) {
                header("Location: ../actions/readtransactions.php");
                exit();
              }
  
              if (isset($_POST['services'])) {
                header("Location: ../actions/createservice.php");
                exit();
              }
  
              if (isset($_POST['jobs'])) {
                header("Location: ../actions/createjob.php");
                exit();
              }
          } else {
              // Redirect to login page
              header("Location: ../actions/login.php");
              exit();
          }
           

            ?>
    </section>
</body>

</html>
