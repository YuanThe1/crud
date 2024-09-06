<?php
include("dbconfig.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM users WHERE id = $id";
    mysqli_query($connection, $sql);

    header("Location: index.php");
    exit();
}
?>
