<?php
session_start(); //SESSION STAR
require_once '../CONN.php';
?>


<?php
//FUNC_SQL
//select
function getall_KH($conn)
{
    $select_all = "SELECT * FROM khachhang";
    return mysqli_query($conn, $select_all);
}
function checklogin_KH($conn, $username){
    $select_login = "SELECT tendangnhap, matkhau FROM khachhang WHERE tendangnhap = '$username'";
    return mysqli_query($conn, $select_login);
}
function checkuser_KH($conn, $username)
{
    $select_user = "SELECT tendangnhap FROM khachhang WHERE tendangnhap = '$username'";
    return mysqli_query($conn, $select_user);
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

//insert
function instaikhoan_KH($conn, $username, $password, $email, $numberphone, $fullname, $date)
{
    $insert_taikhoan = "INSERT INTO khachhang(hoten, tendangnhap, matkhau, email, sodienthoai, ngaytao)
                        VALUE ('$fullname', '$username', '$password', '$email', '$numberphone', CURDATE())";
    return mysqli_query($conn, $insert_taikhoan);
}









//CLOSE FUNC_SQL
?> 







<?php
//HANDLE REGISTER
//variable
$fullname = $_POST['fullname'];
$username = $_POST['username'];
$password = $_POST['password'];
$conf_pass = $_POST['conf-pass'];
$email = $_POST['email'];
$numberphone = $_POST['numberphone'];
if (isset($_POST['btn-register'])) {
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
    $checkfullname = checkfullname($fullname);



    //check-fullname,username,email,numberphone, password.
    $check_username = mysqli_num_rows(checkuser_KH($conn, $username)); //select username
    $check_email = mysqli_num_rows(checkemail_KH($conn, $email)); //select email
    $check_numberphone = mysqli_num_rows(checknumberphone_KH($conn, $numberphone)); //select numberphone
    $pattern = '/^[0-9]+$/'; //chuỗi Regular Expression
    $len_numberphone = strlen($numberphone); //lay chieu dai` sdt

    if ($checkfullname == 0) {
        header("Location:form-register.php?error=Tên không được dưới 5 kí tự");
    } else if (!empty($checkfullname[0])) {
        header("Location:form-register.php?error=Tên không được chứa số");
    } else if ($check_username > 0) {
        header("Location:form-register.php?error=Tài khoản đã tồn tại");
    } else if (strlen($username) > 20) {
        header("Location:form-register.php?error=Tài khoản quá dài");
    } else if ($check_email > 0) {
        header("Location:form-register.php?error=Email đã tồn tại");
    } else if ($check_numberphone > 0 || $len_numberphone < 0 || $len_numberphone > 12 || preg_match($pattern, $numberphone) === 0/*check isset string in number*/) {
        header("Location:form-register.php?error=Số điện thoại đã tồn tại hoặc không hợp lệ");
    } else if ($password != $conf_pass) {
        header("Location:form-register.php?error=Mật khẩu không trùng khớp");
    } else {
        //get creative day
        
        //hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        //insert inf
        instaikhoan_KH($conn, $username, $hashedPassword, $email, $numberphone, $fullname, $date);
        header("Location:form-register.php?success=Đăng kí thành công");
    }
}


//CLOSE HANDLE REGISTER
?>




<?php
//HANDLE LOGIN
if(isset($_POST['btn-login'])){
    $check_login = checklogin_KH($conn, $username);
    $row = mysqli_fetch_assoc($check_login);
    $number_row = mysqli_num_rows($check_login); //check thong tin dang nhap

    $check_pass = password_verify($password, $row['matkhau']);//check mat khau
    
    if($number_row === 1 && $check_pass === true ){
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $row['matkhau'];
        header("Location:../home-login.php");
        
    }
    else{
        header("Location:form-login.php?error-login=Sai tài khoản hoặc mật khẩu &username=$username");
    }
    
    
}











//CLOSE HANDLE LOGIN
?>