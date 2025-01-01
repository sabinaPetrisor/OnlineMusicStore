<header class="header">
    <div class="flex">
        <a href="home-page.php" class="logo">Online<span>MusicStore</span></a>
        <nav class="navbar">
            <a href="home-page.php">Home</a>
            <a href="http://localhost/OnlineMusicStore/php/shop-page.php">Shop</a>
            <a href="http://localhost/OnlineMusicStore/php/login-page.php">Login</a>
            <a href="http://localhost/OnlineMusicStore/php/register-page.php">Register</a>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <?php
                $select = "SELECT * FROM cart WHERE user_id = ?";
                $select_stmt = mysqli_prepare($conn, $select);
                mysqli_stmt_bind_param($select_stmt, 'i', $user_id);
                mysqli_stmt_execute($select_stmt);
                $res = mysqli_stmt_get_result($select_stmt);
                $cart_count = mysqli_num_rows($res);
            ?>
            <a href="http://localhost/OnlineMusicStore/php/cart-page.php" class="fas fa-shopping-cart">
                <?php
                    if($cart_count > 0) echo '('.$cart_count.')';
                ?>
            </a>
    </div>
    <?php mysqli_free_result($res); ?>
</header>