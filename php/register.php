<?php
    include 'config.php';
    /*$val = isset($_POST['submit']);
    $response['isset'] = $val;
    if(isset($_POST['submit'])){*/
    $response = array();
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
    $password = password_hash(htmlspecialchars($_POST['password'], ENT_QUOTES), PASSWORD_DEFAULT);
    /*$cpassword = md5(htmlspecialchars($_POST['cpass'], ENT_QUOTES));*/
    /*$ppicture = $_FILES['profile_picture']['name'];*/
    if(empty($_FILES['ppicture'])) {
        $ppicture = '';
        $response['status'] = 'success';
        $response['message'] = 'Registration successful!';
        $response['data'] = array(
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'profile_picture' => ''
        );
    }
    else {
        $ppicture = $_FILES['ppicture']['name'];
        $ppicture_size = $_FILES['ppicture']['size'];
        $ppicture_tmp_name = $_FILES['ppicture']['tmp_name'];
        $new_filename = uniqid(). '_' . basename($ppicture);
        //echo 'Noul nume al imaginii este: '.$ppicture_tmp_name.'<br>';
        echo 'Numele imaginii este: '.$ppicture.'<br>';
        $ppicture_folder = '../pictures/'.$new_filename;
        if(move_uploaded_file($ppicture_tmp_name, $ppicture_folder)){

            $response['status'] = 'success';
            $response['message'] = 'Registration successful!';
            $response['data'] = array(
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'profile_picture' => $new_filename
            );
        }
        else{
            $response['status'] = 'error';
            $response['message'] = 'Failed to upload profile picture!';
        }
    }
    $select = sqlsrv_query($conn, "SELECT * FROM users WHERE email = ?", [$email]);
    /*$select = sqlsrv_execute($select);*/
    
    if(!sqlsrv_has_rows($select)){
        $insert = sqlsrv_query($conn, "INSERT INTO users (name, email, password, profile_picture) VALUES (?, ?, ?, ?)", [$username, $email, $password, $ppicture]);
        sqlsrv_execute($insert);
        /*if(strcmp($ppicture, 'default-profile-pic.png') != 0) {
            if(move_uploaded_file($ppicture_tmp_name, $ppicture_folder)){

                $response['status'] = 'success';
                $response['message'] = 'Registration successful!';
                $response['data'] = array(
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'profile_picture' => $new_filename
                );
            }
            else{
                $response['status'] = 'error';
                $response['message'] = 'Failed to upload profile picture!';
            }
        }*/
    }
    else{
        $response['status'] = 'error';
        $response['message'] = 'Email already exists!';
    }
/*}
else{
    $response['status'] = 'error';
    $response['message'] = 'Failed form submission!';
}*/
    echo json_encode($response);
?>