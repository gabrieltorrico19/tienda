<?php

require_once __DIR__ . "/../config.php";

session_start();
$clienteUsuario = $_SESSION['CLIENTE_USER'] ?? null;
$clienteCi = $_SESSION['CLIENTE_CI'] ?? null;

if (empty($_SESSION["carrito"])) {
    header("Location: c-tienda-cart.php");
    exit();
}

if ($clienteCi === null) {
    header("Location: ../c-login.php?next=tienda/c-checkout.php");
    exit();
}

require_once __DIR__ . "/../../model/RN_Producto.php";
require_once __DIR__ . "/../../model/RN_FormaPago.php";
require_once __DIR__ . "/../../model/RN_Sucursal.php";
require_once __DIR__ . "/../../model/RN_NotaVenta.php";
require_once __DIR__ . "/../../model/RN_DetalleNotaVenta.php";

$oRN_Producto = new RN_Producto();
$oRN_FormaPago = new RN_FormaPago();
$oRN_Sucursal = new RN_Sucursal();
$oRN_NotaVenta = new RN_NotaVenta();
$oRN_Detalle = new RN_DetalleNotaVenta();

$formasPago = $oRN_FormaPago->GetList();
$sucursales = $oRN_Sucursal->GetList();

$cartItems = [];
$total = 0.0;
foreach ($_SESSION["carrito"] as $item) {
    $producto = $oRN_Producto->GetData((int)$item["id_producto"]);
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codFormaPago = (int)($_POST["codFormaPago"] ?? 0);
    $codSucursal = (int)($_POST["codSucursal"] ?? 0);
    $observaciones = trim($_POST["observaciones"] ?? "");

    if ($codFormaPago === 0 || $codSucursal === 0) {
        $error = "Debe seleccionar forma de pago y sucursal.";
    } else {
        $formaPago = $oRN_FormaPago->GetData($codFormaPago);
        $nroVenta = $oRN_NotaVenta->InsertarVenta($clienteCi, $observaciones);
        $item = 1;
        foreach ($cartItems as $cartItem) {
            $oRN_Detalle->AgregarDetalle(
                $nroVenta,
                (int)$cartItem["producto"]["id_producto"],
                (int)$cartItem["cantidad"],
                $item
            );
            $item++;
        }

        try {
            $oRN_FormaPago->AsignarFormaPago($nroVenta, $codFormaPago);
            $oRN_NotaVenta->CompletarVenta($nroVenta, $codSucursal);

            $_SESSION["ULTIMA_VENTA"] = $nroVenta;
            $_SESSION["ULTIMA_FORMA_PAGO"] = $codFormaPago;
            $_SESSION["ULTIMA_SUCURSAL"] = $codSucursal;

            $_SESSION["carrito"] = [];
            $isQr = $formaPago && stripos($formaPago->nombre, "qr") !== false;
            if ($isQr) {
                header("Location: c-pago-qr.php?nro=" . $nroVenta);
            } else {
                header("Location: c-payment-success.php");
            }
            exit();
        } catch (mysqli_sql_exception $e) {
            $error = $e->getMessage();
        }
    }
}

include __DIR__ . "/../../view/tienda/v-tienda-checkout.php";
