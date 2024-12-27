<footer class="footer">
    <section class="box-container">
        <div class="footer-box">
            <h3>Quick links</h3>
            <?php
                if(!empty($user_id)) echo '<a href="http://localhost/OnlineMusicStore/php/home-page.php?id='.$user_id.'"><i class="fas fa-angle-right"></i>Home</a>';
                else echo '<a href="http://localhost/OnlineMusicStore/php/home-page.php"><i class="fas fa-angle-right"></i>Home</a>';
            ?>
            <a href="#"><i class="fas fa-angle-right"></i>Shop</a>
            <a href="#"><i class="fas fa-angle-right"></i>Orders</a>
        </div>

        <div class="footer-box">
        <h3>Extra links</h3>
        <a href="#"><i class="fas fa-angle-right"></i>Cart</a>
        <a href="#"><i class="fas fa-angle-right"></i>Wishlist</a>
        </div>
    </section>
</footer>