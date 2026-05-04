<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_DetalleProductoSucursal.php";

$codProducto = isset($_GET["codProducto"]) ? (int)$_GET["codProducto"] : 0;
$codSucursal = isset($_GET["codSucursal"]) ? (int)$_GET["codSucursal"] : 0;

$oRN_Detalle = new RN_DetalleProductoSucursal();
$oRN_Detalle->Delete($codProducto, $codSucursal);

header("Location: c-inventario-list.php?codSucursal=" . $codSucursal);
exit();
