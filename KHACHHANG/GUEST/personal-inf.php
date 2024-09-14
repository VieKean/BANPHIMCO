<!-- SESSION -->
<?php session_start();
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- css -->
        <link rel="stylesheet" href="../ASSETS/css/GUEST/personal-inf.css">
        <link rel="stylesheet" type="text/css" href="../ASSETS/css/base.css">
        <link rel="stylesheet" type="text/css" href="../ASSETS/css/reset.css">
        <link rel="stylesheet" type="text/css" href="../ASSETS/css/style.css">
        <link rel="stylesheet" type="text/css" href="../ASSETS/font/fontawesome/css/all.css">
        <link rel="stylesheet" href="../ASSETS/css/GUEST/inf.css">
    </head>

    <body>

    </body>

    </html>

    <!-- header -->
    <?php require_once 'personal-header.php'; ?>
    <!-- close -->






    <div class="wrapper-guest">
        <div class="nav-guest">
            <ul class="nav">
                <li><i class="fa-regular fa-address-card icon-profile" style="color: #000000;"></i> <span class="name-profile"><?php echo $_SESSION['username']; ?></span></li>

                <li><a href="personal-inf.php?page=./module/inf.php">Thông tin tài khoản</a></li>

                <li><a href="personal-inf.php?page=./module/update-inf.php">Cập nhật thông tin</a></li>

                <li><a href="personal-inf.php?page=./module/order.php">Đơn hàng</a></li>

                <li><a href="../LOGIN/LOGOUT.php">Đăng xuất</a></li>

            </ul>

        </div>

        <div class="content-inf">

            <?php if (isset($_GET['page'])) {
                $page = $_GET['page'];
                require $page;
            } else {
                require './module/inf.php';
            }
            ?>

        </div>



    </div>





    <!-- header -->
    <?php require_once 'personal-footer.php'; ?>
    <!-- close -->

<script src="./jvs/inf.js"></script>
    <!-- CLOSE SESSION -->
<?php } else {
    header("Location:../home.php");
} ?>