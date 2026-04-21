<?php

require_once __DIR__ . "/../config.php";

session_start();
$clienteUsuario = $_SESSION['CLIENTE_USER'] ?? null;

$productos = [];
$modelPath = __DIR__ . "/../../model/RN_Producto.php";
if (file_exists($modelPath)) {
    require_once $modelPath;
    if (class_exists("RN_Producto")) {
        $oRN_Producto = new RN_Producto();
        $list = $oRN_Producto->GetList();
        foreach ($list as $item) {
            $productos[] = [
                "id_producto" => $item->cod,
                "nombre" => $item->nombre,
                "descripcion" => $item->descripcion,
                "precio" => $item->precio,
                "imagen" => $item->imagen
            ];
        }
    }
}

include __DIR__ . "/../../view/tienda/v-home.php";
