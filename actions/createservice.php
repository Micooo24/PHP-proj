<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Service - Tech Hire</title>
    <link rel='stylesheet' href="../css/createservice.css">
    <!-- Include your other CSS files as needed -->
</head>

<body>
    <?php
    ob_start();
    // Include your header and other necessary files
    //include('../includes/header.php');
    include('../includes/connect.php');
    include('../includes/header.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in and determine user type
    if (isset($_SESSION["user_type"])) {
        if ($_SESSION["user_type"] == "freelancer") {
            // Display the create service form for freelancer
            $user_id = $_SESSION["user_id"];
            $sql = "SELECT freelancer_id FROM freelancers WHERE user_id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $user_id);
  $stmt->execute();

  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Fetch the freelancer ID from the result set
    $row = $result->fetch_assoc();
    $freelancerId = $row['freelancer_id'];
  } else {
    echo "User not found in the freelancer table.";
    exit();
  }

  // Check if the form is submitted and insert data into the "services" table
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $deliveryTime = $_POST['initialDays'];

    // Get the current date and time
    $createdAt = date('Y-m-d H:i:s');

    $file_name = $_FILES['attached_file']['name']; // Get the name of the file
    $file_temp = $_FILES['attached_file']['tmp_name']; // Get the temporary location of the file


    // Set the destination path for the file
    $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . '/project-root/uploads/';
    $destination = $uploads_dir . $file_name;

    if (move_uploaded_file($file_temp, $destination)) {
      // Insert data into the "services" table with the file name
      $sql = "INSERT INTO services (freelancer_id, title, descriptions, price, delivery_time, created_at, files) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";

      $stmtInsert = $conn->prepare($sql);
      $stmtInsert->bind_param('sssssss', $freelancerId, $title, $description, $price, $deliveryTime, $createdAt, $file_name);

      if ($stmtInsert->execute() === TRUE) {
          // Set a session variable to indicate success
          $_SESSION['success_message'] = 'Service created successfully!';
      } else {
          // Display an error message
          echo "Error: " . $conn->error;
      }
  } else {
      echo "File upload failed.";
  }

  }

  // Display the create service form
  echo "<div class='container'>";
  echo "<div class='form-container'>";
  echo "<h2>Create New Service</h2>";

  // Display the form
  echo "<form action='' method='post' enctype='multipart/form-data'> ";

  // Title textbox
  echo "<label for='title'>Title:</label>";
  echo "<input type='text' id='title' name='title' required><br>";

  // Description textbox
  echo "<label for='description'>Description:</label>";
  echo "<textarea id='description' name='description' rows='4' required></textarea><br>";

  // Price textbox
  echo "<label for='price'>Price:</label>";
  echo "<input type='number' id='price' name='price' min='0' step='100' required><br>";

  // Initial Delivery Days dropdown
  echo "<label for='initialDays'>Initial Delivery Days:</label>";
  echo "<select id='initialDays' name='initialDays' required>";
  for ($i = 1; $i <= 100; $i++) {
    echo "<option value='{$i}'>{$i}</option>";
  }
  echo "</select><br>";

  echo "<label for='attached_file'>Attach File:</label>";
  echo "<input type='file' id='attached_file' name='attached_file'><br>";


  // Submit button
  echo "<input type='submit' value='Submit'>";
  echo "</form>";

  echo "</div>"; // Close the form-container

  // Display services table
  echo "<div class='table-container'>";
  echo "<h2>Your Services</h2>";

  // Fetch and display services posted by the user
  $sqlServices = "SELECT * FROM services WHERE freelancer_id = ?";

  $stmtServices = $conn->prepare($sqlServices);
  $stmtServices->bind_param('s', $freelancerId);
  $stmtServices->execute();

  $resultServices = $stmtServices->get_result();

  // Check if there are any rows in the result set
  if ($resultServices && $resultServices->num_rows > 0) {
    // Display services table
    echo "<table id='servicesTable'>";
    echo "<tr>
              <th>Title</th>
              <th>Description</th>
              <th>Price</th>
              <th>Files</th>
              <th>Delivery Time</th>
              <th>Created At</th>
              <th>Edit</th>
              <th>Delete</th>
          </tr>";

    while ($rowService = $resultServices->fetch_assoc()) {
      echo "<tr> 
                  <td>{$rowService['title']}</td>
                  <td>{$rowService['descriptions']}</td>
                  <td>{$rowService['price']}</td>
                  <td><a href='../actions/view_file.php?file_name={$rowService['files']}'>View File</a></td>
                  <td>{$rowService['delivery_time']}</td>
                  <td>{$rowService['created_at']}</td>
                  <td><a href='editservice.php?service_id={$rowService['service_id']}'>Edit</a></td>
                  <td><a href='deleteservice.php?service_id={$rowService['service_id']}'>Delete</a></td>
              </tr>";
    }

    echo "</table>";
  } else {
    // Display a message if no services found
    echo "<p>No services found. <a href='#'>Create a new service</a>.</p>";
  }

  echo "</div>"; // Close the table-container
  echo "</div>"; // Close the container

  // Display the success message if it exists in the session
  if (isset($_SESSION['success_message'])) {
    echo "<div class='success-popup'>{$_SESSION['success_message']}</div>";
    // Unset the session variable to avoid displaying the message on page refresh
    unset($_SESSION['success_message']);
  }
        } elseif ($_SESSION["user_type"] == "admin") {
          echo "<div class='table-container'>";
          echo "<h2>Services Table</h2>";
      
          // Fetch and display services from the table for admins
          //Read from table services
          $sqlServices = "SELECT * FROM services";
      
          $resultServices = $conn->query($sqlServices);
      
          if ($resultServices && $resultServices->num_rows > 0) {
              // Display services table
              echo "<table id='servicesTable'>";
              echo "<tr>
                      <th>Service ID</th>
                      <th>Freelancer ID</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Price</th>
                      <th>Files</th>
                      <th>Delivery Time</th>
                      <th>Created At</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>";
      
              while ($rowService = $resultServices->fetch_assoc()) {
                  echo "<tr>  
                          <td>{$rowService['service_id']}</td>
                          <td>{$rowService['freelancer_id']}</td>
                          <td>{$rowService['title']}</td>
                          <td>{$rowService['descriptions']}</td>
                          <td>{$rowService['price']}</td>
                          <td><a href='../actions/view_file.php?file_name={$rowService['files']}'>View File</a></td>
                          <td>{$rowService['delivery_time']}</td>
                          <td>{$rowService['created_at']}</td>
                          <td><a href='editservice.php?service_id={$rowService['service_id']}'>Edit</a></td>
                          <td><a href='deleteservice.php?service_id={$rowService['service_id']}'>Delete</a></td>
                        </tr>";
              }
      
              echo "</table>";
          } else {
              // Display a message if no services found
              echo "<p>No services found.</p>";
          }

        } else {
            echo "<p class=\"access-denied\">Invalid user type. Log in with correct credentials.</p>";
        }
    } else {
        echo "<p class=\"access-denied\">You are not logged in. Log in to access more features.</p>";
    }
    ob_end_flush();
    ?>

</body>

</html>

