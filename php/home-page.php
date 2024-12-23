<?php
    include 'config.php';
    session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
    /*if (isset($_SESSION['user_id'])) {
        session_unset();  // Elimina toate variabilele din sesiune
        session_destroy();  // Distruge sesiunea complet
    }*/
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
    <?php 
        if(!empty($user_id)) {
            include 'header-logged-in.php';
        }
        else include 'header-not-logged-in.php';
        include 'footer.php';
    ?>
    <script type="text/javascript" src="../javascript/dropdown-menu.js"></script>

    </body>
</html>