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
$oRN_Sucursal->Delete($cod);

header("Location: c-sucursal-list.php");
exit();
