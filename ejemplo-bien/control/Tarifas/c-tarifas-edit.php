<?php

session_start();
require_once "../../model/RN_Usuario.php";
require_once "../../model/RN_Tarifas.php";
require_once "../config.php";

$oRN_Usuario = new RN_Usuario();
$oRN_Tarifas = new RN_Tarifas();

if (isset($_SESSION['AGROVET4'])) {
	$data = $_SESSION['AGROVET4'];
	$hashUsuario = base64_decode($data["Key"]);
	$oUsuario = $oRN_Usuario->GetData($hashUsuario);

	$hashTarifaEntrega = $_GET["hash"];
	$oTarifa = $oRN_Tarifas->GetData($hashTarifaEntrega);

	include_once "../../view/Tarifas/v-tarifas-edit.php";
} else {
	header("Location: ../c-login.php");
	exit;
}

?>
