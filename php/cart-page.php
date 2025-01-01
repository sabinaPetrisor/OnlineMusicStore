<?php
    include 'config.php';
    session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
    else $user_id = 53;
    if(isset($_POST['modify_quantity'])){
        $product_id = (int) $_POST['product_id_hidden'];
        $quantity = (int) $_POST['quantity'];
        if($quantity == 0) {
            $delete = "DELETE FROM cart WHERE product_id = ?";
            $delete_stmt = mysqli_prepare($conn, $delete);
            mysqli_stmt_bind_param($delete_stmt, 'i', $product_id);
            mysqli_stmt_execute($delete_stmt);
        }
        else{
            $update = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $update_stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($update_stmt, 'iii', $quantity, $user_id, $product_id);
            mysqli_stmt_execute($update_stmt);
        }
        header('location:http://localhost/OnlineMusicStore/php/cart-page.php');
    }

    if(isset($_POST['back'])){
        header('location:http://localhost/OnlineMusicStore/php/shop-page.php');
    }
    if(isset($_POST['empty_cart'])){
        $delete = "DELETE FROM cart WHERE user_id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete);
        mysqli_stmt_bind_param($delete_stmt, 'i', $user_id);
        mysqli_stmt_execute($delete_stmt);
        header('location:http://localhost/OnlineMusicStore/php/cart-page.php');
    }
    if(isset($_POST['place_order'])){
        header('location:http://localhost/OnlineMusicStore/php/place-order-page.php');
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
            if($user_id != 53) {
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
                            if($user_id != 53) { 
                                echo '<i class="fa-solid fa-heart" data-user-id='.$user_id.' data-product-id='.$product['id'].'></i>';
                            }
                        ?>
                    </div>
                    <img src="../covers/<?php echo $product['cover']; ?>" alt="">
                    <p><?php echo $product['title']; ?> - <?php echo $product['artist'];?></p>
                    <p>Price/unit: <?php echo $product['price']; ?>€</p>
                    <p class="subtotal" data-subtotal="<?php echo $product['price'] * $product['quantity']; ?>">Total price: <?php echo $product['price'] * $product['quantity']; ?>€</p>
                    <p>Available stock: <?php echo $product['stock']; ?></p>
                    <form action="cart-page.php" method="POST" class="cart-form">
                        <input type="hidden" name="product_id_hidden" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="price_hidden" class="price_hidden" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="stock_hidden" class="stock_hidden" value="<?php echo $product['stock']; ?>">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" min="0" class="box" placeholder="Enter quantity" value="<?php echo $product['quantity']; ?>">
                        <div class="buttons">
                            <input type="submit" name="modify_quantity" class="btn" value="Modify quantity">
                        </div>
                    </form>
                </div>
                <?php
                        }
                ?>
            </div>
            <div class="final-total">
            <p class="total"></p>
            </div>
            <div class="flex-btns">
                <!--<a href="http://localhost/OnlineMusicStore/php/shop-page.php" class="btn">Back to Shop</a>-->
                <form action="cart-page.php" method="POST">
                    <input type="submit" name="back" class="btn" value="Back to Shop">
                    <input type="submit" name="empty_cart" class="btn" value="Empty cart">
                    <input type="submit" name="place_order" class="btn place-order" value="Place Order">
                </form>
            </div>
            <?php
                }
                else echo '
                </div>
                <div class="empty-container">
                    <h2 class="empty">No products added to cart!</h2>
                    <div class="flex-btns">
                        <form action="cart-page.php" method="POST">
                            <input type="submit" name="back" class="btn" value="Back to Shop">
                        </form>
                    </div>
                </div>
                ';
                mysqli_free_result($res);
            ?>
        </section>
        <?php include 'footer.php'; ?>
        <script type="text/javascript" src="../javascript/check-like.js"></script>
        <script type="text/javascript" src="../javascript/like-unlike.js"></script>
        <script type="text/javascript" src="../javascript/cart-validation.js"></script>
    </body>
</html>