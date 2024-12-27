<?php
    include 'config.php';
    /*session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];*/
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"));
    $user_id = $data->user_id;
    $product_id = $data->product_id;
    $select = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
    $select_stmt = mysqli_prepare($conn, $select);
    mysqli_stmt_bind_param($select_stmt, 'ii', $user_id, $product_id);
    mysqli_stmt_execute($select_stmt);
    $res = mysqli_stmt_get_result($select_stmt);
    if(mysqli_num_rows($res) == 0) {
        mysqli_free_result($res);
        echo json_encode(['exists_in_wishlist' => false]);
    }
    else {
        mysqli_free_result($res);
        echo json_encode(['exists_in_wishlist' => true]);
    }
?>