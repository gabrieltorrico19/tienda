<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Sucursal.php";

$cod = isset($_GET["cod"]) ? (int)$_GET["cod"] : 0;

$oRN_Sucursal = new RN_Sucursal();
$oSucursal = $oRN_Sucursal->GetData($cod);

if ($oSucursal === null) {
    header("Location: c-sucursal-list.php");
    exit();
}

include __DIR__ . "/../../view/Sucursal/v-sucursal-edit.php";
