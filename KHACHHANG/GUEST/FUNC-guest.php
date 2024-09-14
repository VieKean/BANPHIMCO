<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    require_once '../CONN.php';
    $username = $_SESSION['username'];
?>


<?php
    //FUNC_SQL
    //select
    function getall_KH($conn)
    {
        $select_all = "SELECT * FROM khachhang";
        return mysqli_query($conn, $select_all);
    }
    function checklogin_KH($conn, $username)
    {
        $select_login = "SELECT tendangnhap, matkhau FROM khachhang WHERE tendangnhap = '$username'";
        return mysqli_query($conn, $select_login);
    }
    function checkemail_KH($conn, $email)
    {
        $select_email = "SELECT email FROM khachhang WHERE email = '$email'";
        return mysqli_query($conn, $select_email);
    }
    function checknumberphone_KH($conn, $numberphone)
    {
        $select_numberphone = "SELECT sodienthoai FROM khachhang WHERE sodienthoai = '$numberphone'";
        return mysqli_query($conn, $select_numberphone);
    }
    function select_DH($conn)
    {
        $select_DH = "SELECT * FROM donhang ORDER BY madonhang DESC ";
        $result_DH = mysqli_query($conn, $select_DH);
        return $result_DH;
    }

    //insert
    function updatetaikhoan_KH($conn, $username, $new_password, $new_fullname, $new_address, $new_numberphone, $new_gender, $new_email, $new_birthday)
    {
        $update_inf = "UPDATE khachhang 
                    SET matkhau = '$new_password', hoten = '$new_fullname', diachi = '$new_address', sodienthoai = '$new_numberphone', gioitinh = '$new_gender', email = '$new_email', ngaysinh = '$new_birthday' 
                    WHERE tendangnhap = '$username' ";
        return mysqli_query($conn, $update_inf);
    }

    function insert_DH($conn, $id_user, $orderday, $totalprice, $method, $quantify)
    {
        $insert_DH = "INSERT INTO donhang (makhachhang, ngaydathang, tonggia, phuongthucthanhtoan, tongsanpham)
                    VALUES('$id_user', CURRENT_DATE(), '$totalprice', '$method', '$quantify')";

        $result_DH = mysqli_query($conn, $insert_DH);
        return $result_DH;
    }

    function insert_CTHD($conn, $id_order, $id, $quantify)
    {
        $insert_CTDH = "INSERT INTO chitietdonhang(madonhang, masanpham, soluong)
                        VALUES ('$id_order', '$id', $quantify)";
        $result_CTDH = mysqli_query($conn, $insert_CTDH);
        return $result_CTDH;
    }
    
    function insert_CTHD_CART($conn, $get_id_cart, $row_id_SP, $row_quantify)
    {
        $insert_CTDH = "INSERT INTO chitietdonhang(madonhang, masanpham, soluong)
                        VALUES ('$get_id_cart', '$row_id_SP', $row_quantify)";
        $result_CTDH = mysqli_query($conn, $insert_CTDH);
        return $result_CTDH;
    }









    //CLOSE FUNC_SQL
?> 







<?php
    //HANDLE REGISTER
    //variable



    //UPDATE THÔNG TIN
    if (isset($_POST['btn-update'])) {
        $new_fullname = $_POST['new-fullname'];
        $new_password = $_POST['new-password'];
        $new_email = $_POST['new-email'];
        $new_numberphone = $_POST['new-numberphone'];
        $new_address = $_POST['new-address'];
        $new_birthday = $_POST['new-birthday'];
        $new_gender = $_POST['new-gender'];
        //handle new password
        function upd_pass($conn, $username, $new_password)
        {
            $oldpass = "SELECT matkhau FROM khachhang WHERE tendangnhap = '$username'";
            $re_oldpass = mysqli_query($conn, $oldpass);
            $row = mysqli_fetch_assoc($re_oldpass);

            $hash_verify = password_verify($new_password, $row['matkhau']);//check pass

            if ($new_password == $row['matkhau']) { //kiem tra mat khau chua bam
                return $row['matkhau'];
            } else if ($hash_verify == true) { //kiem tra mat khau da bam
                return $row['matkhau'];
            } else {
                return password_hash($new_password, PASSWORD_DEFAULT);
            }
        }
        //check-fullname
        function checkfullname($new_fullname)
        {
            $get_len = strlen($new_fullname);
            if ($get_len < 5) { //check chieu dai string
                return 0; //false
            } else { //check number in string
                function get_numerics($new_fullname)
                {
                    preg_match_all('/\d+/', $new_fullname, $matches);
                    return $matches[0];
                }
                return get_numerics($new_fullname);
            }
        }
        $checkfullname = checkfullname($new_fullname);



        //check-fullname,username,email,numberphone, password.
        $check_email = mysqli_num_rows(checkemail_KH($conn, $new_email)); //select email
        $check_numberphone = mysqli_num_rows(checknumberphone_KH($conn, $new_numberphone)); //select numberphone
        $pattern = '/^[0-9]+$/'; //chuỗi Regular Expression
        $len_numberphone = strlen($new_numberphone); //lay chieu dai` sdt

        if ($checkfullname == 0) {
            header("Location:personal-inf.php?page=./module/update-inf.php&error=Tên không được dưới 5 kí tự");
        } else if (!empty($checkfullname[0])) {
            header("Location:personal-inf.php?page=./module/update-inf.php&error=Tên không được chứa số");
        } else if ($check_email > 1) {
            header("Location:personal-inf.php?page=./module/update-inf.php&error=Email đã tồn tại");
        } else if ($check_numberphone > 1 || $len_numberphone < 0 || $len_numberphone > 11 || preg_match($pattern, $new_numberphone) === 0/*check isset string in number*/) {
            header("Location:personal-inf.php?page=./module/update-inf.php&error=Số điện thoại đã tồn tại hoặc không hợp lệ");
        } else {
            //hash password
            $hashedPassword = upd_pass($conn, $username, $new_password);
            //insert inf
            updatetaikhoan_KH($conn, $username, $hashedPassword, $new_fullname, $new_address, $new_numberphone, $new_gender, $new_email, $new_birthday);
            header("Location:personal-inf.php?page=./module/update-inf.php&success=Cập nhật thành công");
        }
    }








    

    //HANDLE PAYMENT

    else if (isset($_POST['fullname'])) {

        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $numberphone = $_POST['numberphone'];
        $address = $_POST['address'];
        $method = $_POST['method'];
        $quantify = $_POST['quantify'];
        $id = $_GET['id'];
        $id_user = $_GET['id_user'];

        //check-fullname
        function checkfullname($fullname)
        {
            $get_len = strlen($fullname);
            if ($get_len < 5) { //check chieu dai string
                return 0; //false
            } else { //check number in string
                function get_numerics($fullname)
                {
                    preg_match_all('/\d+/', $fullname, $matches);
                    return $matches[0];
                }
                return get_numerics($fullname);
            }
        }
        $checkfullname = checkfullname($fullname); //check fullname

        $pattern = '/^[0-9]+$/'; //chuỗi Regular Expression
        $len_numberphone = strlen($numberphone); //lay chieu dai` sdt

        if ($checkfullname == 0) {
            header('Location:../home-login.php?page=./GUEST/module/buyprd.php&id=' . $id . '&error=Tên không được ngắn hơn 5 kí tự');
        } else if (!empty($checkfullname[0])) {
            header('Location:../home-login.php?page=./GUEST/module/buyprd.php&id=' . $id . '&error=Tên không được chứa số');
        } else if ($len_numberphone < 0 || $len_numberphone > 12 || preg_match($pattern, $numberphone) === 0/*check isset string in number*/) {
            header('Location:../home-login.php?page=./GUEST/module/buyprd.php&id=' . $id . '&error=Số điện thoại không hợp lệ');
        } else {
            //THANH TOÁN TRỰC TIẾP 1 SẢN PHẨM
            if (isset($_POST['btn-payment'])) {
                $select_sp = "SELECT * FROM sanpham WHERE masanpham = '$id'";
                $result_sp = mysqli_query($conn, $select_sp);
                $row_sp = mysqli_fetch_assoc($result_sp);
                
                $totalprice =  $row_sp['gia'] * $quantify; //lấy tổng giá tiền sản phẩm
        

                insert_DH($conn, $id_user, $orderday, $totalprice, $method, $quantify);

                $select_DH = select_DH($conn);
                $row_DH = mysqli_fetch_assoc($select_DH);
                $id_order = $row_DH['madonhang']; //lấy mã đơn hàng vừa tạo


                insert_CTHD($conn, $id_order, $id, $quantify);
                header("Location:../home-login.php?page=content.php&success=Thanh toán thành công");
            }
            //THANH TOÁN TRONG GIỎ
            else if (isset($_POST['btn-payment-cart'])) {

                $totalquantify = $_GET['totalquantify'];
                $totalprice = $_GET['totalprice'];

                insert_DH($conn, $id_user, $orderday, $totalprice, $method, $totalquantify); //Tạo đơn hàng

                $select_DH = "SELECT * FROM donhang WHERE makhachhang = '$id_user' ORDER BY madonhang DESC";
                $result_DH = mysqli_query($conn, $select_DH);
                $row_DH = mysqli_fetch_assoc($result_DH);
                $get_id_DH = $row_DH['madonhang']; //lấy mã đơn hàng
                
                $select_GH = "SELECT * FROM giohang WHERE makhachhang ='$id_user'";
                $result_GH = mysqli_query($conn, $select_GH);
                $num_rows_GH = mysqli_num_rows($result_GH);

                while($row_GH = mysqli_fetch_assoc($result_GH)){ //tao chi tiet don hang
                    $row_id_SP = $row_GH['masanpham'];
                    $row_quantify = $row_GH['soluong'];
                    insert_CTHD_CART($conn, $get_id_DH, $row_id_SP , $row_quantify );
                };

                $delete_GH_id = "DELETE FROM giohang WHERE makhachhang = '$id_user'";
                $result_delete_GH = mysqli_query($conn, $delete_GH_id);
                header("Location:../home-login.php?page=content.php&success=Thanh toán thành công");

            };
        }
    }







?>


<?php } ?>