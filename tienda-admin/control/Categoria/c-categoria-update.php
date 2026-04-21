<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Categoria.php";

$cod = (int)($_POST["cod"] ?? 0);
$nombre = trim($_POST["nombre"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");

if ($nombre === "") {
    $error = "El nombre es obligatorio.";
    $oRN_Categoria = new RN_Categoria();
    $oCategoria = $oRN_Categoria->GetData($cod);
    include __DIR__ . "/../../view/Categoria/v-categoria-edit.php";
    exit();
}

$oRN_Categoria = new RN_Categoria();
$oCategoria = new Categoria($cod, $nombre, $descripcion);
$oRN_Categoria->Update($oCategoria);

header("Location: c-categoria-list.php");
exit();
