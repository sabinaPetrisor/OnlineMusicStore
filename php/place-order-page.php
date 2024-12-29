<?php
    include 'config.php';
    session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Place Order</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>
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
        <section class="place-order-products">
            <h1 class="title">Place Order</h1>
            <div class="box-container">
                <?php
                    $select = "SELECT c.quantity, p.title, p.artist, p.price FROM cart AS c JOIN products AS p ON c.product_id = p.id WHERE user_id = ?";
                    $select_stmt = mysqli_prepare($conn, $select);
                    mysqli_stmt_bind_param($select_stmt, 'i', $user_id);
                    mysqli_stmt_execute($select_stmt);
                    $res = mysqli_stmt_get_result($select_stmt);
                    $total = 0;
                    while($product = mysqli_fetch_assoc($res)) {
                        $total += $product['price'] * $product['quantity'];
                ?>
                <div class="box-subcontainer">
                    <p class="bold-paragraph">"<?php echo $product['title']; ?>" - <?php echo $product['artist'];?></p>
                    <p>x <?php echo $product['quantity']; ?></p>
                    <p>Subtotal: <?php echo $product['price'] * $product['quantity']; ?>€</p>
                </div>
                <?php        
                    }
                    mysqli_free_result($res);
                ?>
            </div>
            <div class="final-total">
                <p>Grand Total: <?php echo $total; ?>€</p>
            </div>
        </section>
        <section class="place-order">
        <h1 class="title">Additional Order Details</h1>
        <form id="place-order-form" class="place-order-form">
                <div class="input-box-container">
                    <div class="input-box">
                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" class="box" id="first_name" placeholder="Enter your first name" autocomplete="off">
                        <label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" class="box" id="last_name" placeholder="Enter your last name" autocomplete="off">
                        <label for="last_name">Email:</label>
                        <?php 
                            $select = "SELECT email FROM users WHERE id = ?";
                            $select_stmt = mysqli_prepare($conn, $select);
                            mysqli_stmt_bind_param($select_stmt, 'i', $user_id);
                            mysqli_stmt_execute($select_stmt);
                            $res = mysqli_stmt_get_result($select_stmt);
                            $user = mysqli_fetch_assoc($res);
                            if(empty($user_id)) echo '<input type="text" name="email" class="box" id="email" placeholder="Enter your email" autocomplete="off">';
                            else echo '<input type="text" name="email" class="box" id="email" placeholder="Enter your email" value="'.$user['email'].'">';
                        ?>
                        <label for="country">Country:</label>
                        <select name="country" class="box">
                            <?php 
                                mysqli_free_result($res);
                                $select = "SELECT * FROM countries";
                                $select_stmt = mysqli_prepare($conn, $select);
                                mysqli_stmt_execute($select_stmt);
                                $res = mysqli_stmt_get_result($select_stmt);
                                while($country = mysqli_fetch_assoc($res)) {
                                    echo '<option value="'.$country['name'].'">'.$country['name'].'</option>';
                                }
                            ?>
                        </select>
                        <label for="city">City:</label>
                        <input type="text" name="city" class="box" id="city" placeholder="Enter your city" autocomplete="off">
                        <label for="phone_number">Phone Number:</label>
                        <input type="text" name="phone_number" class="box" id="phone_number" placeholder="Enter your phone_number" autocomplete="off">
                    </div>
                    <div class="input-box">
                        <label for="address1">Street Name and Number:</label>
                        <input type="text" name="address1" class="box" id="address1" placeholder="Enter street name and number" autocomplete="off">
                        <label for="address2">Additional Address Details:</label>
                        <input type="text" name="address2" class="box" id="address2" placeholder="Enter additional address details" autocomplete="off">
                        <label for="postal_code">Postal Code:</label>
                        <input type="text" name="postal_code" class="box" id="postal_code" placeholder="Enter address postal code" autocomplete="off">
                        <label for="payment_method">Payment Method</label>
                        <select name="payment_method" class="box">
                                <option value="Cash on delivery">Cash on delivery</option>
                                <option value="Credit card">Credit card</option>
                        </select>
                    </div>
                </div>
                <input type="submit" value="Place Order" id="submit" name="submit" class="btn">
            </form>
        </section>
        <script type="text/javascript" src="../javascript/order-page.js"></script>
    </body>
</html>