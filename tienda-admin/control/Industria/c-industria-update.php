<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Industria.php";

$cod = (int)($_POST["cod"] ?? 0);
$nombre = trim($_POST["nombre"] ?? "");

if ($nombre === "") {
    $error = "El nombre es obligatorio.";
    $oRN_Industria = new RN_Industria();
    $oIndustria = $oRN_Industria->GetData($cod);
    include __DIR__ . "/../../view/Industria/v-industria-edit.php";
    exit();
}

$oRN_Industria = new RN_Industria();
$oIndustria = new Industria($cod, $nombre);
$oRN_Industria->Update($oIndustria);

header("Location: c-industria-list.php");
exit();
