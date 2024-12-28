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
            <div class="box-container">
                <?php
                    $select = "SELECT c.quantity, p.title, p.artist, p.price FROM cart AS c JOIN products AS p ON c.product_id = p.id WHERE user_id = ?";
                    $select_stmt = mysqli_prepare($conn, $select);
                    mysqli_stmt_bind_param($select_stmt, 'i', $user_id);
                    mysqli_stmt_execute($select_stmt);
                    $res = mysqli_stmt_get_result($select_stmt);
                    while($product = mysqli_fetch_assoc($res)) {
                ?>
                <div class="box-subcontainer">
                    <p class="bold-paragraph">"<?php echo $product['title']; ?>" - <?php echo $product['artist'];?></p>
                    <p>x <?php echo $product['quantity']; ?></p>
                    <p id="total-product-price" data-total-product-price="<?php echo $product['price'] * $product['quantity']; ?>">Subtotal: <?php echo $product['price'] * $product['quantity']; ?>€</p>
                </div>
                <?php        
                    }
                ?>
            </div>
            <div class="final-total">
                <p id="total"></p>
            </div>
            <form id="place-order-form">
                <label for="email">Email:</label>
                <input type="text" name="email" class="box" id="email" placeholder="Enter your email" autocomplete="off">
            </form>
        </section>
        <script type="text/javascript" src="../javascript/order-page.js"></script>
    </body>
</html>