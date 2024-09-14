<?php session_start();
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
        $select_GH = "SELECT * FROM giohang WHERE makhachhang = '$id_user' ";
        $result_GH = mysqli_query($conn, $select_GH);
        return $result_GH;
    }
    // Handle
    if (isset($_POST['update-quantify'])) {
        $select_KH = select_KH($conn, $username);
        $row_KH = mysqli_fetch_assoc($select_KH);
        $id_user = $row_KH['makhachhang']; //lay ma khach hang

        $select_GH = select_GH($conn, $id_user);  //lay thong tin san pham trong gio hang


        $quantify = $_POST['quantify'];
        print_r($quantify);
    } else if (isset($_POST['btn-buycart'])) {
        if (!empty($_POST['input-total-price'])) {
            $totalPrice = $_POST['input-total-price'];
            $totalQuantity = $_POST['input-total-quantify'];

            $id_cart = $_POST['id_cart'];
            $quantify = $_POST['quantify'];
            $count_id_cart = count($id_cart);

            for ($i = 0; $i < $count_id_cart; $i++) {
                $get_quantify = $quantify[$i];
                $get_id_cart = $id_cart[$i];



                $update_GH = "UPDATE giohang SET soluong = $get_quantify WHERE magiohang = '$get_id_cart'";
                $result_update_GH = mysqli_query($conn, $update_GH);
            }

            header('Location:home-login.php?page=./GUEST/module/buyprd.php&totalquantify=' . $totalQuantity . '&totalprice=' . $totalPrice . '');
        }
        else{
            header("Location:CART.php?erorr=Không có sản phẩm nào");
        }
    }








?>















<?php } else {
    header("Location:home.php?page=./LOGIN/form-login.php");
} ?>