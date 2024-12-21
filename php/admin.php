<?php
    include 'config.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
    /*if(!isset($admin_id)) header('location:http://localhost/OnlineMusicStore/html/login-page.html');
    else header('location:http://localhost/OnlineMusicStore/html/login-page.html');*/
?>