<?php
    include 'config.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Admin Profile</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
        <?php include 'admin-header.php';?>
        <script type="text/javascript" src="../javascript/dropdown-menu.js"></script>
        <h1 class="title">Update Profile</h1>
        <section class="update-profile">
            <form enctype="multipart/form-data">
                <?php 
                    $select = "SELECT * FROM users WHERE id = ?";
                    $select_stmt = mysqli_prepare($conn, $select);
                    mysqli_stmt_bind_param($select_stmt, 'i', $admin_id);
                    mysqli_stmt_execute($select_stmt);
                    $res = mysqli_stmt_get_result($select_stmt);
                    $user = mysqli_fetch_assoc($res);
                ?>
                <img src="../pictures/<?php echo $user['profile_picture']; ?>" alt="">
                <div class="input-box">
                    <label for="username">Username:</label>
                    <input type="text" name="username" class="box" id="username" placeholder="Update username" value="<?php echo $user['username']; ?>">
                    <label for="email">Email:</label>
                    <input type="text" name="email" class="box" id="email" placeholder="Enter your email" value="<?php echo $user['email']; ?>">
                    <label for="ppicture">Profile Picture (in format jpg, jpeg or png):</label>
                    <input type="file" name="ppicture" id="ppicture" class="box">
                    <input type="hidden" name="old_ppicture_hidden" value="<?php echo $user['profile_picture'];?>">
                </div>
                <div class="input-box">
                    <input type="hidden" name="old_password_hidden" value="<?php echo $user['password'];?>">
                    <label for="old_password">Old Password:</label>
                    <input type="password" name="old_password" class="box" id="old_password" placeholder="Enter your old password" autocomplete="new-password">
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" class="box" id="new_password" placeholder="Enter your new password">
                    <label for="new_password_confirm">Confirm New Password:</label>
                    <input type="password" name="new_password_confirm" class="box" id="new_password_confirm" placeholder="Confirm your new password">
                </div>
                <!--<input type="submit" value="Register" id="submit" name="submit" class="btn"> -->
            </form>
        </section>
    </body>
</html>