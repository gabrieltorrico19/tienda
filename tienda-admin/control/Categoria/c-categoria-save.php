<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Categoria.php";

$nombre = trim($_POST["nombre"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");

if ($nombre === "") {
    $error = "El nombre es obligatorio.";
    include __DIR__ . "/../../view/Categoria/v-categoria-new.php";
    exit();
}

$oRN_Categoria = new RN_Categoria();
$oCategoria = new Categoria(0, $nombre, $descripcion);
$oRN_Categoria->Save($oCategoria);

$carpetaNombre = preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower($nombre));
$recursosRoot = dirname(__DIR__, 2) . "/../recursos";
$carpetaPath = $recursosRoot . "/" . $carpetaNombre;
if (!is_dir($carpetaPath)) {
    mkdir($carpetaPath, 0755, true);
}

header("Location: c-categoria-list.php");
exit();
