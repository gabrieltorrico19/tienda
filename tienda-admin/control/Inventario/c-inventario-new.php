<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Sucursal.php";
require_once __DIR__ . "/../../model/RN_Producto.php";

$oRN_Sucursal = new RN_Sucursal();
$oRN_Producto = new RN_Producto();

$sucursales = $oRN_Sucursal->GetList();
$productos = $oRN_Producto->GetList();
$codSucursal = isset($_GET["codSucursal"]) ? (int)$_GET["codSucursal"] : 0;

include __DIR__ . "/../../view/Inventario/v-inventario-new.php";
