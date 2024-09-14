<!-- product -->
<?php



$getproduct = "SELECT * FROM sanpham"; //lay san pham trong dtb
$result = mysqli_query($conn, $getproduct);
$num_rows = mysqli_num_rows($result);



$prd_dsp = 10; //so san pham muon hien thi
$total = ceil($num_rows / $prd_dsp); //tong so nut page hien thi

if (isset($_GET['btn-page'])) {
    $btn_page = $_GET['btn-page'];
} else {
    $btn_page = 1;
}
$getlocation = ($btn_page - 1) * $prd_dsp; // lay vi tri cua san pham
$getlimit = "SELECT * FROM sanpham ORDER BY masanpham DESC LIMIT $getlocation, $prd_dsp"; //lay san pham bat dau tu $getlocation va lay ra $prd-dsp san pham
$result_limit = mysqli_query($conn, $getlimit);

?>


<div id="PhuKien" class="wrapper align-content2 hproduct-content2">
    <H1 id="content2-keyboard_title">TẤT CẢ SẢN PHẨM</H1>
    <div class="content2">
        <?php while ($row = mysqli_fetch_assoc($result_limit)) { ?>
            <div class="content2-keyboard">
                <a href="<?php if (isset($_SESSION['username'])) {
                                echo ('ADDCART.php?id=' . $row['masanpham'] . '');
                            } else {
                                echo ('./LOGIN/form-login.php');
                            } ?>" class="content2-add_cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
                <div class="content2-card">
                    <a href="./detailproduct/index.php?id=<?php echo $row['masanpham']; ?>"><img style="height: 170px; width: 215px;" src="../QUANLI/ASSETS/img/IMG-Product/<?php echo $row['hinhanh']; ?>" alt="" class="content2-keyboard_product"></a>
                    <a href="./detailproduct/index.php?id=<?php echo $row['masanpham']; ?>">
                        <div class="content2-keyboard_discription">
                            <?php echo $row['tensanpham']; ?>
                        </div>
                    </a>
                    <a href="<?php if (isset($_SESSION['username'])) {
                                    echo ('?page=./GUEST/module/buyprd.php&id=' . $row['masanpham'] . '');
                                } else {
                                    echo './LOGIN/form-login.php';
                                }; ?>">
                        <button class="content2-keyboard_newprice">
                            <p><?php echo number_format($row['gia']) . '<span style="font-size: 8px"> VNĐ</span>'; ?></p>
                        </button>
                    </a>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

<?php echo ('<div class="btn-page">');
for ($btn = 1; $btn <= $total; $btn++) {
    if (isset($_SESSION['username'])) {
        echo ('<a href="home-login.php?page=product.php&btn-page=' . $btn . '">' . $btn . '</a>');
    } else {
        echo ('<a href="home.php?page=product.php&btn-page=' . $btn . '">' . $btn . '</a>');
    }
};
echo ('</div>');
?>



<!-- end product -->



</body>

</html>