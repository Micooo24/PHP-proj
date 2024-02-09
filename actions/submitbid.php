<?php
// Include your database connection and other necessary files
include($_SERVER['DOCUMENT_ROOT'] . '/project-root/includes/connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $jobId = $_POST['job_id'];
    $bidAmount = $_POST['bidAmount'];
    $proposal = $_POST['proposal'];

    // Check if the user is logged in as a freelancer
    if (isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "freelancer") {
        // Retrieve freelancer ID from the database
        $userId = $_SESSION["user_id"];
        $freelancerIdQuery = "SELECT freelancer_id FROM freelancers WHERE user_id = '$userId'";
        $freelancerResult = $conn->query($freelancerIdQuery);

        if ($freelancerResult->num_rows > 0) {
            // Fetch the freelancer ID from the result set
            $freelancerRow = $freelancerResult->fetch_assoc();
            $freelancerId = $freelancerRow['freelancer_id'];

            // Get the current date and time
            $createdAt = date('Y-m-d H:i:s');

            // Check if file is uploaded
            if (isset($_FILES['attachment'])) {
                $file = $_FILES['attachment'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];

                // Get file extension
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Allowed file types
                $allowedExtensions = array('pdf', 'doc', 'docx');

                if (in_array($fileExt, $allowedExtensions)) {
                    // Generate a unique file name to avoid conflicts
                    $newFileName = uniqid('', true) . "." . $fileExt;

                    // Set the file path where the file will be stored
                    $fileDestination = '/project-root/uploads/' . $newFileName;

                    // Move the file to the specified location
                    move_uploaded_file($fileTmpName, $_SERVER['DOCUMENT_ROOT'] . $fileDestination);

                    // Insert bid data into the "bids" table along with the file name
                    $insertBidQuery = "INSERT INTO bids (freelancer_id, job_id, bid_amount, proposal, created_at, files) 
                        VALUES ('$freelancerId', '$jobId', '$bidAmount', '$proposal', '$createdAt', '$newFileName')";

                    if ($conn->query($insertBidQuery) === TRUE) {
                        // Redirect to the freelancerpage.php with a success message
                        header('Location: /project-root/index.php');
                        exit();
                    } else {
                        // Redirect to the freelancerpage.php with an error message
                        echo "Error: " . $insertBidQuery . "<br>" . $conn->error;
                        exit();
                    }
                } else {
                    echo "Invalid file type. Allowed types: pdf, doc, docx.";
                    exit();
                }
            } else {
                echo "File not uploaded.";
                exit();
            }
        } else {
            echo "User not found in the freelancer table.";
            exit();
        }
    } else {
        echo "Access denied. Please log in as a freelancer.";
        exit();
    }
} else {
    // Redirect to an error page if the form is not submitted
    echo "Form not submitted.";
    exit();
}
?>