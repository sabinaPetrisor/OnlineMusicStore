<?php
    include 'config.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
    //$update_id = (int) $_GET['update'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $response = array();
        $response['message'] = '';
        $response['title_update_status'] = '';
        $response['artist_update_status'] = '';
        $response['category_update_status'] = '';
        $response['genre_update_status'] = '';
        $response['tracklist_update_status'] = '';
        $response['release_date_update_status'] = '';
        $response['price_update_status'] = '';
        $response['stock_update_status'] = '';
        $response['cover_update_status'] = '';
        $update_id = $_POST['update_id'];
        $select = "SELECT * FROM products WHERE id = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_bind_param($select_stmt, 'i', $update_id);
        mysqli_stmt_execute($select_stmt);
        $res = mysqli_stmt_get_result($select_stmt);
        $product = mysqli_fetch_assoc($res);
        mysqli_free_result($res);
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
        if(empty($title)) $title = $product['title'];
        $artist = htmlspecialchars($_POST['artist'], ENT_QUOTES);
        if(empty($artist)) $artist = $product['artist'];
        $select = "SELECT * FROM products WHERE id != ? AND title = ? AND artist = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_bind_param($select_stmt, 'iss', $update_id, $title, $artist);
        mysqli_stmt_execute($select_stmt);
        $res = mysqli_stmt_get_result($select_stmt);
        if(mysqli_num_rows($res) == 0){
            if($title !== $product['title'] && !empty($title)) {
                $insert = "UPDATE products SET title = ? WHERE id = ?";
                $insert_stmt = mysqli_prepare($conn, $insert);
                mysqli_stmt_bind_param($insert_stmt, 'si', $title, $update_id);
                if(mysqli_stmt_execute($insert_stmt)) $response['title_update_status'] = 'success';
                else {
                    $response['title_update_status'] = 'error';
                    $response['message'] = 'Error when updating title!';
                }
            }
            if($artist !== $product['artist'] && !empty($artist)) {
                $insert = "UPDATE products SET artist = ? WHERE id = ?";
                $insert_stmt = mysqli_prepare($conn, $insert);
                mysqli_stmt_bind_param($insert_stmt, 'si', $artist, $update_id);
                if(mysqli_stmt_execute($insert_stmt)) $response['artist_update_status'] = 'success';
                else {
                    $response['artist_update_status'] = 'error';
                    $response['message'] = 'Error when updating artist!';
                }
            }
            $category = $_POST['category'];
            //if(empty($category)) $category = $product['category'];
            if($category !== $product['category']) {
                $insert = "UPDATE products SET category = ? WHERE id = ?";
                $insert_stmt = mysqli_prepare($conn, $insert);
                mysqli_stmt_bind_param($insert_stmt, 'si', $category, $update_id);
                if(mysqli_stmt_execute($insert_stmt)) $response['category_update_status'] = 'success';
                else {
                    $response['category_update_status'] = 'error';
                    $response['message'] = 'Error when updating category!';
                }
            }
            $genre = htmlspecialchars($_POST['genre'], ENT_QUOTES);
            if($genre !== $product['genre'] && !empty($genre)) {
                $insert = "UPDATE products SET genre = ? WHERE id = ?";
                $insert_stmt = mysqli_prepare($conn, $insert);
                mysqli_stmt_bind_param($insert_stmt, 'si', $genre, $update_id);
                if(mysqli_stmt_execute($insert_stmt)) $response['genre_update_status'] = 'success';
                else {
                    $response['genre_update_status'] = 'error';
                    $response['message'] = 'Error when updating genre!';
                }
            }
            $tracklist = htmlspecialchars($_POST['tracklist'], ENT_QUOTES);
            if(empty($tracklist)) $tracklist = $product['tracklist'];
            if($tracklist !== $product['tracklist'] && !empty($tracklist)) {
                $insert = "UPDATE products SET tracklist = ? WHERE id = ?";
                $insert_stmt = mysqli_prepare($conn, $insert);
                mysqli_stmt_bind_param($insert_stmt, 'si', $tracklist, $update_id);
                if(mysqli_stmt_execute($insert_stmt)) $response['tracklist_update_status'] = 'success';
                else {
                    $response['tracklist_update_status'] = 'error';
                    $response['message'] = 'Error when updating tracklist!';
                }
            }
            $release_date = $_POST['release_date'];
            if(empty($release_date)) $release_date = $product['release_date'];
            if($release_date !== $product['release_date'] && !empty($release_date)) {
                $insert = "UPDATE products SET release_date = ? WHERE id = ?";
                $insert_stmt = mysqli_prepare($conn, $insert);
                mysqli_stmt_bind_param($insert_stmt, 'si', $release_date, $update_id);
                if(mysqli_stmt_execute($insert_stmt)) $response['release_date_update_status'] = 'success';
                else {
                    $response['release_date_update_status'] = 'error';
                    $response['message'] = 'Error when updating release date!';
                }
            }
            $price = (float) $_POST['price'];
            if(empty($price)) $price = $product['price'];
            if($price != $product['price'] && !empty($price)) {
                $insert = "UPDATE products SET price = ? WHERE id = ?";
                $insert_stmt = mysqli_prepare($conn, $insert);
                mysqli_stmt_bind_param($insert_stmt, 'di', $price, $update_id);
                if(mysqli_stmt_execute($insert_stmt)) $response['price_update_status'] = 'success';
                else {
                    $response['price_update_status'] = 'error';
                    $response['message'] = 'Error when updating price!';
                }
            }
            $stock = $_POST['stock'];
            if(empty($stock)) $stock = $product['stock'];
            if($stock != $product['stock'] && !empty($stock)) {
                $insert = "UPDATE products SET stock = ? WHERE id = ?";
                $insert_stmt = mysqli_prepare($conn, $insert);
                mysqli_stmt_bind_param($insert_stmt, 'ii', $stock, $update_id);
                if(mysqli_stmt_execute($insert_stmt)) $response['stock_update_status'] = 'success';
                else {
                    $response['stock_update_status'] = 'error';
                    $response['message'] = 'Error when updating stock!';
                }
            }
            if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
                $filename = $_FILES['cover']['name'];
                $cover_tmp_name = $_FILES['cover']['tmp_name'];
                $cover = uniqid().'_'.basename($filename);
                $cover_folder = '../covers/'.$cover;
                if(move_uploaded_file($cover_tmp_name, $cover_folder)){
                    $insert = "UPDATE products SET cover = ? WHERE id = ?";
                    $insert_stmt = mysqli_prepare($conn, $insert);
                    mysqli_stmt_bind_param($insert_stmt, 'si', $cover, $update_id);
                    if(mysqli_stmt_execute($insert_stmt)){
                        unlink('../covers/'.$product['cover']);
                        $response['cover_update_status'] = 'success';
                    }
                    else {
                        $response['cover_update_status'] = 'error';
                        $response['message'] = 'Error when updating cover!';
                    }
                }
                else{
                    $response['cover_update_status'] = 'error';
                    $response['message'] = 'Failed to upload new cover!';
                }
            }
            else $cover = $product['cover'];
            if(empty($response['message']) && ($response['title_update_status'] === 'success' || $response['artist_update_status'] === 'success' || $response['category_update_status'] === 'success' || $response['genre_update_status'] === 'success' || $response['tracklist_update_status'] === 'success' || $response['release_date_update_status'] === 'success' || $response['price_update_status'] === 'success' || $response['stock_update_status'] === 'success' || $response['cover_update_status'] === 'success')){
                $response['overall_status'] = 'success';
                $response['message'] = 'Product updated successfuly';
                $response['data'] = [
                    'admin_id' => $admin_id
                ];
            }
            else if(empty($response['message']) && empty($response['title_update_status']) && empty($response['artist_update_status']) && empty($response['category_update_status']) && empty($response['genre_update_status']) && empty($response['tracklist_update_status']) && empty($response['release_date_update_status']) && empty($response['price_update_status']) && empty($response['stock_update_status']) && empty($response['cover_update_status'])){
                $response['overall_status'] = 'success';
                $response['message'] = '';
                $response['data'] = [
                    'admin_id' => $admin_id
                ];
            }
        }
        else{
            $response['overall_status'] = 'error';
            $response['message'] = 'The modified product is already existent in the database!';
        }
        //var_dump($response);
        mysqli_free_result($res);
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
                    <input type="hidden" name="update_id" id="update_id" value=<?php echo $update_id; ?>>
                    <label for="title">Title:</label>
                    <input type="text" name="title" class="box" id="title" placeholder="Enter new title" value="<?php echo $product['title']; ?>">
                    <label for="artist">Artist:</label>
                    <input type="text" name="artist" class="box" id="artist" placeholder="Enter new artist" value="<?php echo $product['artist']; ?>">
                    <label for="price">Price (€):</label>
                    <input type="text" name="price" class="box" id="price" placeholder="Enter new price" value="<?php echo $product['price']; ?>">
                    <label for="stock">Stock:</label>
                    <input type="number" name="stock" class="box" id="stock" placeholder="Enter new stock" value="<?php echo $product['stock']; ?>">
                </div>
                <div class="input-box">
                    <label for="category">Category:</label>
                    <select name="category" class="box">
                        <option selected><?php echo $product['category']; ?></option>
                        <?php 
                            $options = ['Studio Album', 'EP', 'Mixtape', 'Single', 'Soundtrack'];
                            foreach($options as $opt) {
                                if($opt !== $product['category']) echo '<option value="'.$opt.'">'.$opt.'</option>';
                            }
                        ?>
                    </select>
                    <label for="genre">Genre:</label>
                    <input type="text" name="genre" class="box" id="genre" placeholder="Edit genres" value="<?php echo $product['genre']; ?>">
                    <label for="release_date">Release Date:</label>
                    <input type="date" name="release_date" value="<?php echo $product['release_date']; ?>" class="box">
                    <label for="cover">Cover (jpg, jpeg or png):</label>
                    <input type="file" name="cover" class="box">
                </div>
            </div>
            <label for="tracklist">Tracklist:</label>
            <textarea name="tracklist" class="box" placeholder="Enter tracklist" value="<?php echo $product['tracklist']; ?>"><?php echo $product['tracklist']; ?></textarea>
            <input type="submit" value="Update Product" id="submit" name="submit" class="btn">
            <?php mysqli_free_result($res); ?>
        </form>
    </section>
    </body>
</html>