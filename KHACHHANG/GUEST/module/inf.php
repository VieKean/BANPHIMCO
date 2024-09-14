<?php
// check session
if (isset($_SESSION['username'])) {  ?>
    <?php
    //conn
    require_once '../CONN.php';
    //close conn
    $username = $_SESSION['username'];
    $select = "SELECT * FROM khachhang WHERE tendangnhap = '$username'";
    $result = mysqli_query($conn, $select);
    $row = mysqli_fetch_assoc($result);
    ?>


    <form class="display-inf">
        <div class="img-profile">
            <img src="../ASSETS/img/IMG-GUEST/user-regular.svg" alt="">
        </div>

        <div class="inf1 shadow_box">
            <h3 class="text">THÔNG TIN ĐĂNG NHẬP</h3>
            <div class="username">Tên đăng nhập: <?php echo $row['tendangnhap'] ?></div>
            <div class="password">
                <span>Mât khẩu: *********** </span>
            </div>
        </div>

        <div class="inf2 shadow_box">
            <h3 class="text">THÔNG TIN CHUNG</h3>
            <div class="dsp-flex">
                <div class="fullname" style="width:300px">Họ và tên: <?php echo $row['hoten'] ?></div>
                <div class="gender" style="width:300px"> Giới tính:
                    <?php echo $row['gioitinh']; ?>
                </div>
            </div>
            <div class="dsp-flex">
                <div class="birthday" style="width:300px">Ngày sinh: <?php echo $row['ngaysinh'] ?></div>
                <div class="numberphone" style="width:300px">Số điện thoải: <?php echo $row['sodienthoai'] ?></div>
            </div>
            <div class="address">Địa chỉ: <?php echo $row['diachi'] ?></div>
            <div class="email">Email: <?php echo $row['email'] ?></div>
            <div class="create-date">Ngày tạo: <?php echo $row['ngaytao'] ?></div>

        </div>
    </form>
























<?php
    //close check session
} else {
    header("Location:../../home.login");
}
?>