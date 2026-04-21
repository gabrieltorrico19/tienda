<?php

$nomUsuario = $oUsuario->nombre;
$title = "Nueva Venta";
$content = "";

foreach($listaTiposPizzas as $oTipoPizza){
	$content .= "
	<div class='x-2'>
		<a href='c-venta-new-2.php?param=" . $oTipoPizza->hashTipoPizza . "'>
		<div class='card' style='height:auto;'>
			<div class='card-title'>" . $oTipoPizza->nombre . "</div>
			<div class='card-subtitle'>" . $oTipoPizza->descripcion . "</div>
			<div class='separator'></div>
			<img src='../../view/img/pizzas/" . $oTipoPizza->imagen . "' alt='" . $oTipoPizza->nombre . "' style='width:120px' />
		</div>
		</a>
	</div>";
}

if ($content == ""){
	$content = "
	<div class='x-1'>
		<div class='card'>
			<div class='card-title'>Ups!</div>
			<div class='card-subtitle'>No hay pizzas registradas.</div>
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

	<link rel='stylesheet' href='../../view/css/main.css' />
</head>

<body>
<div class='ctn-form'>
	<div class='form-header'>
		<div class='ctn-icon'><div class='icon'></div></div>
		<div class='form-title'><?php echo $appTitle; ?></div>
		<div class='form-subtitle'>Bienvenido <?php echo $nomUsuario ?></div>
		<div class='bar'><div class='step'></div></div>
		<a href='c-venta-list.php'><div class='btn-back'></div></a>
	</div>

	<div class='form-content'>
		<div class='title'><?php echo $title ?></div>

		<?php echo $content; ?>

		<div class='clear'></div>
	</div>
</div>
</body>
</html>
