<?php
include("dbconfig.php");
session_start(); // Ensure user is logged in

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $pass = mysqli_real_escape_string($connection, $_POST['pass']);
    
    // Hash the password before storing it
    //$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, pass) VALUES ('$name', '$email', '$pass')";
    if (mysqli_query($connection, $sql)) {
        $_SESSION['status']='User has been Created';
        // echo "<div class='alert alert-success'>User added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($connection) . "</div>";
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById('password');
        var eyeIcon = document.getElementById('eyeIcon');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
            eyeIcon.classList.add('active');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
            eyeIcon.classList.remove('active');
        }
    }
</script>
</head>
<body>
<div class="form-container">
    <h2>Add a New User</h2>
    <?php if(isset($_SESSION['status']) && $_SESSION['status'] !='') :?>
        <div class="message alert-success">
            <h6>
                <?php echo $_SESSION['status'];
                unset($_SESSION['status']);
              
                ?>
            </h6>
        </div>
        <?php
  endif;
        ?>
    <form action="add.php" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <div class="input-group">
                <input type="password" id="password" name="pass" class="form-control">
                    <span class="input-group-text eye-icon" onclick="togglePasswordVisibility()">
                        <i  id="eyeIcon" class="fa-solid fa-eye"></i>
                    </span>
                </div>
        </div>
        <div class="container text-center">
            <div class="col">
                <button type="submit" class="btn btn-primary">Add User</button>
                <a href="users.php" class="btn btn-secondary">Back to User List</a>
            </div>
        </div>
    </form>
    
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
