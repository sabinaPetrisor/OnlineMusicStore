<?php
    if($user_id != 53){
        $select = "SELECT * FROM wishlist WHERE user_id = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_bind_param($select_stmt, 'i', $user_id);
        mysqli_stmt_execute($select_stmt);
        $res = mysqli_stmt_get_result($select_stmt);
        $favorites_count = mysqli_num_rows($res);
    }
?>

<header class="header">
    <div class="flex">
        <a href="http://localhost/OnlineMusicStore/php/home-page.php" class="logo">Online<span>MusicStore</span></a>
        <nav class="navbar">
            <a href="home-page.php">Home</a>
            <a href="http://localhost/OnlineMusicStore/php/shop-page.php">Shop</a>
            <a href="#">Orders</a>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <?php
                if($user_id != 53){
                    echo '<a href="http://localhost/OnlineMusicStore/php/favorites-page.php" class="fa-solid fa-heart">';
                    if($favorites_count > 0) echo '('.$favorites_count.')';
                    echo '</a>';
                }
            ?>
            <?php
                if($user_id != 53){
                    mysqli_free_result($res);
                }
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
            <div id="user-btn" class="profile-picture">
                <?php 
                    if($user_id != 53) {
                        mysqli_free_result($res);
                        $select = "SELECT * FROM users WHERE id = ?";
                        $select_stmt = mysqli_prepare($conn, $select);
                        mysqli_stmt_bind_param($select_stmt, 'i', $user_id);
                        mysqli_stmt_execute($select_stmt);
                        $res = mysqli_stmt_get_result($select_stmt);
                        $user = mysqli_fetch_assoc($res);
                        echo '<img src="../pictures/'.$user['profile_picture'].'" alt="">
                            </div>
                        </div>
                        <div class="profile">
                        <img src="../pictures/'.$user['profile_picture'].'" alt="">
                        <p>'.$user['username'].'</p>
                        <a href="http://localhost/OnlineMusicStore/php/user-update-profile.php" class="btn">Update profile</a>
                        <a href="logout.php" class="delete-btn">Logout</a>
                        </div>';
                    }
                ?>
    </div>
    <?php mysqli_free_result($res); ?>
</header>