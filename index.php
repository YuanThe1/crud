<?php
include("dbconfig.php");

// Fetch data from the database
$sql = "SELECT id, name, email, pass FROM users"; // Ensure this matches your actual table structure
$result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Example</title>
</head>
<body>
    <h1>Hello World</h1>

    <form action="function.php" method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit" name="submit">Submit</button>
        </div>
    </form>

    <h2>User List</h2>
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
