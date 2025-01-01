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
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $response = array();
        $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
        $select = "SELECT * FROM users WHERE email = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_execute($select_stmt, [$email]);
        $res = mysqli_stmt_get_result($select_stmt);
        if(mysqli_num_rows($res) == 0) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            if(isset($_FILES['ppicture']) && $_FILES['ppicture']['error'] == 0) {
                $filename_tmp_name = $_FILES['ppicture']['tmp_name'];
                $ppicture = uniqid().'_'.basename($_FILES['ppicture']['name']);
                $ppicture_folder = '../pictures/'.$ppicture;
                $muf = move_uploaded_file($filename_tmp_name, $ppicture_folder);
                if(!$muf){
                    $response['status'] = 'error';
                    $response['message'] = 'Failed to upload profile picture!';
                }
            }
            else $ppicture = 'default-profile-pic.png';
            mysqli_free_result($res);
            mysqli_stmt_close($select_stmt);
            $select = "SELECT MAX(id) FROM users";
            $select_stmt = mysqli_prepare($conn, $select);
            mysqli_stmt_execute($select_stmt);
            $res = mysqli_stmt_get_result($select_stmt);
            $row = mysqli_fetch_assoc($res);
            $max_id = $row['MAX(id)'];
            $id = $max_id + 1;
            $insert = "INSERT INTO users (id, username, email, password, profile_picture) VALUES (?, ?,?,?,?)";
            $insert_stmt = mysqli_prepare($conn, $insert);
            mysqli_stmt_bind_param($insert_stmt, 'issss', $id, $username, $email, $password, $ppicture);
            if(mysqli_stmt_execute($insert_stmt)) {
                $user_id = mysqli_insert_id($conn);
                //session_start();
                $_SESSION['user_id'] = 53;
                $response['status'] = 'success';
                $response['message'] = 'Registration successful!';
                $response['data'] = [
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'ppicture' => $ppicture,
                    'user_id' => $user_id
                ];
            }
            else {
                $response['status'] = 'error';
                $response['message'] = 'Error when inserting into database!';
            }
        }
        else{
            $response['status'] = 'error';
            $response['message'] = 'Email already exists!';
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
        <title>Register</title>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>
        <script type="text/javascript" src="../javascript/register-validation.js"></script>
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
        <section class="form-container">
            <form id="register-form" enctype="multipart/form-data">
                <h1 class="title">Register</h1>
                <label for="username">Username:</label>
                <input type="text" name="username" class="box" id="username" placeholder="Enter your username" autocomplete="off">
                <label for="email">Email:</label>
                <input type="text" name="email" class="box" id="email" placeholder="Enter your email" autocomplete="off">
                <label for="password">Password:</label>
                <input type="password" name="password" class="box" id="password" placeholder="Enter a password" autocomplete="new-password">
                <label for="cpass">Confirm Password:</label>
                <input type="password" name="cpass" class="box" id="cpass" placeholder="Confirm your password">
                <label for="ppicture">Profile Picture (jpg, jpeg or png): (Optional):</label>
                <input type="file" name="ppicture" id="ppicture" class="box">
                <input type="submit" value="Register" id="submit" name="submit" class="btn">
                <p>Already have an account? <a href="http://localhost/OnlineMusicStore/php/login-page.php">Login here!</a></p>
            </form>
        </section>
    </body>
</html>