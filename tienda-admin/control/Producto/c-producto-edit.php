<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Producto.php";

$cod = isset($_GET["cod"]) ? (int)$_GET["cod"] : 0;

$oRN_Producto = new RN_Producto();
$oProducto = $oRN_Producto->GetData($cod);
$marcas = $oRN_Producto->ListMarcas();
$industrias = $oRN_Producto->ListIndustrias();
$categorias = $oRN_Producto->ListCategorias();

if ($oProducto === null) {
    header("Location: c-producto-list.php");
    exit();
}

include __DIR__ . "/../../view/Producto/v-producto-edit.php";
