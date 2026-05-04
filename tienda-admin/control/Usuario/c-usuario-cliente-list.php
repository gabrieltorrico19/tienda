<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Cliente.php";

$oRN_Cliente = new RN_Cliente();
$clientes = $oRN_Cliente->GetList();

include __DIR__ . "/../../view/Usuario/v-usuario-cliente-main.php";
