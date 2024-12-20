<?php
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $database = "web_test";
    $conn = new mysqli($serverName, $username, $password, $database);
    if ($conn->connect_error) die("Eroare de conectare: " . $conn->connect_error);
    //else echo "Conectare reușită la baza de date '$database'!<br>";
?>