<?php

session_start();
require_once "../../model/RN_Usuario.php";
require_once "../../model/RN_Tamanho.php";
require_once "../config.php";

$oRN_Usuario = new RN_Usuario();
$oRN_Tamanho = new RN_Tamanho();

if (isset($_SESSION['AGROVET4'])) {
	$data = $_SESSION['AGROVET4'];
	$hashUsuario = base64_decode($data["Key"]);
	$oUsuario = $oRN_Usuario->GetData($hashUsuario);

	$hashTamanho = $_GET["hash"];
	$oTamanho = $oRN_Tamanho->GetData($hashTamanho);

	include_once "../../view/Tamanho/v-tamanho-edit.php";
} else {
	header("Location: ../c-login.php");
	exit;
}

?>
