<?php
    include 'config.php';
    session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
    else $user_id = 53;

    if(isset($_POST['filter'])){
            $full_url = 'http://localhost/OnlineMusicStore/php/shop-page.php';
            //var_dump($full_url);
            if(isset($_POST['price_slider'])){
                $max_price = $_POST['price_slider'];
                if($max_price != 0) $full_url .= '?price-range='.$max_price;
            }
            if(isset($_POST['availability'])) {
                if($full_url !== 'http://localhost/OnlineMusicStore/php/shop-page.php') $full_url .= '&availability='.$_POST['availability'];
                else $full_url .= '?availability='.$_POST['availability'];
            }
            //var_dump($full_url);
            header('location:'.$full_url);
    }

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
        <h1 class="title">Shop</h1>
        <div class="shop-container">
            <section class="shop-filters">
                <h2>Filters</h2>
                <?php 
                    $select = "SELECT MAX(price) FROM products";
                    $select_stmt = mysqli_prepare($conn, $select);
                    mysqli_stmt_execute($select_stmt);
                    $res = mysqli_stmt_get_result($select_stmt);
                    $product = mysqli_fetch_all($res, MYSQLI_ASSOC);
                    $max_possible_price = $product[0]['MAX(price)'];
                ?>
                <form method="POST" class="filters-form">
                    <p>Price range:</p>
                    <div class="checkbox-container">
                        <?php
                            if(isset($_GET['price-range'])) {
                                $max_price = (float) $_GET['price-range'];
                        ?>
                                <input type="range" min="0" max="<?php echo $max_possible_price; ?>" value="<?php echo $max_price; ?>" name="price_slider" id="price-slider">
                                <label for="price_slider" id="price-slider-value">Max price: <?php echo $max_price; ?>€</label>
                        <?php
                            }
                            else {
                        ?>
                                <input type="range" min="0" max="<?php echo $max_possible_price; ?>" value="0" name="price_slider" id="price-slider">
                                <label for="price_slider" id="price-slider-value">Max price: 0€</label>
                        <?php
                            }  
                        ?>
                    </div>
                <p>Availability:</p>
                    <div class="checkbox-container">
                        <?php 
                            if(isset($_GET['availability'])) echo '<input type="checkbox" name="availability" value="in_stock" checked>';
                            else echo '<input type="checkbox" name="availability" value="in_stock">'; 
                        ?>
                        <label for="availability">In Stock</label>
                    </div>
                    <input type="submit" name="filter" value="Filter" class="btn">
                </form>
        </section>
            <section class="shop">
                <div class="box-container">
                    <?php 
                        if(isset($_GET['price-range']) && !isset($_GET['availability'])){
                            $select = "SELECT * FROM products WHERE price <= ?";
                            $select_stmt = mysqli_prepare($conn, $select);
                            mysqli_stmt_bind_param($select_stmt, 'd', $max_price);
                        }
                        else if(!isset($_GET['price-range']) && isset($_GET['availability'])){
                            $select = "SELECT * FROM products WHERE stock > 0";
                            $select_stmt = mysqli_prepare($conn, $select);
                        }
                        else if(isset($_GET['price-range']) && isset($_GET['availability'])){
                            $select = "SELECT * FROM products WHERE price <= ? AND stock > 0";
                            $select_stmt = mysqli_prepare($conn, $select);
                            mysqli_stmt_bind_param($select_stmt, 'd', $max_price);
                        }
                        else{
                            $select = "SELECT * FROM products ORDER BY title"; 
                            $select_stmt = mysqli_prepare($conn, $select);
                        }
                        mysqli_stmt_execute($select_stmt);
                        $res = mysqli_stmt_get_result($select_stmt);
                        $products = mysqli_fetch_all($res, MYSQLI_ASSOC);
                        if(count($products) > 0) {
                            foreach($products as $product) {
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
                        <?php 
                            if($product['stock'] == 0) echo '<p>Stock: Out of stock</p>';
                            else echo '<p>Stock: '.$product['stock'].'</p>';
                        ?>
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
                        else echo '<h2 class="empty">No products to show!</h2>';
                        mysqli_free_result($res);
                    ?>
                </div>
            </section>
        </div>
        <?php include 'footer.php'; ?>
    </body>
    <script type="text/javascript" src="../javascript/shop-page.js"></script>
</html>