<?php

session_start();
require_once "../../model/RN_Tamanho.php";

$oRN_Tamanho = new RN_Tamanho();

if (isset($_SESSION['AGROVET4'])) {
	$hash = $_GET["hash"];
	$oRN_Tamanho->Delete($hash);

	header("Location: c-tamanho-list.php");
	exit;
}

?>
