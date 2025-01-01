<?php
    include 'config.php';
    session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
    else $user_id = 53;
    if(isset($_POST['cart_add'])) {
        $cart_prod_id = (int) $_POST['product_id_hidden'];
        $select = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_bind_param($select_stmt, 'ii', $user_id, $cart_prod_id);
        mysqli_stmt_execute($select_stmt);
        $res = mysqli_stmt_get_result($select_stmt);
        if(mysqli_num_rows($res) == 1){
            $cart_prod = mysqli_fetch_assoc($res);
            $quantity = $cart_prod['quantity'] + 1;
            $update = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $update_stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($update_stmt, 'iii', $quantity, $user_id, $cart_prod_id);
            mysqli_stmt_execute($update_stmt);
        }
        else{
            $select = "SELECT MAX(id) FROM cart";
            $select_stmt = mysqli_prepare($conn, $select);
            mysqli_stmt_execute($select_stmt);
            $res = mysqli_stmt_get_result($select_stmt);
            $row = mysqli_fetch_assoc($res);
            $max_id = $row['MAX(id)'];
            $id = $max_id + 1;
            $insert = "INSERT INTO cart (id, user_id, product_id) VALUES (?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert);
            mysqli_stmt_bind_param($insert_stmt, 'iii', $id, $user_id, $cart_prod_id);
            mysqli_stmt_execute($insert_stmt);
        }
        mysqli_free_result($res);
        header('location:http://localhost/OnlineMusicStore/php/shop-page.php');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shop</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="../javascript/check-like.js"></script>
        <script type="text/javascript" src="../javascript/like-unlike.js"></script>
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
        <section class="shop">
            <h1 class="title">Shop</h1>
            <div class="box-container">
                <?php 
                    $select = "SELECT * FROM products ORDER BY title"; 
                    $select_stmt = mysqli_prepare($conn, $select);
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
                    <p>Title: <?php echo $product['title']; ?><p>
                    <p>Artist: <?php echo $product['artist']; ?><p>
                    <p>Genre: <?php echo $product['genre_list']; ?><p>
                    <p>Price: <?php echo $product['price']; ?>€<p>
                    <p>Stock: <?php echo $product['stock']; ?><p>
                    <form action="shop-page.php" method="POST">
                        <input type="hidden" name="product_id_hidden" value="<?php echo $product['id']; ?>">
                        <div class="buttons">
                            <input type="submit" name="cart_add" class="btn" value="Add to Cart">
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
        </section>
        <?php include 'footer.php'; ?>
    </body>
</html>