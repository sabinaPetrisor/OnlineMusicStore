<?php
    include 'config.php';
    session_start();
    session_unset();
    session_destroy();
    header('location:http://localhost/OnlineMusicStore/php/home-page.php');
?>