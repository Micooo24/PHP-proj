<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Freelancer Profile</title>
    <!-- Add your CSS links -->
    <link rel="stylesheet" href="../css/updatefreelancer.css">

</head>

<body>
    <?php
    // Include necessary files and start the session
    //include('../includes/header.php');
    include('../includes/connect.php');

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in and is a freelancer
    if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "freelancer") {
        $user_id = $_SESSION["user_id"];
        $sql = "SELECT * FROM freelancers WHERE user_id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Display the form to update freelancer details
            echo "<form class=\"custom-form\" form action='' method='post' enctype='multipart/form-data'>";
            echo "<label for='full_name'>Full Name:</label>";
            echo "<input type='text' id='full_name' name='full_name' value='{$row['full_name']}'><br>";

            echo "<label for='bio'>Bio:</label>";
            echo "<textarea id='bio' name='bio' rows='4'>{$row['bio']}</textarea><br>";

            echo "<label for='skills'>Skills:</label>";
            echo "<input type='text' id='skills' name='skills' value='{$row['skills']}'><br>";

            echo "<label for='portfolio'>Portfolio:</label>";
            echo "<input type='text' id='portfolio' name='portfolio' value='{$row['portfolio_url']}'><br>";

            echo "<label for='img'>Image:</label>";
            echo "<input type='text' id='img' name='img' value='{$row['img']}'><br>";

            // Input field for uploading a new image
            echo "<label for='new_img'>Attach New Image:</label>";
            echo "<input type='file' id='new_img' name='new_img'><br>";

            echo "<input type='submit' value='Update'>";
            echo "</form>";

            // Process the form submission to update freelancer details
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $full_name = $_POST['full_name'];
                $bio = $_POST['bio'];
                $skills = $_POST['skills'];
                $portfolio = $_POST['portfolio'];   
                $img = $_POST['new_img'];

                // Process the uploaded file
                if ($_FILES['new_img']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '\project-root\images\profile/'; // Change this directory as needed
                    $uploadFile = $uploadDir . basename($_FILES['new_img']['name']);
                    $tmpFileName = $_FILES[$new_img]['tmp_name'];
                    $uniqueFileName = uniqid() . '_' . $_FILES[$new_img]['name']; 
                    $destination = $uploadDirectory . '/' . $uniqueFileName;
                    
                    if (move_uploaded_file($tmpFileName, $destination)) {
                        // File uploaded successfully, update the image field
                        $img = $uploadFile;
                    } else {
                        echo "Error uploading file.";
                    }
                }

                $updateSql = "UPDATE freelancers SET full_name = ?, bio = ?, skills = ?, portfolio_url = ?, img = ? WHERE user_id = ?";
                
                $stmtUpdate = $conn->prepare($updateSql);
                $stmtUpdate->bind_param('ssssss', $full_name, $bio, $skills, $portfolio, $uploadFile, $user_id);

                if ($stmtUpdate->execute()) {
                    header("Location: /project-root/pages/freelancerpage.php");
                    exit();
                } else {
                    echo "Error updating profile: " . $conn->error;
                }
            }
        } else {
            echo "Freelancer details not found.";
        }
    } else {
        echo "<p class=\"access-denied\">You are not logged in as a freelancer.</p>";
    }
    ?>
</body>

</html>
