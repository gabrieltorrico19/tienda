<?php

require_once __DIR__ . "/../config.php";

session_start();
$clienteUsuario = $_SESSION["CLIENTE_USER"] ?? null;
$clienteCi = $_SESSION["CLIENTE_CI"] ?? null;

if ($clienteCi === null) {
    header("Location: ../c-login.php?next=tienda/c-pago-qr.php");
    exit();
}

$nroVenta = isset($_GET["nro"]) ? (int)$_GET["nro"] : (int)($_SESSION["ULTIMA_VENTA"] ?? 0);
if ($nroVenta === 0) {
    header("Location: c-tienda-main.php");
    exit();
}

$scheme = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https" : "http";
$host = $_SERVER["HTTP_HOST"] ?? "localhost";
$base = rtrim(dirname($_SERVER["SCRIPT_NAME"]), "/\\");
$scanUrl = $scheme . "://" . $host . $base . "/c-pago-qr-simular.php?nro=" . $nroVenta;

include __DIR__ . "/../../view/tienda/v-tienda-pago-qr.php";
