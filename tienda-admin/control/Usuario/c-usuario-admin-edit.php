<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Cuenta.php";
require_once __DIR__ . "/../../model/RN_Cliente.php";

$usuario = trim($_GET["usuario"] ?? "");
if ($usuario === "") {
    header("Location: c-usuario-admin-list.php");
    exit();
}

$oRN_Cuenta = new RN_Cuenta();
$oRN_Cliente = new RN_Cliente();
$oCuenta = $oRN_Cuenta->GetData($usuario);

if (!$oCuenta) {
    header("Location: c-usuario-admin-list.php");
    exit();
}

$clientes = $oRN_Cliente->GetList();
foreach ($clientes as $cliente) {
    if ($cliente->usuarioCuenta === $usuario) {
        header("Location: c-usuario-admin-list.php");
        exit();
    }
}

include __DIR__ . "/../../view/Usuario/v-usuario-admin-edit.php";
