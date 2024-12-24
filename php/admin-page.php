<?php
    include 'config.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
        <?php include 'admin-header.php';?>
        <script type="text/javascript" src="../javascript/dropdown-menu.js"></script>

        <section class="dashboard">
            <h1 class="title">Dashboard</h1>
            <div class="box-container">
                <div class="box-subcontainer">
                    <?php 
                        $pendings_total = 0;
                        $select = "SELECT * FROM orders WHERE payment_status = ?";
                        $select_stmt = mysqli_prepare($conn, $select);
                        $payment_status = 'pending';
                        mysqli_stmt_bind_param($select_stmt,'s', $payment_status);
                        if(mysqli_stmt_execute($select_stmt)) {
                            $res = mysqli_stmt_get_result($select_stmt);
                            $pendings_number = mysqli_num_rows($res);
                            if($pendings_number > 0) {
                                while($row = mysqli_fetch_assoc($res)) $pendings_total += $res['total_price'];
                            }
                        }
                    ?>
                    <p>Number of pending orders</p>
                    <h2><?php echo $pendings_number;?></h2>
                    <a href="#" class="btn">See Orders</a>
                </div>

                <div class="box-subcontainer">
                    <p>Total from pending orders</p>
                    <h2><?php echo $pendings_total;?>&euro;</h2>
                    <a href="#" class="btn">See Orders</a>
                </div>

                <div class="box-subcontainer">
                    <?php 
                        $completed_total = 0;
                        $select = "SELECT * FROM orders WHERE payment_status = ?";
                        $select_stmt = mysqli_prepare($conn, $select);
                        $payment_status = 'completed';
                        mysqli_stmt_bind_param($select_stmt,'s', $payment_status);
                        if(mysqli_stmt_execute($select_stmt)) {
                            $res = mysqli_stmt_get_result($select_stmt);
                            $completed_number = mysqli_num_rows($res);
                            if($completed_number > 0) {
                                while($row = mysqli_fetch_assoc($res)) $completed_total += $res['total_price'];
                            }
                        }
                    ?>
                    <p>Number of completed orders</p>
                    <h2><?php echo $completed_number;?></h2>
                    <a href="#" class="btn">See Orders</a>
                </div>

                <div class="box-subcontainer">
                    <p>Total from completed orders</p>
                    <h2><?php echo $completed_total;?>&euro;</h2>
                    <a href="#" class="btn">See Orders</a>
                </div>

                <div class="box-subcontainer">
                    <?php 
                        $all_orders_total = 0;
                        $select = "SELECT * FROM orders";
                        $select_stmt = mysqli_prepare($conn, $select);
                        if(mysqli_stmt_execute($select_stmt)) {
                            $res = mysqli_stmt_get_result($select_stmt);
                            $all_orders_number = mysqli_num_rows($res);
                            if($all_orders_number > 0) {
                                while($row = mysqli_fetch_assoc($res)) $all_orders_total += $res['total_price'];
                            }
                        }
                    ?>
                    <p>Total number of orders</p>
                    <h2><?php echo $all_orders_number;?></h2>
                    <a href="#" class="btn">See Orders</a>
                </div>

                <div class="box-subcontainer">
                    <p>Total from all orders</p>
                    <h2><?php echo $all_orders_total;?>&euro;</h2>
                    <a href="#" class="btn">See Orders</a>
                </div>

                <div class="box-subcontainer">
                    <?php 
                        $select = "SELECT * FROM products";
                        $select_stmt = mysqli_prepare($conn, $select);
                        if(mysqli_stmt_execute($select_stmt)) {
                            $res = mysqli_stmt_get_result($select_stmt);
                            $all_products_number = mysqli_num_rows($res);
                        }
                    ?>
                    <p>Total number of products</p>
                    <h2><?php echo $all_products_number;?></h2>
                    <a href="admin-products.php" class="btn">See Products</a>
                </div>

                <div class="box-subcontainer">
                    <?php 
                        $select = "SELECT * FROM users";
                        $select_stmt = mysqli_prepare($conn, $select);
                        if(mysqli_stmt_execute($select_stmt)) {
                            $res = mysqli_stmt_get_result($select_stmt);
                            $all_accounts_number = mysqli_num_rows($res);
                        }
                    ?>
                    <p>Total number of accounts</p>
                    <h2><?php echo $all_accounts_number;?></h2>
                    <a href="#" class="btn">See Users</a>
                </div>

                <div class="box-subcontainer">
                    <?php 
                        $select = "SELECT * FROM users WHERE user_type = ?";
                        $select_stmt = mysqli_prepare($conn, $select);
                        $user_type = 'user';
                        mysqli_stmt_bind_param($select_stmt, 's', $user_type);
                        if(mysqli_stmt_execute($select_stmt)) {
                            $res = mysqli_stmt_get_result($select_stmt);
                            $user_accounts_number = mysqli_num_rows($res);
                        }
                    ?>
                    <p>Number of user accounts</p>
                    <h2><?php echo $user_accounts_number;?></h2>
                    <a href="#" class="btn">See Users</a>
                </div>

                <div class="box-subcontainer">
                    <?php 
                        $select = "SELECT * FROM users WHERE user_type = ?";
                        $select_stmt = mysqli_prepare($conn, $select);
                        $user_type = 'admin';
                        mysqli_stmt_bind_param($select_stmt, 's', $user_type);
                        if(mysqli_stmt_execute($select_stmt)) {
                            $res = mysqli_stmt_get_result($select_stmt);
                            $admin_accounts_number = mysqli_num_rows($res);
                        }
                    ?>
                    <p>Number of admin accounts</p>
                    <h2><?php echo $admin_accounts_number;?></h2>
                    <a href="#" class="btn">See Users</a>
                </div>
            </div>
        </section>
    </body>
</html>