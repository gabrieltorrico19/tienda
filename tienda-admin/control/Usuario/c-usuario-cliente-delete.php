<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Cliente.php";
require_once __DIR__ . "/../../model/RN_Cuenta.php";

$ci = trim($_GET["ci"] ?? "");
if ($ci === "") {
    header("Location: c-usuario-cliente-list.php");
    exit();
}

$oRN_Cliente = new RN_Cliente();
$oRN_Cuenta = new RN_Cuenta();

$oCliente = $oRN_Cliente->GetData($ci);
if ($oCliente) {
    $oRN_Cliente->Delete($ci);
    $oRN_Cuenta->Delete($oCliente->usuarioCuenta);
}

header("Location: c-usuario-cliente-list.php");
exit();
