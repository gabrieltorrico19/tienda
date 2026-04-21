<?php

session_start();
require_once "../../model/RN_Usuario.php";
require_once "../../model/RN_TiposPizzas.php";
require_once "../../model/RN_Tamanho.php";
require_once "../../model/RN_Tarifas.php";

$oRN_Usuario = new RN_Usuario();
$oRN_TiposPizzas = new RN_TiposPizzas();
$oRN_Tamanho = new RN_Tamanho();
$oRN_Tarifas = new RN_Tarifas();

if (isset($_SESSION['AGROVET4'])) {
	$data = $_SESSION['AGROVET4'];
	$hashUsuario = base64_decode($data["Key"]);
	$oUsuario = $oRN_Usuario->GetData($hashUsuario);

	$hashTipoPizza = $_POST["tipopizza"];
	$hashTamanho = $_POST["tamanho"];
	$hashTarifaEntrega = $_POST["zona"];
	$cantidad = $_POST["cantidad"] * 1;

	if ($cantidad < 1){
		$cantidad = 1;
	}

	$oTipoPizza = $oRN_TiposPizzas->GetData($hashTipoPizza);
	$oTamanho = $oRN_Tamanho->GetData($hashTamanho);
	$oTarifa = $oRN_Tarifas->GetData($hashTarifaEntrega);

	if ($oTipoPizza == null || $oTamanho == null || $oTarifa == null){
		header("Location: c-venta-new.php");
		exit;
	}

	$precioUnitario = $oTamanho->precio * 1;
	$subtotal = $cantidad * $precioUnitario;

	$listaDetalle = array();
	if (isset($_SESSION['DetalleVenta'])) {
		$listaDetalle = unserialize($_SESSION['DetalleVenta']);
	}

	$existe = false;
	for($i = 0; $i < count($listaDetalle); $i++){
		if ($listaDetalle[$i]['hashTipoPizza'] == $hashTipoPizza && $listaDetalle[$i]['hashTamanho'] == $hashTamanho){
			$existe = true;
			$listaDetalle[$i]['cantidad'] += $cantidad;
			$listaDetalle[$i]['precioUnitario'] = $precioUnitario;
			$listaDetalle[$i]['subtotal'] = $listaDetalle[$i]['cantidad'] * $precioUnitario;
			$listaDetalle[$i]['nombrePizza'] = $oTipoPizza->nombre;
			$listaDetalle[$i]['imagenPizza'] = $oTipoPizza->imagen;
			$listaDetalle[$i]['nombreTamanho'] = $oTamanho->nombre;
		}
	}

	if (!$existe){
		$item = array(
			"hashTipoPizza" => $hashTipoPizza,
			"hashTamanho" => $hashTamanho,
			"cantidad" => $cantidad,
			"nombrePizza" => $oTipoPizza->nombre,
			"imagenPizza" => $oTipoPizza->imagen,
			"nombreTamanho" => $oTamanho->nombre,
			"precioUnitario" => $precioUnitario,
			"subtotal" => $subtotal
		);
		$listaDetalle[] = $item;
	}

	$_SESSION['ZonaVenta'] = $hashTarifaEntrega;
	$_SESSION['DetalleVenta'] = serialize($listaDetalle);
	header("Location: c-venta-resumen.php");
} else {
	header("Location: ../c-login.php");
}

?>
