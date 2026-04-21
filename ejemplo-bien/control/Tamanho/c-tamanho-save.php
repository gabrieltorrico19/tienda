<?php

session_start();
require_once "../../model/RN_Tamanho.php";

$oRN_Tamanho = new RN_Tamanho();

if (isset($_SESSION['AGROVET4'])) {
	$nom = $_POST["nom"];
	$pre = $_POST["pre"];
	$est = $_POST["est"];

	$oTamanho = new Tamanho(0, "", $nom, $pre, $est);
	$oRN_Tamanho->Save($oTamanho);

	header("Location: c-tamanho-list.php");
	exit;
}

?>
