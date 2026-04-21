<?php

require_once __DIR__ . "/config-app.php";
require_once __DIR__ . "/../model/RN_Producto.php";

session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: c-admin-login.php");
    exit();
}

if (isset($_GET["accion"]) && $_GET["accion"] === "eliminar" && isset($_GET["id"])) {
    $idProducto = (int)$_GET["id"];
    RN_Producto::eliminar($idProducto);
    header("Location: c-admin-products.php");
    exit();
}

$productos = RN_Producto::listar();

include __DIR__ . "/../view/admin/v-products.php";
