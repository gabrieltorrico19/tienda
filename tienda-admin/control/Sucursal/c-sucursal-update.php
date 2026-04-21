<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Sucursal.php";

$cod = (int)($_POST["cod"] ?? 0);
$nombre = trim($_POST["nombre"] ?? "");
$direccion = trim($_POST["direccion"] ?? "");
$nroTelefono = trim($_POST["nroTelefono"] ?? "");
$estado = $_POST["estado"] ?? "activa";

if ($nombre === "" || $direccion === "" || $nroTelefono === "") {
    $error = "Todos los campos son obligatorios.";
    $oRN_Sucursal = new RN_Sucursal();
    $oSucursal = $oRN_Sucursal->GetData($cod);
    include __DIR__ . "/../../view/Sucursal/v-sucursal-edit.php";
    exit();
}

$oRN_Sucursal = new RN_Sucursal();
$oSucursal = new Sucursal($cod, $nombre, $direccion, $nroTelefono, $estado, null);
$oRN_Sucursal->Update($oSucursal);

header("Location: c-sucursal-list.php");
exit();
