<!-- SESSION -->
<?php
if (isset($_SESSION['username'])) {

    $username = $_SESSION['username'];
    // select khach hang
    $select_kh = "SELECT * FROM khachhang WHERE tendangnhap = '$username'";
    $result_kh = mysqli_query($conn, $select_kh);
    $row_kh = mysqli_fetch_assoc($result_kh);
    $id_user = $row_kh['makhachhang'];

    //select giogiohang
    $select_GH = "SELECT * FROM giohang WHERE makhachhang ='$id_user' ORDER BY magiohang DESC";
    $result_GH = mysqli_query($conn, $select_GH);
    $num_rows_GH = mysqli_num_rows($result_GH);

    $prd_dsp = 5; //so san pham muon hien thi
    $total = ceil($num_rows_GH / $prd_dsp); //tong so nut page hien thi

    if (isset($_GET['btn-page'])) {
        $btn_page = $_GET['btn-page'];
    } else {
        $btn_page = 1;
    }
    $getlocation = ($btn_page - 1) * $prd_dsp; // lay vi tri cua san pham
    $getlimit = "SELECT * FROM giohang WHERE makhachhang='$id_user' ORDER BY magiohang DESC LIMIT $getlocation, $prd_dsp"; //lay san pham bat dau tu $getlocation va lay ra $prd-dsp san pham
    $result_limit_buyprd = mysqli_query($conn, $getlimit);


    // Mua sản phẩm trực tiếp
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $select_sp = "SELECT * FROM sanpham WHERE masanpham = '$id'";
        $result_sp = mysqli_query($conn, $select_sp);
        $row_sp = mysqli_fetch_assoc($result_sp);

?>
        <div class="main-buyprd">
            <div class="error" style="color: red;"><?php if (isset($_GET['error'])) {
                                                        echo $_GET['error'];
                                                    } ?></div>
            <form class="flex-form" action="./GUEST/FUNC-guest.php?id_user=<?php echo $row_kh['makhachhang'] ?>&id=<?php if (isset($_GET['id'])) {
                                                                                                                        echo $_GET['id'];
                                                                                                                    }; ?>" method="post" enctype="multipart/form-data">
                <div class="form-buyprd">
                    <div class="row1">
                        <label for="fullname">Họ tên: <input type="text" name="fullname" value="<?php echo $row_kh['hoten']; ?>" required></label>
                        <label for="numberphone">Số điện thoại: <input type="text" name="numberphone" value="<?php echo $row_kh['sodienthoai']; ?>" required placeholder=""></label>
                    </div>
                    <div class="row2"><label for="email">Email: <input type="email" name="email" value="<?php echo $row_kh['email']; ?>"></label></div>
                    <div class="row3"><label for="address">Địa chỉ: <input type="text" name="address" <?php if (!empty($row_kh['diachi'])) {
                                                                                                            echo ('value="' . $row_kh['diachi'] . '"');
                                                                                                        } else {
                                                                                                            echo ('placeholder="Bạn có thể cập nhật địa chỉ trong tài khoản"');
                                                                                                        } ?> required></label></div>
                    <div class="payment-methods row4">
                        <label>Thanh toán khi nhận hàng <input type="radio" name="method" value="Thanh toán khi nhận hàng" checked></label>
                        <label>Thanh toán chuyển khoản <input type="radio" name="method" value="Thanh toán chuyển khoản"></label>
                    </div>


                    <div class="btn-payment">
                        <button type="submit" name="btn-payment">Thanh toán</button>
                    </div>
                </div>






                <div class="form-prd" >
                    <div class="name-prd">
                        <?php echo $row_sp['tensanpham']; ?>
                    </div>
                    <div class="pict">
                        <img src="../QUANLI/ASSETS/img/IMG-Product/<?php echo $row_sp['hinhanh'] ?>" alt="">
                    </div>
                    <div class="flex">
                        <div class="quantify">
                            <span class="reduce">-</span>
                            <span class="num"><input type="number" style="width: 30px;" name="quantify" id="input-num" class="no-spin" value="1"></span>
                            <span class="increase">+</span>
                        </div>
                        <span class="price-prd">Giá:
                            <span id="price"><?php echo $row_sp['gia'];?></span>
    
                        </span>
                        <span style="font-size: 14px"> VNĐ</span>
                    </div>
                </div>
            </form>
        </div>
    <?php }



    //Mua sản phẩm trong giỏ hàng
    else if (isset($_GET['totalquantify']) && isset($_GET['totalprice'])) {
        $totalquantify = $_GET['totalquantify'];
        $totalprice = $_GET['totalprice'];
    ?>

        <div class="main-buyprd">
            <div class="error" style="color: red;"><?php if (isset($_GET['error'])) {
                                                        echo $_GET['error'];
                                                    } ?></div>
            <form class="flex-form" action="./GUEST/FUNC-guest.php?id_user=<?php echo $row_kh['makhachhang'] ?>&totalprice=<?php echo $_GET['totalprice'] ?>&totalquantify=<?php echo $_GET['totalquantify']; ?>" method="post" enctype="multipart/form-data">
                <div class="form-buyprd">
                    <div class="row1">
                        <label for="fullname">Họ tên: <input type="text" name="fullname" value="<?php echo $row_kh['hoten']; ?>" required></label>
                        <label for="numberphone">Số điện thoại: <input type="text" name="numberphone" value="<?php echo $row_kh['sodienthoai']; ?>" required placeholder=""></label>
                    </div>
                    <div class="row2"><label for="email">Email: <input type="email" name="email" value="<?php echo $row_kh['email']; ?>"></label></div>
                    <div class="row3"><label for="address">Địa chỉ: <input type="text" name="address" <?php if (!empty($row_kh['diachi'])) {
                                                                                                            echo ('value="' . $row_kh['diachi'] . '"');
                                                                                                        } else {
                                                                                                            echo ('placeholder="Bạn có thể cập nhật địa chỉ trong tài khoản"');
                                                                                                        } ?> required></label></div>
                    <div class="payment-methods row4">
                        <label>Thanh toán khi nhận hàng <input type="radio" name="method" value="Thanh toán khi nhận hàng" checked></label>
                        <label>Thanh toán chuyển khoản <input type="radio" name="method" value="Thanh toán chuyển khoản"></label>
                    </div>


                    <div class="btn-payment">
                        <button type="submit" name="btn-payment-cart">Thanh toán</button>
                    </div>

                    <div class="total">
                        <p>Tổng số tiền: <?php echo number_format($totalprice); ?></p>
                        <p>Tổng số lượng: <?php echo $totalquantify; ?></p>
                    </div>
                </div>






                <table class="table-cart">

                    <thead class="table-cart-header">
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Mã sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody class="table-cart-body">
                        <?php
                        while ($row_GH = mysqli_fetch_assoc($result_limit_buyprd)) {
                            $gia = $row_GH['soluong'] * $row_GH['gia'];
                            $id = $row_GH['masanpham'];
                            $select_SP = "SELECT * FROM sanpham WHERE masanpham = '$id'";
                            $result_SP = mysqli_query($conn, $select_SP);
                            $row_SP = mysqli_fetch_assoc($result_SP);
                        ?>
                            <tr>
                                <td><img src="../QUANLI/ASSETS/img/IMG-Product/<?php echo $row_SP['hinhanh']; ?>" alt=""></td>
                                <td><a href="detailproduct/index.php?id=<?php echo $row_GH['masanpham']; ?>"><?php echo $row_GH['masanpham']; ?></a></td>
                                <td> <?php echo $row_GH['soluong']; ?> </td>
                                <td><?php echo number_format($gia); ?></td>
                            </tr>
                        <?php }  ?>
                    </tbody>
                </table>

            </form>
        </div>


        <?php echo ('<div class="btn-page">');
        for ($btn = 1; $btn <= $total; $btn++) {
            echo ('<a href="home-login.php?page=./GUEST/module/buyprd.php&totalquantify='.$totalquantify.'&totalprice='.$totalprice.'&btn-page=' . $btn . '"">' . $btn . '</a>');
        };
        echo ('</div>');
        ?>



    <?php } ?>










    <script src="./GUEST/js/handle.js"></script>
    <!-- CLOSE SESSION -->
<?php } else {
    header("Location:../../LOGIN/form-login.php?error-login=Bạn chưa đăng nhập");
} ?>