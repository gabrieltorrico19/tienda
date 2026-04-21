<?php

/**
 * @author		Miguel Angel Macias Burgos
 * @company 	WBT
 * @copyright 	2026
 * @version     1.0
 */

date_default_timezone_set('America/La_Paz');

$appTitle = "Delivery de Pizzas";
$appSubtitle = "Version 1.0";

$baseUrl = dirname($_SERVER["SCRIPT_NAME"]);
$pos = strpos($baseUrl, "/tienda-cliente");
if ($pos !== false) {
	$baseUrl = substr($baseUrl, 0, $pos);
}
$baseUrl = rtrim($baseUrl, "/");

?>