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
    ?>
    <script type="text/javascript" src="../javascript/dropdown-menu.js"></script>
    <section class="latest-products">
        <h1 class="title">Latest</h1>
        <div class="box-container">
            <?php 
                $select = "SELECT * FROM products ORDER BY id DESC LIMIT 5";
                $select_stmt = mysqli_prepare($conn, $select);
                mysqli_stmt_execute($select_stmt);
                $res = mysqli_stmt_get_result($select_stmt);
                if(mysqli_num_rows($res)) {
                    while($product = mysqli_fetch_assoc($res)) {
            ?>
            <div class="box-subcontainer">
                <a href="#" class="fas fa-eye"></a>
                <img src="../covers/<?php echo $product['cover']; ?>" alt="">
                <p>Title: <?php echo $product['title']; ?><p>
                <p>Artist: <?php echo $product['artist']; ?><p>
                <p>Category: <?php echo $product['category']; ?><p>
                <p>Genre: <?php echo $product['genre_list']; ?><p>
                <p>Price: <?php echo $product['price']; ?>€<p>
                <p>Stock: <?php echo $product['stock']; ?><p>
                <div class="buttons">
                    <?php 
                        if(!empty($user_id)) { 
                            echo '<a href="http://localhost/OnlineMusicStore/php/admin-update-product.php?update='.$product['id'].' " class="btn">Add to Wishlist</a>';
                        }
                    ?>
                    <!--<a href="http://localhost/OnlineMusicStore/php/admin-update-product.php?update=<?php echo $product['id']; ?>" class="btn">Update</a>-->
                    <a href="http://localhost/OnlineMusicStore/php/admin-products.php?delete=<?php echo $product['id']; ?>" class="btn">Add to Cart</a>
                </div>
            </div>
            <?php
                    }
                }
                else echo '<h2 class="empty">No products added yet!</h2>';
                mysqli_free_result($res);
            ?>
        </div>
    </section>
    <?php include 'footer.php'; ?>
    </body>
</html>