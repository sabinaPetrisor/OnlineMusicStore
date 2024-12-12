<?php
    $serverName = "DESKTOP-0N239VO";
    $connectionOptions = [
        "Database" => "online_musicstore_db",
        "UID" => "",
        "PWD" => ""
    ];
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if($conn == false) die(print_r(sqlsrv_errors(), true));
    /*else echo "Conectare reusita!";*/
?>