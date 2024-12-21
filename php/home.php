<?php
    include 'config.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    /*if(!isset($user_id)) header('location:http://localhost/OnlineMusicStore/html/login-page.html');
    else header('location:http://localhost/OnlineMusicStore/html/login-page.html');*/
?>