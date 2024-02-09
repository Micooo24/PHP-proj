<?php
include($_SERVER['DOCUMENT_ROOT'] . '/project-root/includes/connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form is submitted via GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if the user is logged in as an admin
    $isAdmin = isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "admin";

    // Check if delete button is clicked for services
    if (isset($_GET['service_id'])) {
        $serviceId = $_GET['service_id'];

        // Prepare SQL for deletion based on user type (admin or non-admin)
        if ($isAdmin) {
            // Admin can delete any service
            $sqlDeleteService = "DELETE FROM services WHERE service_id = '$serviceId'";
        } else {
            // Non-admin users delete only based on their own freelancer ID
            $user_id = $_SESSION["user_id"];
            $sql = "SELECT freelancer_id FROM freelancers WHERE user_id = '$user_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $freelancerId = $row['freelancer_id'];
                $sqlDeleteService = "DELETE FROM services WHERE service_id = '$serviceId' AND freelancer_id = '$freelancerId'";
            } else {
                echo "User not found in the freelancer table.";
                exit();
            }
        }

        if ($conn->query($sqlDeleteService) === TRUE) {
            // Redirect to the appropriate page after deletion
            if ($isAdmin) {
                header('Location: /project-root/actions/createservice.php');
            } else {
                header('Location: /project-root/actions/createservice.php');
            }
            exit();
        } else {
            echo "Error deleting service: " . $conn->error;
        }
    } else {
        // Redirect to an error page if delete button is not clicked
        header('Location: /project-root/error.php');
        exit();
    }
} else {
    // Output nothing if the form is not submitted via GET request
    echo "wala";
    exit();
}
?>
