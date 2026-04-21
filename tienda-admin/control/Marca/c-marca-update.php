<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Marca.php";

$cod = (int)($_POST["cod"] ?? 0);
$nombre = trim($_POST["nombre"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");

if ($nombre === "") {
    $error = "El nombre es obligatorio.";
    $oRN_Marca = new RN_Marca();
    $oMarca = $oRN_Marca->GetData($cod);
    include __DIR__ . "/../../view/Marca/v-marca-edit.php";
    exit();
}

$oRN_Marca = new RN_Marca();
$oMarca = new Marca($cod, $nombre, $descripcion);
$oRN_Marca->Update($oMarca);

header("Location: c-marca-list.php");
exit();
