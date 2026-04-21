<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_FormaPago.php";

$cod = isset($_GET["cod"]) ? (int)$_GET["cod"] : 0;

$oRN_FormaPago = new RN_FormaPago();
$oRN_FormaPago->Delete($cod);

header("Location: c-formapago-list.php");
exit();
