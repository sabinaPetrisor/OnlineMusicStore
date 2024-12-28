<?php
    include 'config.php';
    session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
    if(isset($_POST['modify_quantity'])){
        $product_id = (int) $_POST['product_id_hidden'];
        $quantity = (int) $_POST['quantity'];
        $update = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $update_stmt = mysqli_prepare($conn, $update);
        mysqli_stmt_bind_param($update_stmt, 'iii', $quantity, $user_id, $product_id);
        mysqli_stmt_execute($update_stmt);
        header('location:http://localhost/OnlineMusicStore/php/cart-page.php');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart</title>
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
        <section class="cart">
            <h1 class="title">Cart</h1>
            <div class="box-container">
                <?php 
                    $select = "SELECT c.quantity, p.id, p.title, p.artist, p.price, p.stock, p.cover FROM cart AS c JOIN products p ON c.product_id = p.id WHERE user_id = ?"; 
                    $select_stmt = mysqli_prepare($conn, $select);
                    mysqli_stmt_bind_param($select_stmt, 'i', $user_id);
                    mysqli_stmt_execute($select_stmt);
                    $res = mysqli_stmt_get_result($select_stmt);
                    if(mysqli_num_rows($res) > 0) {
                        while($product = mysqli_fetch_assoc($res)) {
                ?>
                <div class="box-subcontainer">
                    <div class="icons">
                        <a href="product-page.php?title=<?php echo $product['title']; ?>&artist=<?php echo $product['artist']; ?>" class="fas fa-eye"></a>
                        <?php 
                            if(!empty($user_id)) { 
                                echo '<i class="fa-solid fa-heart" data-user-id='.$user_id.' data-product-id='.$product['id'].'></i>';
                            }
                        ?>
                    </div>
                    <img src="../covers/<?php echo $product['cover']; ?>" alt="">
                    <p><?php echo $product['title']; ?> - <?php echo $product['artist'];?></p>
                    <p id="product_price" data-price="<?php echo $product['price']; ?>">Price/unit: <?php echo $product['price']; ?>€</p>
                    <p id="total_price">Total price: <?php echo $product['price'] * $product['quantity']; ?>€</p>
                    <p>Available stock: <?php echo $product['stock']; ?></p>
                    <form action="cart-page.php" method="POST" id="cart-form">
                        <input type="hidden" name="product_id_hidden" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="price_hidden" id="price_hidden" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="stock_hidden" id="stock_hidden" value="<?php echo $product['stock']; ?>">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" min="0" id = "quantity" class="box" placeholder="Enter quantity" value="<?php echo $product['quantity']; ?>">
                        <div class="buttons">
                            <input type="submit" name="modify_quantity" class="btn" value="Modify quantity">
                        </div>
                    </form>
                </div>
                <?php
                        }
                    }
                    else echo '<h2 class="empty">No products added yet to show!</h2>';
                    mysqli_free_result($res);
                ?>
            </div>
            <div class="final-total">
                <p id="total"></p>
            </div>
            <div class="flex-btns">
                <a href="http://localhost/OnlineMusicStore/php/shop-page.php" class="btn">Back to Shop</a>
                <a href="http://localhost/OnlineMusicStore/php/place-order-page.php" class="btn">Place Order</a>
            </div>
        </section>
        <?php include 'footer.php'; ?>
        <script type="text/javascript" src="../javascript/check-like.js"></script>
        <script type="text/javascript" src="../javascript/like-unlike.js"></script>
        <script type="text/javascript" src="../javascript/cart-validation.js"></script>
    </body>
</html>