<?php
    include 'config.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Products</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>
        <script type="text/javascript" src="../javascript/admin-product-validation.js"></script>
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
    <?php 
        include 'admin-header.php';
    ?>
    <script type="text/javascript" src="../javascript/dropdown-menu.js"></script>
    <h1 class="title">Update Product</h1>
    <section class="update-product">
        <?php
            $update_id = (int) $_GET['update'];
            $select = "SELECT * FROM products WHERE id = ?";
            $select_stmt = mysqli_prepare($conn, $select);
            mysqli_stmt_bind_param($select_stmt, 'i', $update_id);
            mysqli_stmt_execute($select_stmt);
            $res = mysqli_stmt_get_result($select_stmt);
            $product = mysqli_fetch_assoc($res);
        ?>
        <form id="update-form" class="update-form" enctype="multipart/form-data">
            <img src="../covers/<?php echo $product['cover']; ?>" alt="">
            <div class="input-box-container">
                <div class="input-box">
                    <label for="title">Title:</label>
                    <input type="text" name="title" class="box" id="title" placeholder="<?php echo $product['title']; ?>">
                    <label for="price">Price (€):</label>
                    <input type="text" name="price" class="box" id="price" placeholder="<?php echo $product['price']; ?>">
                    <label for="stock">Stock:</label>
                    <input type="text" name="stock" class="box" id="stock" placeholder="<?php echo $product['stock']; ?>">
                </div>
                <div class="input-box">
                    <label for="artist">Artist:</label>
                    <input type="text" name="artist" class="box" id="artist" placeholder="<?php echo $product['artist']; ?>">
                    <label for="category">Category:</label>
                    <select name="category" class="box">
                        <option value="" selected disabled>Select Category</option>
                        <option value="Studio Album">Studio Album</option>
                        <option value="EP">EP</option>
                        <option value="Mixtape">Mixtape</option>
                        <option value="Single">Single</option>
                        <option value="Soundtrack">Soundtrack</option>
                    </select>
                    <label for="release_date">Release Date:</label>
                    <input type="date" name="release_date" class="box">
                    <label for="cover">Cover (jpg, jpeg or png):</label>
                    <input type="file" name="cover" class="box">
                </div>
        </form>
    </section>
    </body>
</html>