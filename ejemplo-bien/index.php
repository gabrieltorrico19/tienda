<?php

session_start();

if (!isset($_SESSION["AGROVET4"])) {
    $nameFile = "login.php";
}else{
    $nameFile = "panel.php";
}

header("location: control/c-".$nameFile);

?>