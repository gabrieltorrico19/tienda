<?php

session_start();
require_once "../../model/RN_Tarifas.php";

$oRN_Tarifas = new RN_Tarifas();

if (isset($_SESSION['AGROVET4'])) {
	$hash = $_GET["hash"];
	$oRN_Tarifas->Delete($hash);

	header("Location: c-tarifas-list.php");
	exit;
}

?>
