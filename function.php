<?php
    include("dbconfig.php");
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $insertuser = "INSERT INTO users  (`name`, `email`, `pass`) VALUES ('$name','$email','$password')";
        if(mysqli_query($connection,$insertuser)){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }else{
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
</?>