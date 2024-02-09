<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel='stylesheet' href="../css/readuser.css">
</head>

<body>
    <h2>User List</h2>

    <?php 
    // Assuming you have a database connection established in includes/connect.php

    include('../includes/connect.php');
    include('../includes/header.php');

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>User ID</th><th>Username</th><th>Email</th><th>User Type</th><th>Edit</th><th>Delete</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['user_type'] . "</td>";
            echo "<td>";
            echo "<a href='edituser.php?user_id=" . $row['user_id'] . "'>Update</a>";
            echo "<td>";
            echo "<form action='delete_user.php' method='post' onsubmit='return confirm(\"Are you sure you want to delete this user?\");'>";
            echo "<input type='hidden' name='delete_id' value='" . $row['user_id'] . "'>";
            echo "<input type='submit' value='Delete'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No users found.";
    }

    $conn->close();
    ?>
</body>

</html>
