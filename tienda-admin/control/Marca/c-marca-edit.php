<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Marca.php";

$cod = isset($_GET["cod"]) ? (int)$_GET["cod"] : 0;

$oRN_Marca = new RN_Marca();
$oMarca = $oRN_Marca->GetData($cod);

if ($oMarca === null) {
    header("Location: c-marca-list.php");
    exit();
}

include __DIR__ . "/../../view/Marca/v-marca-edit.php";
