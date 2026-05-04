<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_FormaPago.php";

$cod = isset($_GET["cod"]) ? (int)$_GET["cod"] : 0;

$oRN_FormaPago = new RN_FormaPago();
$oForma = $oRN_FormaPago->GetData($cod);

if ($oForma === null) {
    header("Location: c-formapago-list.php");
    exit();
}

include __DIR__ . "/../../view/FormaPago/v-formapago-edit.php";
