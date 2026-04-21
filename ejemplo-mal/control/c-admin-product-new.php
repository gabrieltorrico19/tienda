<?php

require_once __DIR__ . "/config-app.php";
require_once __DIR__ . "/../model/RN_Producto.php";

session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: c-admin-login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        "nombre" => $_POST["nombre"] ?? "",
        "descripcion" => $_POST["descripcion"] ?? "",
        "precio" => (float)($_POST["precio"] ?? 0),
        "stock" => (int)($_POST["stock"] ?? 0)
    ];

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === 0) {
        $nombreImagen = basename($_FILES["imagen"]["name"]);
        $rutaDestino = __DIR__ . "/../recursos/imagenes/" . $nombreImagen;

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
            if (RN_Producto::crear($data, $nombreImagen)) {
                $mensaje = "Producto agregado con exito.";
                header("Location: c-admin-products.php?mensaje=" . urlencode($mensaje));
                exit();
            }
            $error = "Error al guardar el producto.";
        } else {
            $error = "Error al subir la imagen.";
        }
    } else {
        $error = "No se ha seleccionado una imagen o hubo un error al subirla.";
    }
}

include __DIR__ . "/../view/admin/v-product-new.php";
