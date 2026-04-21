<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Producto.php";

$oRN_Producto = new RN_Producto();
$marcas = $oRN_Producto->ListMarcas();
$industrias = $oRN_Producto->ListIndustrias();
$categorias = $oRN_Producto->ListCategorias();

include __DIR__ . "/../../view/Producto/v-producto-new.php";
