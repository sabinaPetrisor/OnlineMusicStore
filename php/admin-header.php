<header class="header">
    <div class="flex">
        <a href="admin-page.php?id=<?php echo $admin_id; ?>" class="logo">Admin<span>Panel</span></a>
        <nav class="navbar">
            <a href="#">Users</a>
            <a href="#">Products</a>
            <a href="#">Orders</a>
            <a href="#">Contacts</a>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="profile-picture">
                <?php 
                    $select = "SELECT * FROM users WHERE id = ?";
                    $select_stmt = mysqli_prepare($conn, $select);
                    mysqli_stmt_bind_param($select_stmt, 'i', $admin_id);
                    mysqli_stmt_execute($select_stmt);
                    $res = mysqli_stmt_get_result($select_stmt);
                    $user = mysqli_fetch_assoc($res);
                ?>
                <img src="../pictures/<?php echo $user['profile_picture']; ?>" alt="">
            </div>
        </div>
        <div class="profile">
            <img src="../pictures/<?php echo $user['profile_picture']; ?>" alt="">
            <p><?php echo $user['username'];?></p>
            <a href="http://localhost/OnlineMusicStore/php/admin-update-profile.php?id=<?php echo $admin_id; ?>" class="btn">Update profile</a>
            <a href="logout.php" class="delete-btn">Logout</a>
        </div>
    </div>
</header>