<?php

session_start();
require_once "../../model/RN_TiposPizzas.php";

$oRN_TiposPizzas = new RN_TiposPizzas();

if (isset($_SESSION['AGROVET4'])) {
	$hash = $_POST["hash"];
	$nom = $_POST["nom"];
	$des = $_POST["des"];
	$img = $_POST["img"];
	$est = $_POST["est"];

	$oTipoPizza = new TiposPizzas(0, $hash, $nom, $des, $img, $est);
	$oRN_TiposPizzas->Update($oTipoPizza);

	header("Location: c-tipospizzas-list.php");
	exit;
}

?>
