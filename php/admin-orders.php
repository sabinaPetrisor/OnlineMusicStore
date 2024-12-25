<?php
    include 'config.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];

    if (isset($_POST['submit'])) {
        $update_id = $_POST['order_id_hidden'];
        $select = "SELECT payment_status FROM orders WHERE id = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_bind_param($select_stmt, 'i', $update_id);
        mysqli_stmt_execute($select_stmt);
        $res = mysqli_stmt_get_result($select_stmt);
        $order = mysqli_fetch_assoc($res);
        $payment_status = $_POST['payment_status'];
        if($payment_status !== $order['payment_status']) {
            $update = "UPDATE orders SET payment_status = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($update_stmt, 'si', $payment_status, $update_id);
            mysqli_stmt_execute($update_stmt);
            header('location:http://localhost/OnlineMusicStore/php/admin-orders.php?id='.$admin_id);
        }
        mysqli_free_result($res);
    }
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
                    <p>Phone number: <?php echo $order['phone_number']; ?><p>
                    <p>Payment method: <?php echo $order['payment_method']; ?><p>
                    <p>Products: <?php echo $order['products_list']; ?><p>
                    <p>Total price: <?php echo $order['total_price']; ?>€<p>
                    <p>Placed on: <?php echo $order['placed_on']; ?><p>
                    <form action="admin-orders.php" method="POST">
                        <input type="hidden" name="order_id_hidden" value="<?php echo $order['id']; ?>">
                        <select name="payment_status" class="dropdown">
                            <option value="" selected disabled><?php echo $order['payment_status']; ?></option>
                            <option value="pending">pending</option>
                            <option value="completed">completed</option>
                        </select>
                        <input type="hidden" name="order_id_hidden">
                        <input type="submit" value="Update Order" id="submit" name="submit" class="btn">
                    </form>
                </div>
                <?php 
                        }       
                    }
                    else echo '<h2 class="empty">No products added yet!</h2>';
                    mysqli_free_result($res);
                ?>
            </div>
        </section>
    </body>
</html>