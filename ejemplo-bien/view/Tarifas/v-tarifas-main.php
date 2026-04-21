<?php

/**
 * @author      Miguel Angel Macias Burgos
 * @company     WBT
 * @copyright   2026
 * @version     1.0
 */

$nomUsuario = $oUsuario->nombre;

$title = "Tarifas de Entrega";

$content = "";
foreach($listaTarifas as $oTarifa){
	$content .= "
	<div class='x-1'>
		<div class='card'>
			<div class='card-title'>" . $oTarifa->zona . "</div>
			<div class='card-subtitle'>Delivery: Bs " . $oTarifa->precioDelivery . "</div>
			<div class='card-buttons'>
				<a href='c-tarifas-edit.php?hash=" . $oTarifa->hashTarifaEntrega . "'><div class='card-edit'></div></a>
				<a href='c-tarifas-delete.php?hash=" . $oTarifa->hashTarifaEntrega . "'><div class='card-delete'></div></a>
			</div>
			<div class='clear'></div>
		</div>
	</div>";
}

if ($content == ""){
	$content .= "
	<div class='x-1'>
		<div class='card'>
			<div class='card-title'>Ups!</div>
			<div class='card-subtitle'>No hay tarifas registradas</div>
		</div>
	</div>";
}

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
		<a href='../c-panel.php'><div class='btn-back'></div></a>
	</div>
	<!-- Body -->
	<div class='form-content'>
		<div class='title'><?php echo $title ?></div>
		<?php echo $content; ?>
		<div class='clear'></div>

	</div>

	<a href='c-tarifas-new.php'><div class='btn-add'></div></a>
</div>

</body>
</html>
