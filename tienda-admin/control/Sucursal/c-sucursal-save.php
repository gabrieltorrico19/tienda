<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Sucursal.php";

$nombre = trim($_POST["nombre"] ?? "");
$direccion = trim($_POST["direccion"] ?? "");
$nroTelefono = trim($_POST["nroTelefono"] ?? "");
$estado = $_POST["estado"] ?? "activa";

if ($nombre === "" || $direccion === "" || $nroTelefono === "") {
    $error = "Todos los campos son obligatorios.";
    include __DIR__ . "/../../view/Sucursal/v-sucursal-new.php";
    exit();
}

$oRN_Sucursal = new RN_Sucursal();
$oSucursal = new Sucursal(0, $nombre, $direccion, $nroTelefono, $estado, null);
$oRN_Sucursal->Save($oSucursal);

header("Location: c-sucursal-list.php");
exit();
