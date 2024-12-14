<?php
    $serverName = "DESKTOP-0N239VO";
    $connectionOptions = [
        "Database" => "web_test",
        "UID" => "",
        "PWD" => ""
    ];
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if($conn == false) die(print_r(sqlsrv_errors(), true));
    //else echo "Conectare reusita la web_test!";
?>