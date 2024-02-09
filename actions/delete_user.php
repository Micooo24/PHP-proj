<?php
// Assuming you have a database connection established in includes/connect.php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    include('../includes/connect.php');

    // Prevent SQL injection by sanitizing the input
    $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

    $sql = "DELETE FROM users WHERE user_id = '$delete_id'";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request";
}
?>
