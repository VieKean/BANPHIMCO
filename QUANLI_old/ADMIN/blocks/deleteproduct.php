






<?php
require '../../FUNC/conn.php';

if (isset($_POST['del'])) {
    $id = $_GET['id'];
    $select_SP = "SELECT * FROM chitietdonhang WHERE masanpham = '$id'";
    $result_SP = mysqli_query($conn, $select_SP);
    $num_SP = mysqli_num_rows($result_SP);
    if ($num_SP < 1) {
        $sql = "DELETE FROM sanpham WHERE masanpham = '$id'";
        if (mysqli_query($conn, $sql)) {
            header("Location:../index.php?page=dssanpham");
        } else {
            echo '<script>alert("Lỗi: ' . mysqli_error($conn) . '");</script>';
        }
        
    }
    else{
        header("Location:../index.php?page=dssanpham&error=Sản phẩm này đang có trong đơn hàng");
    }
    
}


?>