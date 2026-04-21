<?php

session_start();
require_once "../../model/RN_Usuario.php";
require_once "../../model/RN_Venta.php";
require_once "../../model/RN_VentaItem.php";
require_once "../../model/RN_TiposPizzas.php";
require_once "../../model/RN_Tamanho.php";
require_once "../../model/RN_Tarifas.php";
require_once "../../model/RN_Cliente.php";
require_once "../config.php";

$oRN_Usuario = new RN_Usuario();
$oRN_Venta = new RN_Venta();
$oRN_VentaItem = new RN_VentaItem();
$oRN_TiposPizzas = new RN_TiposPizzas();
$oRN_Tamanho = new RN_Tamanho();
$oRN_Tarifas = new RN_Tarifas();
$oRN_Cliente = new RN_Cliente();

if (isset($_SESSION['AGROVET4'])) {
	$data = $_SESSION['AGROVET4'];
	$hashUsuario = base64_decode($data["Key"]);
	$oUsuario = $oRN_Usuario->GetData($hashUsuario);

	$listaVenta = $oRN_Venta->GetList();
	include_once "../../view/venta/v-venta-list.php";
} else {
	header("Location: ../c-login.php");
	exit;
}

?>
