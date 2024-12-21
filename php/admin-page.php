<?php
    include 'config.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
        <?php include 'admin-header.php';?>
        <script type="text/javascript" src="../javascript/dropdown-menu.js"></script>
    </body>
</html>