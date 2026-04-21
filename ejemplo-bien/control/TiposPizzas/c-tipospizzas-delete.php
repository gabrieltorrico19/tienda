<?php

session_start();
require_once "../../model/RN_TiposPizzas.php";

$oRN_TiposPizzas = new RN_TiposPizzas();

if (isset($_SESSION['AGROVET4'])) {
	$hash = $_GET["hash"];
	$oRN_TiposPizzas->Delete($hash);

	header("Location: c-tipospizzas-list.php");
	exit;
}

?>
