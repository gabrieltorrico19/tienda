<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Marca.php";

$nombre = trim($_POST["nombre"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");

if ($nombre === "") {
    $error = "El nombre es obligatorio.";
    include __DIR__ . "/../../view/Marca/v-marca-new.php";
    exit();
}

$oRN_Marca = new RN_Marca();
$oMarca = new Marca(0, $nombre, $descripcion);
$oRN_Marca->Save($oMarca);

header("Location: c-marca-list.php");
exit();
