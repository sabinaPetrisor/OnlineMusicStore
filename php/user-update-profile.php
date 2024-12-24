<?php
    include 'config.php';
    session_start();
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $response = array();
        $response['message'] = '';
        $response['username_update_state'] = '';
        $response['email_update_state'] = '';
        $response['profile_pic_update_state'] = '';
        $response['password_update_state'] = '';
        $select = "SELECT * FROM users WHERE id = ?";
        $select_stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_bind_param($select_stmt, 'i', $user_id);
        mysqli_stmt_execute($select_stmt);
        $res = mysqli_stmt_get_result($select_stmt);
        $user = mysqli_fetch_assoc($res);
        $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
        if(!($username === $user['username']) && !empty($username)) {
            $update = "UPDATE users SET username = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($update_stmt, 'si', $username, $user_id);
            if(mysqli_stmt_execute($update_stmt)) {
                $response['username_update_state'] = 'success';
            }
            else {
                $response['username_update_state'] = 'error';
                $response['message'] = 'Error when updating username!';
            }
        }
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
        if(!($email === $user['email']) && !empty($email)) {
            $update = "UPDATE users SET email = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($update_stmt, 'si', $email, $user_id);
            if(mysqli_stmt_execute($update_stmt)) {
                $response['email_update_state'] = 'success';
            }
            else {
                $response['email_update_state'] = 'error';
                $response['message'] = 'Error when updating email!';
            }
        }
        if(isset($_FILES['ppicture']) && $_FILES['ppicture']['error'] == 0) {
            $filename = $_FILES['ppicture']['name'];
            $old_pic_name = $_POST['old_ppicture_hidden'];
            if(!($filename === $old_pic_name)) {
                $filename_tmp_name = $_FILES['ppicture']['tmp_name'];
                $ppicture = uniqid().'_'.basename($_FILES['ppicture']['name']);
                $ppicture_folder = '../pictures/'.$ppicture;
                $muf = move_uploaded_file($filename_tmp_name, $ppicture_folder);
                if(!$muf){
                    $response['profile_pic_update_state'] = 'error';
                    $response['message'] = 'Failed to upload profile picture!';
                }
                $update = "UPDATE users SET profile_picture = ? WHERE id = ?";
                $update_stmt = mysqli_prepare($conn, $update);
                mysqli_stmt_bind_param($update_stmt, 'si', $ppicture, $user_id);
                if(mysqli_stmt_execute($update_stmt)) {
                    $response['profile_pic_update_state'] = 'success';
                }
                else {
                    $response['profile_pic_update_state'] = 'error';
                    $response['message'] = 'Error when updating profile picture!';
                }
            }
        }
        $new_pass = $_POST['new_password'];
        if(!empty($new_pass)){
            $old_pass = $_POST['old_password_hidden'];
            if(!password_verify($new_pass, $old_pass)) {
                $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                $update = "UPDATE users SET password = ? WHERE id = ?";
                $update_stmt = mysqli_prepare($conn, $update);
                mysqli_stmt_bind_param($update_stmt, 'si', $new_pass, $user_id);
                if(mysqli_stmt_execute($update_stmt)) {
                    $response['password_update_state'] = 'success';
                }
                else {
                    $response['password_update_state'] = 'error';
                    $response['message'] = 'Error when updating password!';
                }
            }
            else {
                $response['password_update_state'] = 'error';
                $response['message'] = 'You provided the old password as the new password! These must be different!';
            }
        }
        if(empty($response['message']) && ($response['username_update_state'] === 'success' || $response['email_update_state'] === 'success' || $response['profile_pic_update_state'] === 'success' || $response['password_update_state'] === 'success')) {
            $response['overall_status'] = 'success';
            $response['message'] = 'Admin Profile Update Sucessful!';
            $response['data'] = [
                'user_id' => $user_id
            ];
        }
        else if(empty($response['message']) && empty($response['username_update_state']) && empty($response['email_update_state']) && empty($response['profile_pic_update_state']) && empty($response['password_update_state'])) {
            $response['overall_status'] = 'success';
            $response['data'] = [
                'user_id' => $user_id
            ];
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
        <title>Update Admin Profile</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>
        <script type="text/javascript" src="../javascript/update-user.js"></script>
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
        <?php include 'header-logged-in.php';?>
        <script type="text/javascript" src="../javascript/dropdown-menu.js"></script>
        <h1 class="title">Update Profile</h1>
        <section class="update-profile">
            <form id="update-form" enctype="multipart/form-data">
                <?php 
                    $select = "SELECT * FROM users WHERE id = ?";
                    $select_stmt = mysqli_prepare($conn, $select);
                    mysqli_stmt_bind_param($select_stmt, 'i', $user_id);
                    mysqli_stmt_execute($select_stmt);
                    $res = mysqli_stmt_get_result($select_stmt);
                    $user = mysqli_fetch_assoc($res);
                ?>
                <img src="../pictures/<?php echo $user['profile_picture']; ?>" alt="">
                <div class="input-box-container">
                    <div class="input-box">
                        <label for="username">Username:</label>
                        <input type="text" name="username" class="box" id="username" placeholder="Update username" value="<?php echo $user['username']; ?>">
                        <label for="email">Email:</label>
                        <input type="text" name="email" class="box" id="email" placeholder="Enter your email" value="<?php echo $user['email']; ?>">
                        <label for="ppicture">Profile Picture (jpg, jpeg or png):</label>
                        <input type="file" name="ppicture" id="ppicture" class="box">
                        <input type="hidden" name="old_ppicture_hidden" value="<?php echo $user['profile_picture'];?>">
                    </div>
                    <div class="input-box">
                        <input type="hidden" name="old_password_hidden" value="<?php echo $user['password'];?>">
                        <!--<label for="old_password">Old Password:</label>
                        <input type="password" name="old_password" class="box" id="old_password" placeholder="Enter your old password" autocomplete="new-password">-->
                        <label for="new_password">New Password:</label>
                        <input type="password" name="new_password" class="box" id="new_password" placeholder="Enter your new password">
                        <label for="new_password_confirm">Confirm New Password:</label>
                        <input type="password" name="new_password_confirm" class="box" id="new_password_confirm" placeholder="Confirm your new password">
                    </div>
                </div>
                <input type="submit" value="Update Profile" id="submit" name="submit" class="btn">
            </form>
        </section>
    </body>
</html>