<?php

/**
 * @author      Miguel Angel Macias Burgos
 * @company     WBT
 * @copyright   2026
 * @version     1.0
 */

$nomUsuario = $oUsuario->nombre;

$title = "Modificar Tipo de Pizza";

$nomTipoPizza = $oTipoPizza->nombre;
$desTipoPizza = $oTipoPizza->descripcion;
$imgTipoPizza = $oTipoPizza->imagen;
$estadoTipoPizza = $oTipoPizza->estado;

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
		<a href='c-tipospizzas-list.php'><div class='btn-back'></div></a>
	</div>
	<!-- Body -->
	<div class='form-content'>
		<div class='title'><?php echo $title ?></div>

		<form action='c-tipospizzas-update.php' method='POST'>
		<input type='hidden' name='hash' value='<?php echo $hashTipoPizza; ?>' />
		<div class='x-2'>
			<input type='text' name='nom' placeholder='Nombre del tipo de pizza' required value='<?php echo $nomTipoPizza; ?>' />
			<div class='label'>Nombre</div>
		</div>
		<div class='x-2'>
			<input type='text' name='des' placeholder='Descripcion' value='<?php echo $desTipoPizza; ?>' />
			<div class='label'>Descripcion</div>
		</div>
		<div class='x-2'>
			<input type='text' name='img' placeholder='Imagen (ej. pizza.png)' value='<?php echo $imgTipoPizza; ?>' />
			<div class='label'>Imagen</div>
		</div>
		<div class='x-2'>
			<select name='est'>
				<option value='Activo' <?php echo ($estadoTipoPizza == 'Activo') ? 'selected' : ''; ?>>Activo</option>
				<option value='Inactivo' <?php echo ($estadoTipoPizza == 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
			</select>
			<div class='label'>Estado</div>
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
