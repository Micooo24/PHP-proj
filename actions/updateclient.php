<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Client Profile</title>
    <!-- Add your CSS links -->
    <link rel="stylesheet" href="../css/updateclient.css">
</head>

<body>
    <?php
    // Include necessary files and start the session
    //include('../includes/header.php');
    include('../includes/connect.php');
     include('../includes/header.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in and is a client
    if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "client") {
        $user_id = $_SESSION["user_id"];
        $sql = "SELECT * FROM clients WHERE user_id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Display the form to update client details
            echo "<form class=\"custom-form\" action='' method='post' enctype='multipart/form-data'>";
            echo "<label for='company_name'>Company Name:</label>";
            echo "<input type='text' id='company_name' name='company_name' value='{$row['company_name']}'><br>";

            echo "<label for='website_url'>Website URL:</label>";
            echo "<input type='text' id='website_url' name='website_url' value='{$row['website_url']}'><br>";

            echo "<label for='industry'>Industry:</label>";
            echo "<input type='text' id='industry' name='industry' value='{$row['industry']}'><br>";

            echo "<label for='img'>Image:</label>";
            echo "<input type='text' id='img' name='img' value='{$row['img']}'><br>";

            // Input field for uploading a new image
            echo "<label for='new_img'>Attach New Image:</label>";
            echo "<input type='file' id='new_img' name='new_img'><br>";

            echo "<input type='submit' value='Update'>";
            echo "</form>";

            // Process the form submission to update client details
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $company_name = $_POST['company_name'];
                $website_url = $_POST['website_url'];
                $industry = $_POST['industry'];
                $img = $_POST['new_img'];

                // Process the uploaded file
                if ($_FILES['new_img']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '\project-root\images\client'; // Change this directory as needed
                    $uploadFile = $uploadDir . basename($_FILES['new_img']['name']);

                    if (move_uploaded_file($_FILES['new_img']['tmp_name'], $uploadFile)) {
                        // File uploaded successfully, update the image field
                        $img = $uploadFile;
                    } else {
                        echo "Error uploading file.";
                    }
                }

                $updateSql = "UPDATE clients SET company_name = ?, website_url = ?, industry = ?, img = ? WHERE user_id = ?";
                
                $stmtUpdate = $conn->prepare($updateSql);
                $stmtUpdate->bind_param('sssss', $company_name, $website_url, $industry, $uploadFile, $user_id);

                if ($stmtUpdate->execute()) {
                    header("Location: /project-root/pages/clientpage.php"); // Redirect to freelancer page
                    exit();
                } else {
                    echo "Error updating profile: " . $conn->error;
                }
            }
        } else {
            echo "Client details not found.";
        }
    } else {
        echo "<p class=\"access-denied\">You are not logged in as a client.</p>";
    }
    ?>
</body>

</html>
