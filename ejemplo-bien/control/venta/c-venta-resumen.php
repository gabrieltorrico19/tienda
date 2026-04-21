<?php

session_start();
require_once "../../model/RN_Usuario.php";
require_once "../../model/RN_TiposPizzas.php";
require_once "../../model/RN_Tamanho.php";
require_once "../../model/RN_Tarifas.php";
require_once "../../model/RN_Cliente.php";
require_once "../config.php";
require_once "../util.php";

$oRN_Usuario = new RN_Usuario();
$oRN_TiposPizzas = new RN_TiposPizzas();
$oRN_Tamanho = new RN_Tamanho();
$oRN_Tarifas = new RN_Tarifas();
$oRN_Cliente = new RN_Cliente();

if (isset($_SESSION['AGROVET4'])) {
	$data = $_SESSION['AGROVET4'];
	$hashUsuario = base64_decode($data["Key"]);
	$oUsuario = $oRN_Usuario->GetData($hashUsuario);

	$listaDetalle = array();
	if (isset($_SESSION['DetalleVenta'])) {
		$listaDetalle = unserialize($_SESSION['DetalleVenta']);
	}

	$listaTiposPizzas = Filtrar($oRN_TiposPizzas->GetList(), "estado", "Activo");
	$listaTamanho = Filtrar($oRN_Tamanho->GetList(), "estado", "Activo");
	$listaCliente = Filtrar($oRN_Cliente->GetList(), "estado", "Activo");
	$listaTarifas = Filtrar($oRN_Tarifas->GetList(), "estado", "Activo");
	$hashTarifaEntrega = "";
	if (isset($_SESSION['ZonaVenta'])) {
		$hashTarifaEntrega = $_SESSION['ZonaVenta'];
	}
	$oTarifaSeleccionada = null;
	if ($hashTarifaEntrega != "") {
		$oTarifaSeleccionada = $oRN_Tarifas->GetData($hashTarifaEntrega);
	}

	include_once "../../view/venta/v-venta-resumen.php";
} else {
	header("Location: ../c-login.php");
}

?>
