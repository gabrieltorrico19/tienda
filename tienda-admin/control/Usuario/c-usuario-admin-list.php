<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Cuenta.php";
require_once __DIR__ . "/../../model/RN_Cliente.php";

$oRN_Cuenta = new RN_Cuenta();
$oRN_Cliente = new RN_Cliente();

$cuentas = $oRN_Cuenta->GetList();
$clientes = $oRN_Cliente->GetList();

$clientesPorUsuario = array();
foreach ($clientes as $cliente) {
    $clientesPorUsuario[$cliente->usuarioCuenta] = $cliente;
}

$admins = array();
foreach ($cuentas as $cuenta) {
    if (!isset($clientesPorUsuario[$cuenta->usuario])) {
        $admins[] = $cuenta;
    }
}

include __DIR__ . "/../../view/Usuario/v-usuario-admin-main.php";
