<?php
/**
 * @author      Miguel Angel Macias Burgos
 * @company     WBT
 * @copyright   2026
 * @version     1.0
 */
$nomUsuario = $oUsuario->nombre;
$title = "Tipos de Pizzas";
$content = "";
foreach($listaTiposPizzas as $oTipoPizza){
	$content .= "
	<div class='x-1'>
		<div class='card'>
			<div class='card-title'>" . $oTipoPizza->nombre . "</div>
			<div class='card-buttons'>
				<a href='c-tipospizzas-main.php?hash=" . $oTipoPizza->hashTipoPizza . "'><div class='card-view'></div></a>
				<a href='c-tipospizzas-edit.php?hash=" . $oTipoPizza->hashTipoPizza . "'><div class='card-edit'></div></a>
				<a href='c-tipospizzas-delete.php?hash=" . $oTipoPizza->hashTipoPizza . "'><div class='card-delete'></div></a>
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
			<div class='card-subtitle'>No hay tipos de pizzas registrados</div>
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
	<a href='c-tipospizzas-new.php'><div class='btn-add'></div></a>
</div>

</body>
</html>
