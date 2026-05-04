<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Producto.php";

$oRN_Producto = new RN_Producto();
$marcas = $oRN_Producto->ListMarcas();
$industrias = $oRN_Producto->ListIndustrias();
$categorias = $oRN_Producto->ListCategorias();

$cod = (int)($_POST["cod"] ?? 0);
$nombre = trim($_POST["nombre"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");
$precio = (float)($_POST["precio"] ?? 0);
$estado = $_POST["estado"] ?? "disponible";
$codMarca = (int)($_POST["codMarca"] ?? 0);
$codIndustria = (int)($_POST["codIndustria"] ?? 0);
$codCategoria = (int)($_POST["codCategoria"] ?? 0);
$carpeta = trim($_POST["carpeta"] ?? "");
$carpeta = preg_replace('/[^a-zA-Z0-9_-]/', '', $carpeta);
if ($carpeta === "") {
    $carpeta = "productos";
}

$error = null;
$imagenRel = $_POST["imagenActual"] ?? "";

if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
    $original = basename($_FILES["imagen"]["name"]);
    $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '', $original);
    if ($safeName === "") {
        $safeName = "imagen.jpg";
    }
    $finalName = time() . "-" . $safeName;

    $recursosRoot = dirname(__DIR__, 2) . "/../recursos";
    $destDir = $recursosRoot . "/" . $carpeta;
    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }

    $destPath = $destDir . "/" . $finalName;
    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $destPath)) {
        $error = "No se pudo guardar la imagen.";
    } else {
        $imagenRel = $carpeta . "/" . $finalName;
    }
}

if ($error !== null) {
    $oProducto = $oRN_Producto->GetData($cod);
    include __DIR__ . "/../../view/Producto/v-producto-edit.php";
    exit();
}

$oProducto = new Producto(
    $cod,
    $nombre,
    $descripcion,
    $precio,
    $imagenRel,
    $estado,
    $codMarca,
    $codIndustria,
    $codCategoria
);

$oRN_Producto->Update($oProducto);

header("Location: c-producto-list.php");
exit();
