<?php require_once '../CONN.php';
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // select khach hang
    $select_kh = "SELECT * FROM khachhang WHERE tendangnhap = '$username'";
    $result_kh = mysqli_query($conn, $select_kh);
    $row_kh = mysqli_fetch_assoc($result_kh);
    $id_user = $row_kh['makhachhang'];



    //select donhang
    $select_DH = "SELECT * FROM donhang WHERE makhachhang='$id_user' ORDER BY madonhang DESC";
    $result_DH = mysqli_query($conn, $select_DH);
    $num_rows_DH = mysqli_num_rows($result_DH);//so luong don hang

    $order_dsp = 5; //so don hang muon hien thi
    $total = ceil($num_rows_DH / $order_dsp); //tong so nut page hien thi

    if (isset($_GET['btn-page'])) {
        $btn_page = $_GET['btn-page'];
    } else {
        $btn_page = 1;
    }
    $getlocation = ($btn_page - 1) * $order_dsp; // lay vi tri cua san pham

    $getlimit = "SELECT * FROM donhang WHERE makhachhang='$id_user' ORDER BY madonhang DESC LIMIT $getlocation, $order_dsp"; //lay san pham bat dau tu $getlocation va lay ra $prd-dsp san pham
    $result_limit_order = mysqli_query($conn, $getlimit);
    
    $get_nameuser = "SELECT hoten FROM donhang,khachhang WHERE donhang.makhachhang = khachhang.makhachhang AND khachhang.makhachhang = '$id_user' ";
    $result_nameuser = mysqli_query($conn, $get_nameuser);
    $row_nameuser = mysqli_fetch_assoc($result_nameuser);
    if(isset($row_nameuser['hoten'])){
    $fullname = $row_nameuser['hoten'];};











?>
    <link rel="stylesheet" href="../ASSETS/css/GUEST/order.css">

    <table class="table-cart">

        <thead class="table-cart-header">
            <tr>
                <th>Khách hàng</th>
                <th>Mã đơn hàng</th>
                <th>Ngày đặt</th>
                <th>Phương thức</th>
                <th>Số lượng</th>
                <th>Tổng giá</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody class="table-cart-body">
            <?php
            while ($row_DH = mysqli_fetch_assoc($result_limit_order)) {
            ?>
                <tr>
                    <td><?php echo $fullname; ?></td>
                    <td><a href="personal-inf.php?page=./module/orderdetails.php&MDH=<?php echo $row_DH['madonhang']; ?>"><?php echo $row_DH['madonhang']; ?></a></td>
                    <td> <?php echo $row_DH['ngaydathang']; ?> </td>
                    <td> <?php echo $row_DH['phuongthucthanhtoan']; ?> </td>
                    <td> <?php echo $row_DH['tongsanpham']; ?> </td>
                    <td> <?php echo number_format($row_DH['tonggia']) .'<span style="font-size: 8px"> VNĐ</span>'; ?> </td>
                    <td> <?php echo $row_DH['trangthai']; ?> </td>
                </tr>
            <?php }  ?>
        </tbody>
    </table>
    <?php echo ('<div class="btn-page">');
    for ($btn = 1; $btn <= $total; $btn++) {
        echo ('<a href="personal-inf.php?page=./module/order.php&btn-page=' . $btn . '"">' . $btn . '</a>');
    };
    echo ('</div>');
    ?>




<?php } else {
    header("Location:../LOGIN/form-login.php");
} ?>