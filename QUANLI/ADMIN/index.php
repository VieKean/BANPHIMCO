<?php
require("../FUNC/conn.php");
require("func.php");
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    $hello = $_SESSION['user'];
?>

    <title>Trang Quản Trị - ADMIN</title>
    <link rel="stylesheet" href="../ASSETS/font/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="index.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">



    <body>
        <div class="container">

            <div class="content row">
                <div class="toggle">
                    <a class="fa-solid fa-bars"></a>
                </div>
                <?php
                if (isset($_GET["page"])) {
                    $page = "blocks/" . $_GET["page"] . ".php";
                    require("$page");
                }
                ?>
            </div>
            <div class="menu"> <?php require("blocks/menu.php") ?> </div>
        </div>
    </body>
<?php
} else {
    header('location: login.php');
}
?>
<script>
    let toggle = document.querySelector(".toggle");
    let menu = document.querySelector(".menu");
    let content = document.querySelector(".content");

    toggle.onclick = function() {
        menu.classList.toggle("active");
        content.classList.toggle("active");
    };
</script>