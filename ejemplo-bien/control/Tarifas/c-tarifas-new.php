<?php

session_start();
require_once "../../model/RN_Usuario.php";
require_once "../../model/RN_Tarifas.php";
require_once "../config.php";

$oRN_Usuario = new RN_Usuario();

if (isset($_SESSION['AGROVET4'])) {
	$data = $_SESSION['AGROVET4'];
	$hashUsuario = base64_decode($data["Key"]);
	$oUsuario = $oRN_Usuario->GetData($hashUsuario);

	include_once "../../view/Tarifas/v-tarifas-new.php";
} else {
	header("Location: ../c-login.php");
	exit;
}

?>
