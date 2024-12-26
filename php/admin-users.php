<?php
    include 'config.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Orders</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
        <?php include 'admin-header.php';?>
        <script type="text/javascript" src="../javascript/dropdown-menu.js"></script>
        <h1 class="title">Users</h1>
        <section class="users">
            <div class="box-container">
                <?php 
                    $select = "SELECT * FROM users";
                    $select_stmt = mysqli_prepare($conn, $select);
                    mysqli_stmt_execute($select_stmt);
                    $res = mysqli_stmt_get_result($select_stmt);
                    if(mysqli_num_rows($res) > 0){
                        while($user = mysqli_fetch_assoc($res)) {
                ?>
                <div class="box-subcontainer">
                    <img src="../pictures/<?php echo $user['profile_picture']; ?>" alt="">
                    <p>Username: <?php echo $user['username']; ?></p>
                    <p>Email: <?php echo $user['email']; ?></p>
                    <p>Type: <?php echo $user['user_type']; ?></p>
                </div>
                <?php 
                        }       
                    }
                    else echo '<h2 class="empty">No users yet!</h2>';
                    mysqli_free_result($res);
                ?>
            </div>
        </section>
    </body>
</html>