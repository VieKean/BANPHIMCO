<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../ASSETS/css/LOGIN/form-login.css">
    <link rel="stylesheet" href="../ASSETS/css/reset.css">
    <link rel="stylesheet" href="../ASSETS/font//fontawesome/css/all.min.css">
</head>

<body>
    <!-- login header -->
    <form action="FUNC-login.php" method="post" enctype="multipart/form-data">
        <div class="login">
            <div class="login-container">
                <div class="close-form">
                    <span style="color: red;"><?php if(isset($_GET['error-login'])){echo $_GET['error-login'];} ?></span>
                    <span><a href="../home.php">Trang chủ</a></span>
                </div>
                <div class="login-input login-user">
                    <input type="text" placeholder="Tên đăng nhập" name="username" class="login-input-placeholder" value="<?php if(isset($_GET['username'])){echo $_GET['username'];} ?>" >
                </div>
                <div class="login-input login-password">
                    <input type="password" placeholder="Mật khẩu" name="password" class="login-input-placeholder" >
                    
                </div>
                <div class="forget-password">
                    <a href="#">Quên mật khẩu?</a>
                </div>
                <div class="btn-flex">
                    <button class="login-button" name="btn-login" type="submit">
                        <span class="login-button_text">Đăng nhập</span>
                    </button>
                </div>
                <div class="margin-t10px">
                    <input type="checkbox" value="remember-acc" name="remember-acc">
                    <label for="remember-acc" style="color: #fff;">Nhớ tài khoản</label>
                </div>

                <div class="register-acc">
                    <a href="form-register.php">TẠO TÀI KHOẢN?</a>
                </div>

            </div>
        </div>
    </form>
    <!-- end login header -->
</body>

</html>