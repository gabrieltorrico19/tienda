<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Sucursal.php";

$oRN_Sucursal = new RN_Sucursal();
$sucursales = $oRN_Sucursal->GetList();

include __DIR__ . "/../../view/Sucursal/v-sucursal-main.php";
