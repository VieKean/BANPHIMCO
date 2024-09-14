<?php
function layKH($conn)
{
    $sql = "select * from khachhang";
    return mysqli_query($conn, $sql);
}

function laySP($conn)
{
    $sql = "select * from sanpham sp, loai l where sp.loai = l.maloai";
    return mysqli_query($conn, $sql);
}

function laychitietSP($conn, $id)
{
    $sql = "select * from sanpham where masanpham = '$id'";
    return mysqli_query($conn, $sql);
}

function layDH($conn)
{
    $sql = "select * from donhang";
    return mysqli_query($conn, $sql);
}

function layCTDH($conn, $madon)
{
    if (isset($_GET['madonhang'])) {
        $madon = $_GET['madonhang'];
        $sql = "SELECT sp.gia, ctd.madonhang, kh.hoten, kh.sodienthoai, kh.diachi, sp.tensanpham,ctd.soluong,dh.tonggia,dh.phuongthucthanhtoan,dh.trangthai, l.tenloai
        FROM chitietdonhang ctd, khachhang kh, donhang dh, sanpham sp, loai l
        WHERE ctd.madonhang = dh.madonhang
        AND ctd.masanpham = sp.masanpham
        and l.maloai = sp.loai
        AND dh.makhachhang = kh.makhachhang and ctd.madonhang = '$madon'";
    } else {
        $sql = "select ct.madonhang, sp.tensanpham, ct.soluong from chitietdonhang ct, sanpham sp
            where sp.masanpham = ct.masanpham ";
    }
    return mysqli_query($conn, $sql);
}
function layCTDHfull($conn)
{
    $sql = "select ct.madonhang, sp.tensanpham, ct.soluong from chitietdonhang ct, sanpham sp
            where sp.masanpham = ct.masanpham ";
    return mysqli_query($conn, $sql);
}


function layTK($conn)
{
    $sql = "select * from taikhoan";
    return mysqli_query($conn, $sql);
}

function layLoai($conn)
{
    $sql = "select * from loai";
    return mysqli_query($conn, $sql);
}

function layMaloai($conn, $id)
{
    $sql = "select * from loai where maloai = '$id'";
    return mysqli_query($conn, $sql);
}



?>


