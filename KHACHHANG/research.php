<!-- product -->
<?php


if (isset($_POST['btn_research']) && !empty($_POST['research_value'])) {
    $research_value = $_POST['research_value'];
    echo $research_value ?>
    
<?php } else {
  header('Location:http://localhost/BANPHIMCO/KHACHHANG/home-login.php?page=product.php');
} ?>