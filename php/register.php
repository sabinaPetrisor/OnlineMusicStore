<?php
    include 'config.php';
    $response = array();
    $data = json_decode($_POST['data'], true);
    $username = htmlspecialchars($data['username'], ENT_QUOTES);
    $email = htmlspecialchars($data['email'], ENT_QUOTES);
    $select = sqlsrv_query($conn, "SELECT * FROM users WHERE email = ?", [$email]);
    if(!sqlsrv_has_rows($select)){
        $password = password_hash(htmlspecialchars($data['password'], ENT_QUOTES), PASSWORD_DEFAULT);
        $ppicture = $data['ppicture'];
        //echo 'ppicture = '.$ppicture.'<br>';
        if(strcmp($ppicture, 'default-profile-pic.png') != 0) {
            //echo 'Am gasit o imagine!<br>';
            //$filename = $_FILES['ppicture']['name'];
            $filename_tmp_name = sys_get_temp_dir();
            $ppicture = uniqid(). '_' . basename($ppicture);
            //echo 'Noul nume al imaginii este: '.$ppicture_tmp_name.'<br>';
            $ppicture_folder = '../pictures/'.$ppicture;
            if(!move_uploaded_file($filename_tmp_name, $ppicture_folder)){
                $response['status'] = 'error';
                $response['message'] = 'Failed to upload profile picture!';
                $response['data'] = [];
            }
        }
        $response['status'] = 'success';
        $response['message'] = 'Registration successful!';
        $response['data'] = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'profile_picture' => $ppicture
        ];
        $insert = sqlsrv_query($conn, "INSERT INTO users (username, email, password, profile_picture) VALUES (?, ?, ?, ?)", [$username, $email, $password, $ppicture]);
        sqlsrv_execute($insert);
    }
    else{
        $response['status'] = 'error';
        $response['message'] = 'Email already exists!';
        $response['data'] = [];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>