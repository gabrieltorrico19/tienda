<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Industria.php";

$nombre = trim($_POST["nombre"] ?? "");

if ($nombre === "") {
    $error = "El nombre es obligatorio.";
    include __DIR__ . "/../../view/Industria/v-industria-new.php";
    exit();
}

$oRN_Industria = new RN_Industria();
$oIndustria = new Industria(0, $nombre);
$oRN_Industria->Save($oIndustria);

header("Location: c-industria-list.php");
exit();
