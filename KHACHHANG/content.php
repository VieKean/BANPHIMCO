<!-- padđing 160px -->
<div class="content-padding-t160"></div>
<!-- banner -->
<div class="banner">
</div>
<!-- end banner -->

<?php if(isset($_GET['success'])) {echo '<script>alert("'.$_GET['success'].'")</script>';}?>
<!--  content1 -->
<div class="content1">
    <div class="wrapper">
        <div class="content1-circle">
            <div class="content1-circle_item">
                <a class="content1-circle_img" href="">
                    <img src="./ASSETS/img/IMG-home-page/Ellipse1.png" alt="#Keyboard">
                </a>
                <a class="content1-circle_title" href="#Keyboard"> Bàn Phím Cơ</a>
            </div>
            <div class="content1-circle_item">
                <a class="content1-circle_img" href="">
                    <img src="./ASSETS/img/IMG-home-page/Ellipse2.png" alt="">
                </a>
                <a class="content1-circle_title" href="#KeyCap">KeyCap</a>
            </div>
            <div class="content1-circle_item">
                <a class="content1-circle_img" href="">
                    <img src="./ASSETS/img/IMG-home-page/Ellipse3.png" alt="">
                </a>
                <a class="content1-circle_title" href="#PhuKien">Phụ Kiện</a>
            </div>
            <div class="content1-circle_item">
                <a class="content1-circle_img" href="">
                    <img src="./ASSETS/img/IMG-home-page/Ellipse4.png" alt="">
                </a>
                <a class="content1-circle_title" href="">Túi đựng bàn phím</a>
            </div>
            <div class="content1-circle_item">
                <a class="content1-circle_img" href="">
                    <img src="./ASSETS/img/IMG-home-page/Ellipse5.png" alt="">
                </a>
                <a class="content1-circle_title" href="">Dầu Lube</a>
            </div>
            <div class="content1-circle_item">
                <a class="content1-circle_img" href="">
                    <img src="./ASSETS/img/IMG-home-page/Ellipse6.png" alt="">
                </a>
                <a class="content1-circle_title" href="">Dụng cụ Lube</a>
            </div>
        </div>
    </div>
</div>
<!-- end content -->


<!-- content2 -->
<!-- keyboard -->
<a href="#" class="container-content2">
    <div id="Keyboard" class="wrapper align-content2">
        <H1 id="content2-keyboard_title">Bàn Phím Cơ</H1>
        <div class="content2">
            <?php $select_SP_1 = "SELECT * FROM sanpham WHERE loai=1 ORDER BY masanpham DESC LIMIT 0,5";
            $result_SP_1 = mysqli_query($conn, $select_SP_1);
             ?>
            <?php while($row_1 = mysqli_fetch_assoc($result_SP_1)) { ?>
                <div class="content2-keyboard">
                    <a href="<?php if (isset($_SESSION['username'])) {
                                    echo ('ADDCART.php?id=' . $row_1['masanpham'] . '&content=content');
                                } else {
                                    echo ('./LOGIN/form-login.php');
                                } ?>" class="content2-add_cart">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                    <div class="content2-card">
                        <img style="width: 215px; height: 170px" src="../QUANLI/ASSETS/img/IMG-Product/<?php echo $row_1['hinhanh'] ?>" alt="" class="content2-keyboard_product">
                        <a href="#?page=<?php echo $row_1['masanpham']; ?>">
                            <div class="content2-keyboard_discription">
                                <?php echo $row_1['tensanpham']; ?>
                            </div>
                        </a>
                        <a href="<?php if (isset($_SESSION['username'])) {
                                        echo ('?page=./GUEST/module/buyprd.php&id=' . $row_1['masanpham'] . '');
                                    } else {
                                        echo './LOGIN/form-login.php';
                                    }; ?>">
                            <button class="content2-keyboard_newprice">
                                <p><?php echo $row_1['gia']; ?></p>
                            </button>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</a>
<!-- end Keyboard -->



<!-- Keycap -->

<a href="#" class="container-content2">
    <div id="KeyCap" class="wrapper align-content2">
        <H1 id="content2-keyboard_title">KeyCap</H1>
        <div class="content2">
            <?php $select_SP_3 = "SELECT * FROM sanpham WHERE loai=3 ORDER BY masanpham DESC LIMIT 0,5";
            $result_SP_3 = mysqli_query($conn, $select_SP_3);
             ?>
            <?php while($row_3 = mysqli_fetch_assoc($result_SP_3) ) { ?>
                <div class="content2-keyboard">
                    <a href="<?php if (isset($_SESSION['username'])) {
                                    echo ('ADDCART.php?id=' . $row_3['masanpham'] . '&content=content');
                                } else {
                                    echo ('./LOGIN/form-login.php');
                                } ?>" class="content2-add_cart">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                    <div class="content2-card">
                        <img style="width: 215px; height: 170px" src="../QUANLI/ASSETS/img/IMG-Product/<?php echo $row_3['hinhanh'] ?>" alt="" class="content2-keyboard_product">
                        <a href="#?page=<?php echo $row_3['masanpham']; ?>">
                            <div class="content2-keyboard_discription">
                                <?php echo $row_3['tensanpham']; ?>
                            </div>
                        </a>
                        <a href="<?php if (isset($_SESSION['username'])) {
                                        echo ('?page=./GUEST/module/buyprd.php&id=' . $row_3['masanpham'] . '');
                                    } else {
                                        echo './LOGIN/form-login.php';
                                    }; ?>">
                            <button class="content2-keyboard_newprice">
                                <p><?php echo $row_3['gia']; ?></p>
                            </button>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</a>
<!-- end Keycap -->


<!-- Phụ Kiện -->
<a href="#" class="container-content2">
    <div id="PhuKien" class="wrapper align-content2">
        <H1 id="content2-keyboard_title">Phụ Kiện</H1>
        <div class="content2">
           <?php $select_SP_4 = "SELECT * FROM sanpham WHERE loai=4 ORDER BY masanpham DESC LIMIT 0,5";
            $result_SP_4 = mysqli_query($conn, $select_SP_4);
            ?>
            <?php while($row_4 = mysqli_fetch_assoc($result_SP_4)) { ?>
                <div class="content2-keyboard">
                    <a href="<?php if (isset($_SESSION['username'])) {
                                    echo ('ADDCART.php?id=' . $row_4['masanpham'] . '&content=content');
                                } else {
                                    echo ('./LOGIN/form-login.php');
                                } ?>" class="content2-add_cart">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                    <div class="content2-card">
                        <img style="width: 215px; height: 170px" src="../QUANLI/ASSETS/img/IMG-Product/<?php echo $row_4['hinhanh'] ?>" alt="" class="content2-keyboard_product">
                        <a href="#?page=<?php echo $row_4['masanpham']; ?>">
                            <div class="content2-keyboard_discription">
                                <?php echo $row_4['tensanpham']; ?>
                            </div>
                        </a>
                        <a href="<?php if (isset($_SESSION['username'])) {
                                        echo ('?page=./GUEST/module/buyprd.php&id=' . $row_4['masanpham'] . '');
                                    } else {
                                        echo './LOGIN/form-login.php';
                                    }; ?>">
                            <button class="content2-keyboard_newprice">
                                <p><?php echo $row_4['gia']; ?></p>
                            </button>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</a>
<!-- end phụ Kiện -->
<!-- SoldOut -->
<div class="container-content2">
    <div class="wrapper align-content2">
        <div class="content2-SoldOut_header">
            <H1 id="content2-keyboard_SoldOut">Bàn Phím Bán Chạy</H1>
            <div class="content2-Transport">
                <p id="content2-space"> |</p>
                <img id="Transport_icon" src="./ASSETS/img/IMG-home-page/truck-fast-solid 2.svg" alt="">
                <p id="Transport_free">Miễn phí giao hàng</p>
            </div>
            <ul class="local_brand">
                <li class="brand-key">
                    <a href="" class="brand-key_select">Royal Kludge</a>
                </li>
                <li class="brand-key">
                    <a href="" class="brand-key_select">Akko</a>
                </li>
                <li class="brand-key">
                    <a href="" class="brand-key_select">James donkey</a>
                </li>
                <li class="brand-key">
                    <a href="" class="brand-key_select">DareU</a>
                </li>
            </ul>
        </div>

        <a href="#" class="content2">
            <?php for ($i = 1; $i <= 5; $i++) { ?>
                <div class="content2-keyboard">
                    <div class="content2-card">
                        <img src="./ASSETS/img/IMG-home-page/product_1.png" alt="" class="content2-keyboard_product">
                        <div class="content2-keyboard_discription">
                            Bàn Phím cơ Dearu, Led RGB 16 triệu màu hostwap 5pin
                        </div>
                        <button class="content2-keyboard_newprice">
                            <p>20000</p>
                        </button>
                    </div>

                </div>
            <?php } ?>
        </a>
    </div>
</div>

<!-- end SoldOut -->
<!-- end content2 -->