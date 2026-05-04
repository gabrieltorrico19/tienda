<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Industria.php";

$oRN_Industria = new RN_Industria();
$industrias = $oRN_Industria->GetList();

include __DIR__ . "/../../view/Industria/v-industria-main.php";
