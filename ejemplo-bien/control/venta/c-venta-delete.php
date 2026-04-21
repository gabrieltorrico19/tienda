<?php

session_start();
require_once "../../model/RN_Usuario.php";
require_once "../../model/RN_Venta.php";
require_once "../../model/RN_VentaItem.php";

$oRN_Usuario = new RN_Usuario();
$oRN_Venta = new RN_Venta();
$oRN_VentaItem = new RN_VentaItem();

if (isset($_SESSION['AGROVET4'])) {
	$data = $_SESSION['AGROVET4'];
	$hashUsuario = base64_decode($data["Key"]);
	$oUsuario = $oRN_Usuario->GetData($hashUsuario);

	$hashVenta = $_GET["param"];
	$oVenta = $oRN_Venta->GetData($hashVenta);

	if ($oVenta != null){
		$oRN_VentaItem->DeleteByIdVenta($oVenta->idVenta);
		$oRN_Venta->Delete($hashVenta);
	}

	header("Location: c-venta-list.php");
}

?>
