<?php

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../vendor/autoload.php";

use Dompdf\Dompdf;

session_start();
$clienteCi = $_SESSION["CLIENTE_CI"] ?? null;

if ($clienteCi === null) {
    header("Location: ../c-login.php?next=tienda/c-comprobante-pdf.php");
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
require_once __DIR__ . "/../../model/RN_FormaPago.php";

$oRN_Nota = new RN_NotaVenta();
$oRN_Detalle = new RN_DetalleNotaVenta();
$oRN_Producto = new RN_Producto();
$oRN_Cliente = new RN_Cliente();
$oRN_FormaPago = new RN_FormaPago();

$nota = $oRN_Nota->GetData($nroVenta);
if ($nota === null || $nota->ciCliente !== $clienteCi) {
    header("Location: c-tienda-main.php");
    exit();
}

$cliente = $oRN_Cliente->GetData($nota->ciCliente);
$detalles = $oRN_Detalle->GetListByVenta($nroVenta);

$formaPagoNombre = "";
$codFormaPago = (int)($_SESSION["ULTIMA_FORMA_PAGO"] ?? 0);
if ($codFormaPago > 0) {
    $forma = $oRN_FormaPago->GetData($codFormaPago);
    if ($forma) {
        $formaPagoNombre = $forma->nombre;
    }
}

$rows = "";
foreach ($detalles as $detalle) {
    $producto = $oRN_Producto->GetData($detalle->codProducto);
    $nombre = $producto ? $producto->nombre : ("Producto " . $detalle->codProducto);
    $rows .= "<tr>" .
        "<td>" . htmlspecialchars($nombre) . "</td>" .
        "<td style=\"text-align:right;\">" . intval($detalle->cant) . "</td>" .
        "<td style=\"text-align:right;\">" . number_format($detalle->precioUnitario, 2) . "</td>" .
        "<td style=\"text-align:right;\">" . number_format($detalle->subtotal, 2) . "</td>" .
        "</tr>";
}

$clienteNombre = $cliente ? trim($cliente->nombres . " " . $cliente->apPaterno . " " . $cliente->apMaterno) : "";

$html = "
<!DOCTYPE html>
<html lang=\"es\">
<head>
<meta charset=\"UTF-8\">
<title>Comprobante</title>
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
.header { text-align: center; margin-bottom: 20px; }
.info { margin-bottom: 10px; }
.table { width: 100%; border-collapse: collapse; }
.table th, .table td { border: 1px solid #333; padding: 6px; }
.table th { background: #f0f0f0; }
.total { text-align: right; font-weight: bold; }
</style>
</head>
<body>
<div class=\"header\">
    <h2>Comprobante de Pago</h2>
</div>
<div class=\"info\">
    <strong>Nro Venta:</strong> " . intval($nota->nro) . "<br>
    <strong>Fecha:</strong> " . htmlspecialchars($nota->fechaHora) . "<br>
    <strong>Cliente:</strong> " . htmlspecialchars($clienteNombre) . "<br>
    <strong>CI:</strong> " . htmlspecialchars($nota->ciCliente) . "<br>
    <strong>Forma de Pago:</strong> " . htmlspecialchars($formaPagoNombre) . "<br>
</div>
<table class=\"table\">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        " . $rows . "
    </tbody>
</table>
<p class=\"total\">Total: " . number_format($nota->totalVenta, 2) . "</p>
</body>
</html>
";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->stream("comprobante_venta_" . intval($nota->nro) . ".pdf", ["Attachment" => true]);
exit();
