<?php
session_start();
require_once 'CONN.php';


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    //Function SQL
    // SELECT
    function select_sp($conn, $id)
    {
        $select_SP = "SELECT * FROM sanpham WHERE masanpham = '$id'";
        $result_SP = mysqli_query($conn, $select_SP);
        return $result_SP;
    }

    function select_KH($conn, $username)
    { {
            $select_KH = "SELECT * FROM khachhang WHERE tendangnhap = '$username'";
            $result_KH = mysqli_query($conn, $select_KH);
            return $result_KH;
        }
    }

    // INSERT
    function insert_cart($conn, $id_user, $id, $quantify, $price, $picture)
    {
        $insert_cart = "INSERT INTO giohang(makhachhang, masanpham, soluong, gia, hinhanh)
                        VALUES ('$id_user', '$id', $quantify, '$price', '$picture')";
        $result_cart = mysqli_query($conn, $insert_cart);
        return $result_cart;
    }
    //CLOSE Function




    //ADD product in cart
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $select_SP = select_sp($conn, $id);
        $row_SP = mysqli_fetch_assoc($select_SP);

        //lay id khach hang
        $select_KH = select_KH($conn, $username);
        $row_KH = mysqli_fetch_assoc($select_KH);
        $id_user = $row_KH['makhachhang'];

        //lay thong tin san pham
        $picture = $row_SP['hinhanh'];
        $price = $row_SP['gia'];





        //kiểm tra sản phẩm có trong giỏ chưa
        $select_id_GH = "SELECT * FROM giohang WHERE masanpham = '$id' AND makhachhang ='$id_user'";
        $result_id_GH = mysqli_query($conn, $select_id_GH);
        $num_id_GH = mysqli_num_rows($result_id_GH);
        $row_id_GH = mysqli_fetch_assoc($result_id_GH);
        if ($num_id_GH < 1) { //them san pham vao cart
            $quantify = 1;
            $insert_cart = insert_cart($conn, $id_user, $id, $quantify, $price, $picture);
            if($_GET['content']){
                header("Location:home-login.php?page=content.php&success=Đã thêm vào giỏ hàng");
            }else{
            header("Location:home-login.php?page=product.php&success=Đã thêm vào giỏ hàng");}
        } else {
            $up_quantify = $row_id_GH['soluong'] + 1;
            $update_quantify_GH = "UPDATE giohang SET soluong = $up_quantify WHERE masanpham ='$id'";
            $result_quantify_GH = mysqli_query($conn, $update_quantify_GH);
            if($_GET['content']){
                header("Location:home-login.php?page=content.php&success=Đã thêm vào giỏ hàng");
            }else{
            header("Location:home-login.php?page=product.php&success=Đã thêm vào giỏ hàng");}
        }
    }













?>









<?php } else {
    header("Location:home.php?page=./LOGIN/form-login.php");
} ?>