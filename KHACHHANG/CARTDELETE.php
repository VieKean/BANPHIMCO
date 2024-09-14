<?php
session_start();
require_once 'CONN.php';


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    //SELECT
    function select_KH($conn, $username)
    {
        $select_KH = "SELECT * FROM khachhang WHERE tendangnhap = '$username'";
        $result_KH = mysqli_query($conn, $select_KH);
        return $result_KH;
    }


    function select_GH($conn, $id_user)
    {
        $select_GH = "SELECT * FROM giohang WHERE makhachhang = '$id_user' ORDER BY magiohang DESC ";
        $result_GH = mysqli_query($conn, $select_GH);
        return $result_GH;
    }
    // Handle
    $select_KH = select_KH($conn, $username);
    $row_KH = mysqli_fetch_assoc($select_KH);
    $id_user = $row_KH['makhachhang']; //lay ma khach hang
    $select_GH = select_GH($conn, $id_user);  //lay thong tin san pham trong gio hang



?>
<?php
    //Handle delete product_cart
    if (isset($_GET['delete_id']) && isset($_GET['id_cart'])) {
        $id = $_GET['delete_id'];
        $id_GH = $_GET['id_cart'];
        $delete_row_GH = "DELETE FROM giohang WHERE magiohang = '$id_GH' AND makhachhang = '$id_user' AND masanpham = '$id'";
        $result_delete = mysqli_query($conn, $delete_row_GH);
        header('Location:CART.php?success=Xóa thành công');
    } else {
    }





?>
    
<?php } else {
    header("Location:home.php?page=./LOGIN/form-login.php");
} ?>