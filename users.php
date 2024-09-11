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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="container">
<div class="grid text-center">
<h2>User List <a type="button" class="btn btn-primary" href='add.php?id= <?php echo $row["id"];?>'>Add</a></h2>
</div>
<div>
</div>
    <?php
    if (mysqli_num_rows($result) > 0) {
        ?>
        <table border='1' class='table table-striped'>
            <tr class='table-dark'>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th class="text-center">Actions</th>
            </tr>
            <?php   
        while($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr class='table table-striped'>
                      <td><?php echo $row["id"]?></td>
                      <td><?php echo $row["name"]?></td>
                      <td><?php echo $row["email"]?></td>
                      <td><?php echo $row["pass"]?></td>
                      <td class="text-center">
                          <a type="button" class="btn btn-success" href='edit.php?id= <?php echo $row["id"];?>'>Edit</a>
                          <a type="button" class="btn btn-danger" href='delete.php?id= <?php echo $row["id"];?>' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                      </td>
                  </tr>
                  <?php 
        }
        ?>
       </table>
       <?php 
    } else {
        echo "0 results";
    }
    
    

    mysqli_close($connection);
    ?>
            <a href="logout.php">Log out</a>

</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN6jIeHz" crossorigin="anonymous"></script>

</html>
