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

$codProducto = isset($_GET["codProducto"]) ? (int)$_GET["codProducto"] : 0;
$codSucursal = isset($_GET["codSucursal"]) ? (int)$_GET["codSucursal"] : 0;

$oRN_Detalle = new RN_DetalleProductoSucursal();
$oDetalle = $oRN_Detalle->GetData($codProducto, $codSucursal);

if ($oDetalle === null) {
    header("Location: c-inventario-list.php?codSucursal=" . $codSucursal);
    exit();
}

$oRN_Producto = new RN_Producto();
$oRN_Sucursal = new RN_Sucursal();
$oProducto = $oRN_Producto->GetData($codProducto);
$oSucursal = $oRN_Sucursal->GetData($codSucursal);

include __DIR__ . "/../../view/Inventario/v-inventario-edit.php";
