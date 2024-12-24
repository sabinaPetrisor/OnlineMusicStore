<?php
    include 'config.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $response = array();
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
        $artist = htmlspecialchars($_POST['artist'], ENT_QUOTES);
        $select = "SELECT * FROM products WHERE title = ? AND artist = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_bind_param($select_stmt, 'ss', $title, $artist);
        if(mysqli_stmt_execute($select_stmt)) {
            $res = mysqli_stmt_get_result($select_stmt);
            if(!mysqli_num_rows($res)) {
                $category = htmlspecialchars($_POST['category'], ENT_QUOTES);
                $tracklist = htmlspecialchars($_POST['tracklist'], ENT_QUOTES);
                $release_date = htmlspecialchars($_POST['release_date'], ENT_QUOTES);
                $price = (float) $_POST['price'];
                $stock = (int) $_POST['stock'];
                $filename = $_FILES['cover']['name'];
                $cover_tmp_name = $_FILES['cover']['tmp_name'];
                $cover = uniqid().'_'.basename($filename);
                $cover_folder = '../covers/'.$cover;
                if(!move_uploaded_file($cover_tmp_name, $cover_folder)) {
                    $response['status'] = 'error';
                    $response['message'] = 'Failed to upload cover picture!';
                }
                $insert = "INSERT INTO products (title, artist, category, tracklist, release_date, price, stock, cover) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $insert_stmt = mysqli_prepare($conn, $insert);
                mysqli_stmt_bind_param($insert_stmt, 'sssssdis', $title, $artist, $category, $tracklist, $release_date, $price, $stock, $cover);
                if(mysqli_stmt_execute($insert_stmt)) {
                    $response['status'] = 'success';
                    $response['message'] = 'Product added successfuly!';
                    $response['data'] = [
                        'title' => $title,
                        'artist' => $artist,
                        'category' => $category,
                        'tracklist' => $tracklist,
                        'release_date' => $release_date,
                        'price' => $price,
                        'stock' => $stock,
                        'cover' => $cover,
                        'admin_id' => $admin_id
                    ];
                }
                else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error when inserting into database!';
                }
            }
            else {
                $response['status'] = 'error';
                $response['message'] = 'Product already exists!';
            }
        }
        else {
            $response['status'] = 'error';
            $response['message'] = 'Error when selecting from database!';
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
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

    <h1 class="title">Add Product</h1>
    <section class="add-products">
        <form id="add-products-form" enctype="multipart/form-data">
            <div class="input-box-container">
                <div class="input-box">
                    <label for="title">Title:</label>
                    <input type="text" name="title" class="box" id="title" placeholder="Enter product title">
                    <label for="price">Price (€):</label>
                    <input type="text" name="price" class="box" id="price" placeholder="Enter product price">
                    <label for="stock">Stock:</label>
                    <input type="text" name="stock" class="box" id="stock" placeholder="Enter product stock">
                </div>
                <div class="input-box">
                    <label for="artist">Artist:</label>
                    <input type="text" name="artist" class="box" id="artist" placeholder="Enter artist name">
                    <label for="category">Category:</label>
                    <select name="category" class="box">
                        <option value="" selected disabled>Select Category</option>
                        <option value="Studio Album">Studio Album</option>
                        <option value="EP">EP</option>
                        <option value="Single">Single</option>
                        <option value="Soundtrack">Soundtrack</option>
                    </select>
                    <label for="release_date">Release Date:</label>
                    <input type="date" name="release_date" class="box">
                    <label for="cover">Cover (jpg, jpeg or png):</label>
                    <input type="file" name="cover" class="box">
                </div>
            </div>
            <div class="input-box">
                <label for="tracklist">Tracklist:</label>
                <textarea name="tracklist" class="box" placeholder="Enter tracklist" cols="10" rows="10"></textarea>
            </div>
            <input type="submit" class="btn" name="submit" id="submit">
        </form>
    </section>

    <h1 class="title">Added Products</h1>
    <section class="show-products">
        <div class="box-container">
            <?php
                $select = "SELECT * FROM products";
                $select_stmt = mysqli_prepare($conn, $select);
                mysqli_stmt_execute($select_stmt);
                $res = mysqli_stmt_get_result($select_stmt);
                if(mysqli_num_rows($res) > 0) {
                    while($product = mysqli_fetch_assoc($res)) {
            ?>
            <div class="box-subcontainer">
                <img src="../covers/<?php echo $product['cover']; ?>" alt="">
                <div class="prod_title">Title: <?php echo $product['title']; ?></div>
                <div class="artist">Artist: <?php echo $product['artist']; ?></div>
                <div class="category">Category: <?php echo $product['category']; ?></div>
                <div class="tracklist">Tracklist: <?php echo $product['tracklist']; ?></div>
                <div class="release-date">Release Date: <?php echo $product['release_date']; ?></div>
                <div class="price">Price: <?php echo $product['price']; ?></div>
                <div class="stock">Stock: <?php echo $product['stock']; ?></div>
                <div class="buttons">
                    <a href="#" class="btn">Update</a>
                    <a href="#" class="delete-btn">Delete</a>
                </div>
            </div>
            <?php
                    }
                }
                else echo '<p class="empty">No products added yet!</p>';
            ?>
        </div>
    </section>
    </body>
</html>