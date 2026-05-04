<?php

require_once __DIR__ . "/../config.php";

session_start();
$clienteUsuario = $_SESSION["CLIENTE_USER"] ?? null;
$clienteCi = $_SESSION["CLIENTE_CI"] ?? null;

if ($clienteCi === null) {
    header("Location: ../c-login.php?next=tienda/c-pago-qr-simular.php");
    exit();
}

$nroVenta = isset($_GET["nro"]) ? (int)$_GET["nro"] : (int)($_SESSION["ULTIMA_VENTA"] ?? 0);
if ($nroVenta === 0) {
    header("Location: c-tienda-main.php");
    exit();
}

require_once __DIR__ . "/../../model/RN_NotaVenta.php";
require_once __DIR__ . "/../../model/RN_DetalleNotaVenta.php";
require_once __DIR__ . "/../../model/RN_Producto.php";
require_once __DIR__ . "/../../model/RN_Cliente.php";

$oRN_Nota = new RN_NotaVenta();
$oRN_Detalle = new RN_DetalleNotaVenta();
$oRN_Producto = new RN_Producto();
$oRN_Cliente = new RN_Cliente();

$nota = $oRN_Nota->GetData($nroVenta);
if ($nota === null || $nota->ciCliente !== $clienteCi) {
    header("Location: c-tienda-main.php");
    exit();
}

$cliente = $oRN_Cliente->GetData($nota->ciCliente);
$detalles = $oRN_Detalle->GetListByVenta($nroVenta);

$items = [];
foreach ($detalles as $detalle) {
    $producto = $oRN_Producto->GetData($detalle->codProducto);
    $items[] = [
        "nombre" => $producto ? $producto->nombre : ("Producto " . $detalle->codProducto),
        "cantidad" => $detalle->cant,
        "precioUnitario" => $detalle->precioUnitario,
        "subtotal" => $detalle->subtotal
    ];
}

include __DIR__ . "/../../view/tienda/v-tienda-pago-qr-simular.php";
