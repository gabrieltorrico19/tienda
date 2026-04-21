<?php

require_once __DIR__ . "/config-app.php";
require_once __DIR__ . "/../model/RN_Producto.php";

session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: c-admin-login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: c-admin-products.php");
    exit();
}

$idProducto = (int)$_GET["id"];
$producto = RN_Producto::obtenerPorId($idProducto);
if (!$producto) {
    header("Location: c-admin-products.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        "nombre" => $_POST["nombre"] ?? "",
        "descripcion" => $_POST["descripcion"] ?? "",
        "precio" => (float)($_POST["precio"] ?? 0),
        "stock" => (int)($_POST["stock"] ?? 0)
    ];

    $nombreImagen = $producto["imagen"];
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === 0) {
        $nombreImagen = basename($_FILES["imagen"]["name"]);
        $rutaDestino = __DIR__ . "/../recursos/imagenes/" . $nombreImagen;
        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
            $error = "Error al subir la nueva imagen.";
        }
    }

    if (!isset($error)) {
        if (RN_Producto::actualizar($idProducto, $data, $nombreImagen)) {
            $mensaje = "Producto actualizado con exito.";
            header("Location: c-admin-products.php?mensaje=" . urlencode($mensaje));
            exit();
        }
        $error = "Error al actualizar el producto.";
    }
}

include __DIR__ . "/../view/admin/v-product-edit.php";
