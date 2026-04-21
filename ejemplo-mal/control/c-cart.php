<?php

require_once __DIR__ . "/config-app.php";
require_once __DIR__ . "/../model/RN_Producto.php";

session_start();
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
foreach ($_SESSION["carrito"] as $item) {
    $producto = RN_Producto::obtenerPorId((int)$item["id_producto"]);
    if (!$producto) {
        continue;
    }
    $subtotal = $producto["precio"] * $item["cantidad"];
    $total += $subtotal;
    $cartItems[] = [
        "producto" => $producto,
        "cantidad" => $item["cantidad"],
        "subtotal" => $subtotal
    ];
}

include __DIR__ . "/../view/v-cart.php";
