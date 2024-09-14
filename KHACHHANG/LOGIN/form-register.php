
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form SignUp</title>
    <link rel="stylesheet" href="../ASSETS/css/LOGIN/form-register.css">
    <link rel="stylesheet" href="../ASSETS/css/reset.css">
    <link rel="stylesheet" href="../ASSETS/font//fontawesome/css/all.min.css">
</head>

<body>

    <div class="signUp">
        <h1 class="signUp-title">
            ĐĂNG KÍ TÀI KHOẢN
        </h1>
        <span class="error" <?php if (isset($_GET['success'])) {
                                            echo ('style="color:green;"');
                                        } else {
                                            echo ('style="color:red"');
                                        } //close?>><?php if (isset($_GET['error'])) {
                                                    echo $_GET['error'];
                                                } else if (isset($_GET['success'])) {
                                                    echo $_GET['success'];
                                                } ?></span>
        <form class="form-signUp" action="FUNC-login.php" method="post" enctype="multipart/form-data">
            <label class="form-signUp_label">Họ tên</label>
            <input type="text" class="form-signUp_input" name="fullname" >
            <label class="form-signUp_label">Tài khoản</label>
            <input type="text" class="form-signUp_input" name="username">
            <label class="form-signUp_label">Số điện thoại</label>
            <input type="text" class="form-signUp_input" name="numberphone">
            <label class="form-signUp_label">Mật khẩu </label>
            <input type="password" class="form-signUp_input" name="password">
            <label class="form-signUp_label">Xác nhận mật khẩu </label>
            <input type="password" class="form-signUp_input" name="conf-pass">
            <label class="form-signUp_label">Email</label>
            <input type="email" class="form-signUp_input" name="email">

            <button class="signUp-btn" name="btn-register" type="submit">ĐĂNG KÍ</button>
        </form>

        <div class="return" style="margin-top:15px;"><a style="text-decoration: underline; color:blue;" href="form-login.php">Đăng nhập</a></div>

    </div>

</body>

</html>