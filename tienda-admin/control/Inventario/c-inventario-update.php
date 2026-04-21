<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_DetalleProductoSucursal.php";
require_once __DIR__ . "/../../model/RN_Producto.php";
require_once __DIR__ . "/../../model/RN_Sucursal.php";

$codProducto = (int)($_POST["codProducto"] ?? 0);
$codSucursal = (int)($_POST["codSucursal"] ?? 0);
$stock = (int)($_POST["stock"] ?? 0);
$stockMinimo = (int)($_POST["stockMinimo"] ?? 0);

if ($codProducto === 0 || $codSucursal === 0) {
    $error = "Datos incompletos para actualizar.";
} elseif ($stock < 0 || $stockMinimo < 0) {
    $error = "Stock y stock minimo no pueden ser negativos.";
}

if (isset($error)) {
    $oRN_Detalle = new RN_DetalleProductoSucursal();
    $oDetalle = $oRN_Detalle->GetData($codProducto, $codSucursal);
    $oRN_Producto = new RN_Producto();
    $oRN_Sucursal = new RN_Sucursal();
    $oProducto = $oRN_Producto->GetData($codProducto);
    $oSucursal = $oRN_Sucursal->GetData($codSucursal);
    include __DIR__ . "/../../view/Inventario/v-inventario-edit.php";
    exit();
}

$oRN_Detalle = new RN_DetalleProductoSucursal();
$oRN_Detalle->SaveWithMinimo($codProducto, $codSucursal, $stock, $stockMinimo);

header("Location: c-inventario-list.php?codSucursal=" . $codSucursal);
exit();
