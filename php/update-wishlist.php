<?php
    include 'config.php';
    /*session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];*/
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"));
    //var_dump($data);
    $user_id = $data->user_id;
    $product_id = $data->product_id;
    if($data->is_favorite) {
        $select = "SELECT MAX(id) FROM wishlist";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_execute($select_stmt);
        $res = mysqli_stmt_get_result($select_stmt);
        $row = mysqli_fetch_assoc($res);
        $max_id = $row['MAX(id)'];
        $id = $max_id + 1;
        $insert = "INSERT INTO wishlist (id, user_id, product_id) VALUES (?, ?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert);
        mysqli_stmt_bind_param($insert_stmt, 'iii', $id, $user_id, $product_id);
        if(mysqli_stmt_execute($insert_stmt)) $executed = true;
        else $executed = false;
    }
    else {
        $delete = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete);
        mysqli_stmt_bind_param($delete_stmt, 'ii', $user_id, $product_id);
        if(mysqli_stmt_execute($delete_stmt)) $executed = true;
        else $executed = false;
    }
    mysqli_free_result($res);
    if($executed) echo json_encode(['success' => true]);
    else echo json_encode(['success' => false]);
?>