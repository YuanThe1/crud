<?php
include("dbconfig.php");

session_start(); // Start the session to handle user login state
if (!isset($_SESSION['user_id'] )){
    header('Location: login.php');
}


// Fetch data from the database
$sql = "SELECT id, name, email, pass FROM users"; // Ensure this matches your actual table structure
$result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Example</title>
</head>

<body>
<h2>User List</h2>
<div>
        <a href="logout.php">Log out</a>
</div>
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                      <td>" . htmlspecialchars($row["id"]) . "</td>
                      <td>" . htmlspecialchars($row["name"]) . "</td>
                      <td>" . htmlspecialchars($row["email"]) . "</td>
                      <td>" . htmlspecialchars($row["pass"]) . "</td>
                      <td>
                          <a href='edit.php?id=" . $row["id"] . "'>Edit</a> |
                          <a href='delete.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                      </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    mysqli_close($connection);
    ?>
</body>
</html>
