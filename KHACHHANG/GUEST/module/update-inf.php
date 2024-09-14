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


    <form class="display-inf" method="post" action="FUNC-guest.php" enctype="multipart/form-data">
        <div class="img-profile">
            <img src="../ASSETS/img/IMG-GUEST/user-regular.svg" alt="">
        </div>

        <div class="inf1 shadow_box">
            <h3 class="text">THÔNG TIN ĐĂNG NHẬP</h3>
            <div class="username">Tên đăng nhập: <?php echo $row['tendangnhap'] ?></div>
            <div class="password">
                <span>Mât khẩu: <input type="password" name="new-password" value="<?php echo $row['matkhau'];?>"></span>

            </div>
        </div>

        <div class="inf2 shadow_box">
            <h3 class="text">THÔNG TIN CHUNG</h3>
            <div class="dsp-flex">
                <div class="fullname" style="width:300px">Họ và tên: <input style="height:30px;" type="text" value="<?php echo $row['hoten'] ?>" name="new-fullname"></div>
                <div class="gender" style="width:300px"> Giới tính:
                    <?php if ($row['gioitinh'] == 'Nam') { ?>
                        <label>Nam<input type="radio" name="new-gender" value="Nam" checked></label><br>
                        <label>Nữ<input type="radio" name="new-gender" value="Nũ"></label><br>
                        <label>Khác<input type="radio" name="new-gender" value="Khác"></label>
                    <?php } else if ($row['gioitinh'] == 'Nữ') { ?>
                        <label>Nam<input type="radio" name="new-gender" value="Nam"></label><br>
                        <label>Nữ<input type="radio" name="new-gender" value="Nũ" checked></label><br>
                        <label>Khác<input type="radio" name="new-gender" value="Khác"></label>
                    <?php } else { ?>
                        <label>Nam<input type="radio" name="new-gender" value="Nam"></label><br>
                        <label>Nữ<input type="radio" name="new-gender" value="Nũ"></label><br>
                        <label>Khác<input type="radio" name="new-gender" value="Khác" checked></label>
                    <?php } ?>


                </div>
            </div>
            <div class="dsp-flex">
                <div class="birthday" style="width:300px">Ngày sinh: <input type="date" name="new-birthday" value="<?php echo $row['ngaysinh'] ?>"></div>
                <div class="numberphone" style="width:300px">Số điện thoại: <input type="text" name="new-numberphone" value="<?php echo $row['sodienthoai'] ?>"></div>
            </div>
            <div class="address">Địa chỉ: <input style="width:500px; height: 30px" type="text" name="new-address" value="<?php echo $row['diachi'] ?>"></div>
            <div class="email">Email: <input style="width:300px;" type="text" name="new-email" value="<?php echo $row['email'] ?>"></div>
            <div class="create-date">Ngày tạo: <?php echo $row['ngaytao'] ?></div>

        </div>
        <div style="display: flex; justify-content: center;">
            <span class="infmation" style="width:500px"><?php if(isset($_GET['error'])) {echo('<p style="color:red;">'.$_GET['error'].'</p>');} 
                                                                else if(isset($_GET['success'])) {echo('<p style="color:green;">'.$_GET['success'].'</p>');}?></span>
            <span class="button-save" style="width:300px" ><button type="submit" name="btn-update">Lưu thay đổi</button></span>
        </div>














    </form>
























<?php
    //close check session
} else {
    header("Location:../../home.login");
}
?>