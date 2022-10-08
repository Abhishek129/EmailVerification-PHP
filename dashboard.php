<?php
    session_start();
    if(!isset($_SESSION['IS_LOGIN'])){
        header('location:login.php');
        die();
    }
?>

<h1>Welcome user</h1>
<a href="logout.php">Logout</a>