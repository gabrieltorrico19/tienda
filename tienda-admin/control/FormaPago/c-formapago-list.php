<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_FormaPago.php";

$oRN_FormaPago = new RN_FormaPago();
$formasPago = $oRN_FormaPago->GetList();

include __DIR__ . "/../../view/FormaPago/v-formapago-main.php";
