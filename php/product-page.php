<?php
    include 'config.php';
    session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
    else $user_id = 53;
    if(isset($_GET['title']) && isset($_GET['artist'])) {
        $title = urldecode($_GET['title']);
        $artist = urldecode($_GET['artist']);
        $title = html_entity_decode($title);
        $artist = html_entity_decode($artist);
        $title = htmlspecialchars($title, ENT_QUOTES);
        $artist = htmlspecialchars($artist, ENT_QUOTES);
        $select = "SELECT * FROM products WHERE title = ? AND artist = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_bind_param($select_stmt, 'ss', $title, $artist);
        mysqli_stmt_execute($select_stmt);
        $res = mysqli_stmt_get_result($select_stmt);
        $product = mysqli_fetch_assoc($res);
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
        //mysqli_free_result($res);
        header('location:http://localhost/OnlineMusicStore/php/product-page.php?title='.str_replace('+', '%20', urlencode($title)).'&artist='.str_replace('+', '%20', urlencode($artist)));
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Details</title>
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
        <section class="specific-product">
            <h1 class="title"><?php echo $product['title'].' - '.$product['artist'];?></h1>
            <div class="product-details">
                <div class="img-and-fav-button">
                    <img src="../covers/<?php echo $product['cover']; ?>" alt="">
                    <?php 
                        if($user_id != 53) echo '<i class="fa-solid fa-heart" data-user-id='.$user_id.' data-product-id='.$product['id'].'></i>';
                    ?>
                </div>
                <div class="price-and-stock">
                    <p class="lbl">Price:</p>
                    <p class="content"><?php echo $product['price']; ?>€</p>
                    <form action="product-page.php?title=<?php echo $product['title']; ?>&artist=<?php echo $product['artist'];?>" method="POST">
                        <input type="hidden" name="product_id_hidden" value="<?php echo $product['id']; ?>">
                        <div class="buttons">
                            <input type="submit" name="cart_add" class="btn" value="Add to Cart">
                        </div>
                    </form>
                    <p class="lbl">Stock:</p>
                    <p class="content"><?php echo $product['stock']; ?></p>
                </div>
            </div>
            <div class="all-details">
                <p>Title:</p>
                <p class="content"><?php echo $product['title']; ?></p>
                <p>Artist:</p>
                <p class="content"><?php echo $product['artist']; ?></p>
                <p>Category:</p>
                <p class="content"><?php echo $product['category']; ?></p>
                <p>Genre:</p>
                <p class="content"><?php echo $product['genre_list']; ?></p>
                <p>Tracklist:</p>
                <p class="content"><?php echo $product['tracklist']; ?></p>
                <p>Release Date:</p>
                <p class="content"><?php echo $product['release_date']; ?></p>
            </div>
        </section>
        <?php 
            include 'footer.php';
            //mysqli_free_result($res);
        ?>
    </body>
</html>