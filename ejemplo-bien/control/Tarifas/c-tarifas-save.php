<?php

session_start();
require_once "../../model/RN_Tarifas.php";

$oRN_Tarifas = new RN_Tarifas();

if (isset($_SESSION['AGROVET4'])) {
	$zon = $_POST["zon"];
	$pre = $_POST["pre"];
	$est = $_POST["est"];

	$oTarifa = new Tarifas(0, "", $zon, $pre, $est);
	$oRN_Tarifas->Save($oTarifa);

	header("Location: c-tarifas-list.php");
	exit;
}

?>
