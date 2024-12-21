<?php
    include 'config.php';
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $response = array();
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
        $select = "SELECT * FROM users WHERE email = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_execute($select_stmt, [$email]);
        $res = mysqli_stmt_get_result($select_stmt);
        if(mysqli_num_rows($res) > 0) {
            $user = mysqli_fetch_assoc($res);
            if(password_verify($_POST['password'], $user['password'])) {
                if($user['user_type'] == 'user') {
                    $_SESSION['user_id'] = $user['id'];
                    $response['status'] = 'success';
                    $response['message'] = 'User logged in successfully!';
                    $response['data'] = [
                        'email' => $email,
                        'password' => $user['password'],
                        'user_type' => $user['user_type'],
                        'user_id' => $user['id'],
                        'url' => 'http://localhost/OnlineMusicStore/html/home-page.html'
                    ];
                }
                else {
                    $_SESSION['admin_id'] = $user['id'];
                    $response['status'] = 'success';
                    $response['message'] = 'User logged in successfully!';
                    $response['data'] = [
                        'email' => $email,
                        'password' => $user['password'],
                        'user_type' => $user['user_type'],
                        'user_id' => $user['id'],
                        'url' => 'http://localhost/OnlineMusicStore/php/admin-page.php'
                    ];
                }
            }
            else {
                $response['status'] = 'error';
                $response['message'] = 'Password incorrect!';
                $response['data'] = [];
            }
        }
        else {
            $response['status'] = 'error';
            $response['message'] = 'Email incorrect!';
            $response['data'] = [];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
?>