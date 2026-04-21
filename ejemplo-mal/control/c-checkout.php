<?php

require_once __DIR__ . "/config-app.php";
require_once __DIR__ . "/../model/RN_Producto.php";

session_start();
if (empty($_SESSION["carrito"])) {
    header("Location: c-cart.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $total = 0.0;
    foreach ($_SESSION["carrito"] as $item) {
        $producto = RN_Producto::obtenerPorId((int)$item["id_producto"]);
        if ($producto) {
            $total += $producto["precio"] * $item["cantidad"];
        }
    }

    header("Location: c-payment-success.php");
    exit();
}

include __DIR__ . "/../view/v-checkout.php";
