<?php
//CONNECT SQL
$servername = "localhost";
$database = "banphimco";
$user = "root";
$pass = "";

$conn = mysqli_connect($servername, $user, $pass, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//CLOSE CONNECT SQL
?>