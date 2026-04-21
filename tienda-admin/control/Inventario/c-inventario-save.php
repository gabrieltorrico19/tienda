<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_DetalleProductoSucursal.php";
require_once __DIR__ . "/../../model/RN_Sucursal.php";
require_once __DIR__ . "/../../model/RN_Producto.php";

$codProducto = (int)($_POST["codProducto"] ?? 0);
$codSucursal = (int)($_POST["codSucursal"] ?? 0);
$stock = (int)($_POST["stock"] ?? 0);
$stockMinimo = (int)($_POST["stockMinimo"] ?? 0);

if ($codProducto === 0 || $codSucursal === 0) {
    $error = "Debe seleccionar producto y sucursal.";
} elseif ($stock < 0 || $stockMinimo < 0) {
    $error = "Stock y stock minimo no pueden ser negativos.";
}

if (isset($error)) {
    $oRN_Sucursal = new RN_Sucursal();
    $oRN_Producto = new RN_Producto();
    $sucursales = $oRN_Sucursal->GetList();
    $productos = $oRN_Producto->GetList();
    include __DIR__ . "/../../view/Inventario/v-inventario-new.php";
    exit();
}

$oRN_Detalle = new RN_DetalleProductoSucursal();
$oRN_Detalle->SaveWithMinimo($codProducto, $codSucursal, $stock, $stockMinimo);

header("Location: c-inventario-list.php?codSucursal=" . $codSucursal);
exit();
