<?php

/**
 * @author      Miguel Angel Macias Burgos
 * @company     WBT
 * @copyright   2026
 * @version     1.0
 */

$nomUsuario = $oUsuario->nombre;

$title = "Modificar Tarifa";

$zonaTarifa = $oTarifa->zona;
$precioTarifa = $oTarifa->precioDelivery;
$estadoTarifa = $oTarifa->estado;

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv='content-type' content='text/html' charset='utf-8' />
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />

	<title><?php echo $appTitle; ?></title>

	<!-- CSS -->
	<link rel='stylesheet' href='../../view/css/main.css' />
</head>

<body>

<!-- Main Page -->
<div class='ctn-form'>
	<!-- Header -->
	<div class='form-header'>
		<div class='ctn-icon'><div class='icon'></div></div>
		<div class='form-title'><?php echo $appTitle; ?></div>
		<div class='form-subtitle'>Bienvenido <?php echo $nomUsuario ?></div>
		<div class='bar'><div class='step'></div></div>
		<a href='c-tarifas-list.php'><div class='btn-back'></div></a>
	</div>
	<!-- Body -->
	<div class='form-content'>
		<div class='title'><?php echo $title ?></div>

		<form action='c-tarifas-update.php' method='POST'>
		<input type='hidden' name='hash' value='<?php echo $hashTarifaEntrega; ?>' />
		<div class='x-2'>
			<input type='text' name='zon' placeholder='Zona de entrega' required value='<?php echo $zonaTarifa; ?>' />
			<div class='label'>Zona</div>
		</div>
		<div class='x-2'>
			<input type='number' step='0.01' min='0' name='pre' placeholder='Precio delivery en Bs' required value='<?php echo $precioTarifa; ?>' />
			<div class='label'>Precio Delivery</div>
		</div>
		<div class='x-1'>
			<input type='submit' value='Actualizar' />
		</div>
		</form>

		<div class='clear'></div>
	</div>

</div>

</body>
</html>
