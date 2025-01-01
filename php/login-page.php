<?php
    include 'config.php';
    session_start();
    if (isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];
    else $user_id = 53;
    if($user_id == 53){
        $delete = "DELETE FROM cart WHERE user_id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete);
        mysqli_stmt_bind_param($delete_stmt, 'i', $user_id);
        mysqli_stmt_execute($delete_stmt);
        session_unset();
        session_destroy();
        session_start();
    }
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
                        'id' => $user['id'],
                        'url' => 'http://localhost/OnlineMusicStore/php/home-page.php'
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
                        'id' => $user['id'],
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
        <title>Login</title>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>
        <script type="text/javascript" src="../javascript/login-validation.js"></script>
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
        <section class="form-container">
            <form id="login-form" enctype="multipart/form-data">
                <h1 class="title">Login</h1>
                <label for="email">Email:</label>
                <input type="text" name="email" class="box" id="email" placeholder="Enter your email" autocomplete="off">
                <label for="password">Password:</label>
                <input type="password" name="password" class="box" id="password" placeholder="Enter a password" autocomplete="new-password">
                <input type="submit" value="Login" id="submit" name="submit" class="btn">
                <p>Don't have an account? <a href="http://localhost/OnlineMusicStore/php/register-page.php">Register here!</a></p>
            </form>
        </section>
    </body>
</html>