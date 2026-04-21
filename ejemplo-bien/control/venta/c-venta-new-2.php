<?php

session_start();
require_once "../../model/RN_Usuario.php";
require_once "../../model/RN_TiposPizzas.php";
require_once "../../model/RN_Tamanho.php";
require_once "../../model/RN_Tarifas.php";
require_once "../config.php";
require_once "../util.php";

$oRN_Usuario = new RN_Usuario();
$oRN_TiposPizzas = new RN_TiposPizzas();
$oRN_Tamanho = new RN_Tamanho();
$oRN_Tarifas = new RN_Tarifas();

if (isset($_SESSION['AGROVET4'])) {
	$data = $_SESSION['AGROVET4'];
	$hashUsuario = base64_decode($data["Key"]);
	$oUsuario = $oRN_Usuario->GetData($hashUsuario);

	$hashTipoPizza = $_GET["param"];
	$oTipoPizza = $oRN_TiposPizzas->GetData($hashTipoPizza);
	$listaTamanho = $oRN_Tamanho->GetList();
	$listaTarifas = $oRN_Tarifas->GetList();

	include_once "../../view/venta/v-venta-new-2.php";
} else {
	header("Location: ../c-login.php");
	exit;
}

?>
