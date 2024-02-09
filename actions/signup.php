<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["freelance_name"]) && isset($_POST["freelance_mail"]) && isset($_POST["freelance_pass"]) && isset($_POST['user_type'])) {
        include('../includes/connect.php');


        $freelance_name = $_POST["freelance_name"];
        $freelance_mail = $_POST["freelance_mail"];
        $freelance_pass = $_POST["freelance_pass"];
        $user_type = $_POST['user_type']; // The user_type sent from the form

        // Perform data validation and sanitization here if needed

        if ($user_type === 'freelancer') {
            // Insert data for a freelancer user into the 'users' table
            $sql = "INSERT INTO users (username, pass, email, user_type) VALUES ('$freelance_name', '$freelance_pass', '$freelance_mail', 'freelancer')";
            if ($conn->query($sql) === TRUE) {
                // Redirect to freelancer_index.php in the freelancerside folder
                $conn->close();
                header('Location: /project-root/pages/freelancer.php');
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } elseif ($user_type === 'client') {
            // Insert data for a client user into the 'users' table
            $sql = "INSERT INTO users (username, pass, email, user_type) VALUES ('$freelance_name', '$freelance_pass', '$freelance_mail', 'client')";
            if ($conn->query($sql) === TRUE) {
                // Redirect to client_index.php in the clientside folder
                $conn->close();
                header('Location: /project-root/pages/client.php');
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Please fill in all the required fields and select a user type."; // Prompt for missing fields or user type
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
    <?php
    include('../includes/header.php');
    ?>

    <div class="hero">
        <div class="form-box">
           
            <div class="social-icons">
                <h1>Sign Up</h1>
            </div>
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="selectUserType('freelancer')">Freelancer</button>
                <button type="button" class="toggle-btn" onclick="selectUserType('client')">Client</button>
            </div>
            <form id="freelancer" class="input-group" method="POST">
                <input type="freelance_name" name="freelance_name" class="input-field" placeholder="Create Username" required>
                <input type="password" name="freelance_pass" class="input-field" placeholder="Create Password" required>
                <input type="freelance_mail" name="freelance_mail" class="input-field" placeholder="Email" required>
                <input type="checkbox" class="check-box"><span>Remember Password</span>
                <input type="hidden" id="user_type" name="user_type" value="">
                <button type="submit" class="submit-btn" onclick="validateAndSubmit(event)">Sign up</button>
            </form>
        </div>
    </div>

    <script>
    var z = document.getElementById("btn");
    var freelancerButton = document.querySelector(".toggle-btn:nth-child(1)");

    // Select Freelancer by default
    selectUserType('freelancer');

    function selectUserType(type) {
        document.getElementById('user_type').value = type;
        if (type === 'freelancer') {
            z.style.left = "0";
            freelancerButton.classList.add("active");
            document.querySelector(".toggle-btn:nth-child(2)").classList.remove("active");
        } else if (type === 'client') {
            z.style.left = "110px";
            document.querySelector(".toggle-btn:nth-child(1)").classList.remove("active");
            document.querySelector(".toggle-btn:nth-child(2)").classList.add("active");
        }
    }

    function validateAndSubmit(event) {
        if (document.getElementById('user_type').value === '') {
            alert('Please select a user type (Freelancer or Client).');
            event.preventDefault();
        }
    }
    </script>

</body>
</html>