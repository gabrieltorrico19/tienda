<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Producto.php";

$oRN_Producto = new RN_Producto();
$productos = $oRN_Producto->GetList();

include __DIR__ . "/../../view/Producto/v-producto-main.php";
