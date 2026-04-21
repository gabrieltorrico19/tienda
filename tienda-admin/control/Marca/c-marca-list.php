<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Marca.php";

$oRN_Marca = new RN_Marca();
$marcas = $oRN_Marca->GetList();

include __DIR__ . "/../../view/Marca/v-marca-main.php";
