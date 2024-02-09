<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/freelancer.css">
</head>
<body>
  <div class="wrapper" method="post"> 
    <h2></h2>
    <form method="post" name="moveable-from" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
      <h1 class="moveable-form">Freelancer Profile Form</h1>
      <div class="input-box">
        <input type="text" id="full_name" name="full_name" placeholder="  Full Name"><br><br>
        <box-icon name='user'></box-icon>
      </div>
      <div class="input-box1">
        <textarea id="skills" name="skills" rows="4" required placeholder="Describe your skills.."></textarea><br><br>
        <box-icon name='lock'></box-icon>
      </div>
      <div class="input-box">
        <?php
        if (session_status() == PHP_SESSION_NONE) {
          session_start();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (isset($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
            $fileName = $_FILES['img']['name'];
            echo "The chosen file name is: " . $fileName;
          } else {
            echo "Error uploading file.";
          }
        }
        ?>

        <label for="img" class="file-label">
          <box-icon name='attachment'></box-icon>
          Choose File
        </label>
        <input type="file" id="img" name="img" style="display: none;">
      </div>
      <button type="submit" class="btn">Submit</button>
    </form>
  </div>
  <div class="container">
    <p>The Web as I envisaged it, we have not seen it yet.</p>
    <p>The future is still so much bigger than the past.</p>
    <h5>Tim Berners-Lee - Inventor of the World Wide Web</h5>
  </div>

  <div class="logo">
        <h1>TECH HIRE</h1>
    </div>
</body>
</html>


<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('../includes/connect.php');

  // Check if the required fields are set
  if (isset($_POST["full_name"]) && isset($_POST["skills"])) {
    $conn = new mysqli($servername, $username, $password, $database);

    $full_name = $conn->real_escape_string($_POST["full_name"]);
    $skills = $conn->real_escape_string($_POST["skills"]);

    // File upload handling for image
    $img_name = $_FILES['img']['name'];
    $img_temp = $_FILES['img']['tmp_name'];
    $img_destination = '../project-root/images/profile' . $img_name; // Change this path to your desired upload directory

    move_uploaded_file($img_temp, $img_destination);

    // Your SQL to insert data into the 'freelancers' table with the last inserted user ID
    $sql = "INSERT INTO freelancers (user_id, full_name, skills, img) SELECT user_id, '$full_name', '$skills', '$img_destination' FROM users ORDER BY user_id DESC LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      $conn->close();
      header('Location: reg_complete.php');
      exit;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    echo "Please fill in all the required fields.";
  }
}
?>
