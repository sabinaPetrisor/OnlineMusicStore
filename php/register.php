<?php
    include 'config.php';
    session_start();
    if($_SESSION['user_id'] == 53){
        //session_start();
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
                session_start();
                $_SESSION['user_id'] = $user_id;
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
    }
?>