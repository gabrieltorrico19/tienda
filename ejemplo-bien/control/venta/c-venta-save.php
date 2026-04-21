<?php

session_start();
require_once "../../model/RN_Usuario.php";
require_once "../../model/RN_Venta.php";
require_once "../../model/RN_VentaItem.php";
require_once "../../model/RN_TiposPizzas.php";
require_once "../../model/RN_Tamanho.php";
require_once "../../model/RN_Tarifas.php";

$oRN_Usuario = new RN_Usuario();
$oRN_Venta = new RN_Venta();
$oRN_VentaItem = new RN_VentaItem();
$oRN_TiposPizzas = new RN_TiposPizzas();
$oRN_Tamanho = new RN_Tamanho();
$oRN_Tarifas = new RN_Tarifas();

if (isset($_SESSION['AGROVET4'])) {
	$data = $_SESSION['AGROVET4'];
	$hashUsuario = base64_decode($data["Key"]);
	$oUsuario = $oRN_Usuario->GetData($hashUsuario);

	$listaDetalle = array();
	if (isset($_SESSION['DetalleVenta'])) {
		$listaDetalle = unserialize($_SESSION['DetalleVenta']);
	}

	$hashTarifaEntrega = "";
	if (isset($_SESSION['ZonaVenta'])) {
		$hashTarifaEntrega = $_SESSION['ZonaVenta'];
	}

	if (count($listaDetalle) == 0){
		header("Location: c-venta-new.php");
		exit;
	}

	$idCliente = $_POST["cliente"] * 1;
	$obs = $_POST["obs"];

	$oTarifa = $oRN_Tarifas->GetData($hashTarifaEntrega);
	if ($oTarifa == null){
		header("Location: c-venta-resumen.php");
		exit;
	}
	$idTarifaEntrega = $oTarifa->idTarifaEntrega;
	$costoEntrega = $oTarifa->precioDelivery * 1;

	$fechaVenta = date("Y-m-d");
	$horaVenta = date("H:i:s");

	$oVenta = new Venta(0, "", $fechaVenta, $horaVenta, 0, $idCliente, $oUsuario->idUsuario, $idTarifaEntrega, $obs, "Activo");
	$idVenta = $oRN_Venta->Save($oVenta);

	$importeProductos = 0;
	foreach($listaDetalle as $item){
		$hashTipoPizza = isset($item['hashTipoPizza']) ? $item['hashTipoPizza'] : (isset($item['hashProducto']) ? $item['hashProducto'] : "");
		$hashTamanho = isset($item['hashTamanho']) ? $item['hashTamanho'] : "";
		$cantidad = isset($item['cantidad']) ? ($item['cantidad'] * 1) : 0;

		if ($hashTipoPizza == "" || $hashTamanho == "" || $cantidad < 1){
			continue;
		}

		$oTipoPizza = $oRN_TiposPizzas->GetData($hashTipoPizza);
		$oTamanho = $oRN_Tamanho->GetData($hashTamanho);
		if ($oTipoPizza == null || $oTamanho == null){
			continue;
		}

		$idTipoPizza = $oTipoPizza->idTipoPizza;
		$idTamanho = $oTamanho->idTamanho;
		$precioUnitario = $oTamanho->precio * 1;
		$subtotal = $cantidad * $precioUnitario;
		$importeProductos += $subtotal;

		$hashVentaItem = sha1($idVenta . "#" . $idTipoPizza . "#" . $idTamanho);
		$oVentaItem = new VentaItem($idVenta, $idTipoPizza, $idTamanho, $hashVentaItem, $cantidad, $precioUnitario, $subtotal, "Activo");
		$oRN_VentaItem->Save($oVentaItem);
	}

	$hashVenta = sha1($idVenta);
	$oVenta = $oRN_Venta->GetData($hashVenta);
	$oVenta->total = $importeProductos + $costoEntrega;
	$oVenta->idTarifaEntrega = $idTarifaEntrega;
	$oRN_Venta->Update($oVenta);

	$_SESSION['DetalleVenta'] = null;
	unset($_SESSION['DetalleVenta']);
	$_SESSION['ZonaVenta'] = null;
	unset($_SESSION['ZonaVenta']);

	header("Location: c-venta-list.php");
} else {
	header("Location: ../c-login.php");
}

?>
