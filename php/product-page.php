<?php
    include 'config.php';
    session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
    if(isset($_GET['title']) && isset($_GET['artist'])) {
        $title = $_GET['title'];
        $artist = $_GET['artist'];
        $select = "SELECT * FROM products WHERE title = ? AND artist = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_bind_param($select_stmt, 'ss', $title, $artist);
        mysqli_stmt_execute($select_stmt);
        $res = mysqli_stmt_get_result($select_stmt);
        $product = mysqli_fetch_assoc($res);
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
            if(!empty($user_id)) {
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
                    <i class="fa-solid fa-heart" data-user-id=<?php echo $user_id; ?> data-product-id=<?php echo $product['id']; ?>></i>
                </div>
                <div class="price-and-stock">
                    <p class="lbl">Price:</p>
                    <p class="content"><?php echo $product['price']; ?>€</p>
                    <div class="buttons">
                        <a href="#" class="btn">Add to Cart</a>
                    </div>
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