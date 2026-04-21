<?php

/**
 * @author      Miguel Angel Macias Burgos
 * @company     WBT
 * @copyright   2026
 * @version     1.0
 */

$nomUsuario = $oUsuario->nombre;

$title = "Nuevo Tamanho";

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
		<a href='c-tamanho-list.php'><div class='btn-back'></div></a>
	</div>
	<!-- Body -->
	<div class='form-content'>
		<div class='title'><?php echo $title ?></div>

		<form action='c-tamanho-save.php' method='POST'>
		<div class='x-2'>
			<input type='text' name='nom' placeholder='Nombre del tamanho' required />
			<div class='label'>Nombre</div>
		</div>
		<div class='x-2'>
			<input type='number' step='0.01' min='0' name='pre' placeholder='Precio en Bs' required />
			<div class='label'>Precio</div>
		</div>
		<div class='x-1'>
			<input type='submit' value='Guardar' />
		</div>
		</form>

		<div class='clear'></div>
	</div>

</div>

</body>
</html>
