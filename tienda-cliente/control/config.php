<?php



date_default_timezone_set('America/La_Paz');

$appTitle = "E-Commerce";
$appSubtitle = "Version 1.0";

$scriptPath = $_SERVER["SCRIPT_NAME"];
$baseUrl = dirname($scriptPath);
$baseUrl = rtrim($baseUrl, "/");

if (strpos($baseUrl, "/tienda-cliente") !== false) {
	$baseUrl = substr($baseUrl, 0, strpos($baseUrl, "/tienda-cliente") + strlen("/tienda-cliente"));
}

?>