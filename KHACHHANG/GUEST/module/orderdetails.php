<?php require_once '../CONN.php';
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $id_order = $_GET['MDH'];
    // select khach hang
    $select_kh = "SELECT * FROM khachhang WHERE tendangnhap = '$username'";
    $result_kh = mysqli_query($conn, $select_kh);
    $row_kh = mysqli_fetch_assoc($result_kh);
    $id_user = $row_kh['makhachhang'];


    //select chitietdon
    $select_CTDH = "SELECT * FROM chitietdonhang WHERE madonhang = '$id_order'";
    $result_CTDH = mysqli_query($conn, $select_CTDH);
    $num_rows_CTDH = mysqli_num_rows($result_CTDH);

    $orderdetails_dsp = 4; //so don hang muon hien thi
    $total = ceil($num_rows_CTDH / $orderdetails_dsp); //tong so nut page hien thi

    if (isset($_GET['btn-page'])) {
        $btn_page = $_GET['btn-page'];
    } else {
        $btn_page = 1;
    }
    $getlocation = ($btn_page - 1) * $orderdetails_dsp; // lay vi tri cua san pham

    $sql_CTDH_limit = "SELECT * FROM chitietdonhang WHERE madonhang = '$id_order' LIMIT $getlocation, $orderdetails_dsp";
    $result_CTDH_limit = mysqli_query($conn, $sql_CTDH_limit);
    $num = mysqli_num_rows($result_CTDH_limit);


    $sql_all = "SELECT ctd.madonhang, kh.hoten, kh.email, kh.ngaysinh, kh.gioitinh, kh.sodienthoai, kh.diachi, sp.tensanpham,ctd.soluong,dh.tonggia,dh.phuongthucthanhtoan,dh.trangthai FROM chitietdonhang ctd, khachhang kh, donhang dh, sanpham sp 
    WHERE ctd.madonhang = dh.madonhang
    AND ctd.masanpham = sp.masanpham
    AND dh.makhachhang = kh.makhachhang AND ctd.madonhang = '$id_order'";

    $result_all = mysqli_query($conn, $sql_all);

    $row_all = mysqli_fetch_array($result_all);






?>
    <link rel="stylesheet" href="../ASSETS/css/GUEST/order.css">
    <style>
        .header-ordertails {
            margin: 20px 50px 0 50px;
            box-shadow: rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset;
        }
        .header-inf p{
            padding-top: 10px;
            margin: 10px;
            font-size: 20px;
        }
        .header-inf > div{
            margin: 30px;
        }
        .inf-text1{
            display: flex;

        }
        .inf-text1 > div{
            margin-right: 50px;
        }
    </style>


    <div style="height: 300px;" class="header-ordertails">
        <div class="header-inf">
            <p>THÔNG TIN KHÁCH HÀNG</p>
            <div class="inf-text1">
                <div class="fullname">Họ tên: <?php echo $row_all['hoten']; ?></div>
                <div class="address">Giới tính: <?php echo $row_all['gioitinh']; ?></div>
                <div class="address">Ngày sinh: <?php echo $row_all['ngaysinh']; ?></div>
            </div>
            <div class="numberphone">Số điện thoại: <?php echo $row_all['sodienthoai']; ?></div>
            <div class="address">Địa chỉ: <?php echo $row_all['diachi']; ?></div>
            <div class="address">Email: <?php echo $row_all['email']; ?></div>

        </div>

    </div>


    <table class="table-cart" style="height: 100px">
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
            while ($row_CTDH = mysqli_fetch_assoc($result_CTDH_limit)) {
                $id_sp = $row_CTDH['masanpham']; //id san pham

                $select_SP = "SELECT * FROM sanpham WHERE masanpham = '$id_sp'";
                $result_SP = mysqli_query($conn, $select_SP);
                $row_SP = mysqli_fetch_assoc($result_SP);

                $picture = $row_SP['hinhanh'];
                $quantify = $row_CTDH['soluong'];
                $nameproduct = $row_SP['tensanpham'];
                $price = $row_SP['gia'] * $quantify;
            ?>
                <tr>
                    <td style="padding: 5px;"><img style="width:100px; height:50px;" src="../../QUANLI/ASSETS/img/IMG-Product/<?php echo $row_SP['hinhanh'] ?>" alt=""></td>
                    <td style="padding: 5px;"> <a href="../detailproduct/index.php?id=<?php echo $row_CTDH['masanpham']; ?>"><?php echo $row_CTDH['masanpham']; ?></a> </td>
                    <td style="padding: 5px;"><?php echo  $quantify ?></td>
                    <td style="padding: 5px;"><?php echo  number_format($price) .'<span style="font-size: 8px"> VNĐ</span>' ?></td>
                </tr>
            <?php }  ?>
        </tbody>
    </table>






    <?php echo ('<div class="btn-page">');
    for ($btn = 1; $btn <= $total; $btn++) {
        echo ('<a href="personal-inf.php?page=./module/orderdetails.php&MDH=' . $id_order . '&btn-page=' . $btn . '"">' . $btn . '</a>');
    };
    echo ('</div>');
    ?>




<?php } else {
    header("Location:../LOGIN/form-login.php");
} ?>