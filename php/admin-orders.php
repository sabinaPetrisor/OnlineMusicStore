<?php
    include 'config.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];

    if (isset($_POST['submit'])) {
        $update_id = $_POST['order_id_hidden'];
        $select = "SELECT * FROM orders WHERE id = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_bind_param($select_stmt, 'i', $update_id);
        mysqli_stmt_execute($select_stmt);
        $res = mysqli_stmt_get_result($select_stmt);
        $order = mysqli_fetch_assoc($res);
        $status = $_POST['status'];
        if($status !== $order['status']) {
            $update = "UPDATE orders SET status = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($update_stmt, 'si', $status, $update_id);
            mysqli_stmt_execute($update_stmt);
            if($status === 'completed'){
                preg_match_all('/\d+\sx\s\d+/', $order['products_list'], $matches);
                foreach($matches[0] as $match){
                    //var_dump($match);
                    preg_match('/^\d+/', $match, $product_id);
                    $product_id = (int) $product_id[0];
                    preg_match('/\d+$/', $match, $stock);
                    $stock = (int) $stock[0];
                    //var_dump($match.PHP_EOL.$product_id.PHP_EOL.$stock);
                    $update = "UPDATE products SET stock = stock - ? WHERE id = ?";
                    $update_stmt = mysqli_prepare($conn, $update);
                    mysqli_stmt_bind_param($update_stmt, 'ii', $stock, $product_id);
                    mysqli_stmt_execute($update_stmt);
                }
            }
            //var_dump($matches);
            header('location:http://localhost/OnlineMusicStore/php/admin-orders.php');
        }
        mysqli_free_result($res);
    }
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
        <h1 class="title">Orders</h1>
        <section class="orders">
            <div class="box-container">
                <?php 
                    $select = "SELECT * FROM orders";
                    $select_stmt = mysqli_prepare($conn, $select);
                    mysqli_stmt_execute($select_stmt);
                    $res = mysqli_stmt_get_result($select_stmt);
                    if(mysqli_num_rows($res) > 0){
                        while($order = mysqli_fetch_assoc($res)) {
                ?>
                <div class="box-subcontainer">
                    <p>Order number: <?php echo $order['number']; ?><p>
                    <p>User id: <?php echo $order['user_id']; ?><p>
                    <p>First name: <?php echo $order['first_name']; ?><p>
                    <p>Last name: <?php echo $order['last_name']; ?><p>
                    <p>Email: <?php echo $order['email']; ?><p>
                    <p>Address: <?php echo $order['address']; ?><p>
                    <p>Country: <?php echo $order['country_name']; ?><p>
                    <p>Phone number: <?php echo $order['phone_number']; ?><p>
                    <p>Payment method: <?php echo $order['payment_method']; ?><p>
                    <p>Products: <?php echo $order['products_list']; ?><p>
                    <p>Total price: <?php echo $order['total_price']; ?>€<p>
                    <p>Placed on: <?php echo $order['placed_on']; ?><p>
                    <form action="admin-orders.php" method="POST">
                        <input type="hidden" name="order_id_hidden" value="<?php echo $order['id']; ?>">
                        <?php
                            if($order['status'] === 'completed') echo '<p>Status: Completed</p>';
                            else { 
                        ?>
                        <select name="status" class="dropdown">
                            <option value="" selected disabled><?php echo $order['status']; ?></option>
                            <option value="pending">pending</option>
                            <option value="completed">completed</option>
                        </select>
                        <input type="submit" value="Update Order" id="submit" name="submit" class="btn">
                        <?php } ?>
                    </form>
                </div>
                <?php 
                        }       
                    }
                    else echo '<h2 class="empty">No orders taken yet!</h2>';
                    mysqli_free_result($res);
                ?>
            </div>
        </section>
    </body>
</html>