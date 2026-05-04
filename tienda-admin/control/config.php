<?php



date_default_timezone_set('America/La_Paz');

$appTitle = "Tienda Admin";
$appSubtitle = "Version 1.0";

$scriptPath = $_SERVER["SCRIPT_NAME"];
$baseUrl = dirname($scriptPath);
$baseUrl = rtrim($baseUrl, "/");

if (strpos($baseUrl, "/tienda-admin") !== false) {
	$baseUrl = substr($baseUrl, 0, strpos($baseUrl, "/tienda-admin") + strlen("/tienda-admin"));
}

?>