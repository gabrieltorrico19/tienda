<?php

require_once __DIR__ . "/../config.php";

session_start();
$clienteUsuario = $_SESSION['CLIENTE_USER'] ?? null;
if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = [];
}

if (isset($_GET["accion"], $_GET["id"])) {
    $idProducto = (int)$_GET["id"];

    if ($_GET["accion"] === "agregar") {
        $encontrado = false;
        foreach ($_SESSION["carrito"] as &$item) {
            if ($item["id_producto"] === $idProducto) {
                $item["cantidad"]++;
                $encontrado = true;
                break;
            }
        }
        unset($item);
        if (!$encontrado) {
            $_SESSION["carrito"][] = ["id_producto" => $idProducto, "cantidad" => 1];
        }
    } elseif ($_GET["accion"] === "eliminar") {
        foreach ($_SESSION["carrito"] as $indice => $item) {
            if ($item["id_producto"] === $idProducto) {
                unset($_SESSION["carrito"][$indice]);
                break;
            }
        }
        $_SESSION["carrito"] = array_values($_SESSION["carrito"]);
    }
}

$cartItems = [];
$total = 0.0;
$modelPath = __DIR__ . "/../../model/RN_Producto.php";
if (file_exists($modelPath)) {
    require_once $modelPath;
}

$oRN_Producto = class_exists("RN_Producto") ? new RN_Producto() : null;

foreach ($_SESSION["carrito"] as $item) {
    $producto = null;
    if ($oRN_Producto) {
        $producto = $oRN_Producto->GetData((int)$item["id_producto"]);
    }
    if (!$producto) {
        continue;
    }
    $subtotal = $producto->precio * $item["cantidad"];
    $total += $subtotal;
    $cartItems[] = [
        "producto" => [
            "id_producto" => $producto->cod,
            "nombre" => $producto->nombre,
            "descripcion" => $producto->descripcion,
            "precio" => $producto->precio,
            "imagen" => $producto->imagen
        ],
        "cantidad" => $item["cantidad"],
        "subtotal" => $subtotal
    ];
}

include __DIR__ . "/../../view/tienda/v-cart.php";
