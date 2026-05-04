<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Sucursal.php";
require_once __DIR__ . "/../../model/RN_DetalleProductoSucursal.php";

$oRN_Sucursal = new RN_Sucursal();
$oRN_Detalle = new RN_DetalleProductoSucursal();

$sucursales = $oRN_Sucursal->GetList();
$codSucursal = isset($_GET["codSucursal"]) ? (int)$_GET["codSucursal"] : 0;

if ($codSucursal === 0 && !empty($sucursales)) {
    $codSucursal = (int)$sucursales[0]->cod;
}

$inventario = [];
if ($codSucursal !== 0) {
    $inventario = $oRN_Detalle->GetInventarioBySucursal($codSucursal);
}

include __DIR__ . "/../../view/Inventario/v-inventario-main.php";
