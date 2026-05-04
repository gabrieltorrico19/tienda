<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Industria.php";

$cod = isset($_GET["cod"]) ? (int)$_GET["cod"] : 0;

$oRN_Industria = new RN_Industria();
$oIndustria = $oRN_Industria->GetData($cod);

if ($oIndustria === null) {
    header("Location: c-industria-list.php");
    exit();
}

include __DIR__ . "/../../view/Industria/v-industria-edit.php";
