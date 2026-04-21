<?php

session_start();
require_once "../../model/RN_Usuario.php";
require_once "../../model/RN_TiposPizzas.php";
require_once "../config.php";

$oRN_Usuario = new RN_Usuario();
$oRN_TiposPizzas = new RN_TiposPizzas();

if (isset($_SESSION['AGROVET4'])) {
	$data = $_SESSION['AGROVET4'];
	$hashUsuario = base64_decode($data["Key"]);
	$oUsuario = $oRN_Usuario->GetData($hashUsuario);

	$listaTiposPizzas = $oRN_TiposPizzas->GetList();

	if (!isset($_GET['continue'])){
		$_SESSION['DetalleVenta'] = null;
		unset($_SESSION['DetalleVenta']);
		$_SESSION['ZonaVenta'] = null;
		unset($_SESSION['ZonaVenta']);
	}

	if (isset($_SESSION['DetalleVenta'])) {
		$listaTemporal = unserialize($_SESSION['DetalleVenta']);
		if (!is_array($listaTemporal)) {
			$_SESSION['DetalleVenta'] = null;
			unset($_SESSION['DetalleVenta']);
		}
	}

	include_once "../../view/venta/v-venta-new.php";
} else {
	header("Location: ../c-login.php");
	exit;
}

?>
