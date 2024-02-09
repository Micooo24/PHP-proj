<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/client.css">
</head>
<body>
    <div class="wrapper">
        <form method="post" name="moveable-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <h2>Client Company Form</h2>
            <label for="company_name">Company Name:</label>
            <input type="text" id="company_name" name="company_name" required><br><br>
            <label for="website_url">Website (URL):</label>
            <input type="text" id="website_url" name="website_url"><br><br>
            <label for="industry">Industry:</label>
            <input type="text" id="industry" name="industry"><br><br>
            <!-- File input for image attachment -->
            <input type="file" id="img" name="img" style="display: none;" onchange="updateFileName(this)">
            <label for="img" class="file-button">Select Image</label>
            <label id="file-name-label"></label>
            <script>
            function updateFileName(input) {
            var fileNameLabel = document.getElementById("file-name-label");
                if (input.files && input.files.length > 0) {
                    fileNameLabel.textContent = input.files[0].name;
                } else {
                    fileNameLabel.textContent = "";
                }
            }
            </script>
            <input type="submit" value="Submit" name="submit">
            <a href="../actions/signup.php"><--Back to sign up page</a>
        </form>
    </div>
    <div class="quote-container">
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
    
    if (isset($_POST["company_name"], $_POST["website_url"], $_POST["industry"])) {
        $conn = new mysqli($servername, $username, $password, $database);
  
        $company_name = $conn->real_escape_string($_POST["company_name"]);
        $website_url = $conn->real_escape_string($_POST["website_url"]);
        $industry = $conn->real_escape_string($_POST["industry"]);
        
        // Check if the "Submit" button was clicked and process the form data
        if (isset($_POST['submit'])) {
            // File upload handling for image
            $img_name = $_FILES['img']['name'];
            $img_temp = $_FILES['img']['tmp_name'];
            $img_destination = '../project-root/images/profile' . $img_name; // Change this path to your desired upload directory

            move_uploaded_file($img_temp, $img_destination);

            // Insert data into the 'clients' table with the user ID, company details, and image
            $sql = "INSERT INTO clients (user_id, company_name, website_url, industry, img) SELECT user_id, '$company_name', '$website_url', '$industry', '$img_destination' FROM users ORDER BY user_id DESC LIMIT 1";

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
}
?>