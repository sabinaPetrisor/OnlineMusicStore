<?php
    include 'config.php';
    session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Place Order</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    <body>
        <?php 
            if(!empty($user_id)) {
                include 'header-logged-in.php';
            }
            else include 'header-not-logged-in.php';
        ?>
        <script type="text/javascript" src="../javascript/dropdown-menu.js"></script>
        <section class="place-order">
            <h1 class="title">Place Order</h1>
        </section>
    </body>
</html>