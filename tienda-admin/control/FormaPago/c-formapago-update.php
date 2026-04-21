<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_FormaPago.php";

$cod = (int)($_POST["cod"] ?? 0);
$nombre = trim($_POST["nombre"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");
$estado = $_POST["estado"] ?? "activa";

if ($nombre === "") {
    $error = "El nombre es obligatorio.";
    $oRN_FormaPago = new RN_FormaPago();
    $oForma = $oRN_FormaPago->GetData($cod);
    include __DIR__ . "/../../view/FormaPago/v-formapago-edit.php";
    exit();
}

$oRN_FormaPago = new RN_FormaPago();
$oForma = new FormaPago($cod, $nombre, $descripcion, $estado);
$oRN_FormaPago->Update($oForma);

header("Location: c-formapago-list.php");
exit();
