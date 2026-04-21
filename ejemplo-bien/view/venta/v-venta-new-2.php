<?php

$nomUsuario = $oUsuario->nombre;
$title = "Nueva Venta";

$cboTamanho = CreateCbo($listaTamanho, "tamanho", "hashTamanho", "nombre");
$cboTarifas = CreateCbo($listaTarifas, "zona", "hashTarifaEntrega", "zona");

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
		<a href='c-venta-new.php'><div class='btn-back'></div></a>
	</div>

	<div class='form-content'>
		<div class='title'><?php echo $title ?></div>

		<div class='x-1'>
			<div class='card' style='text-align:center;'>
				<div class='card-title' style='text-align:center;'><?php echo $oTipoPizza->nombre; ?></div>
				<div class='card-subtitle' style='text-align:center;'><?php echo $oTipoPizza->descripcion; ?></div>
				<div class='separator'></div>
				<img src='../../view/img/pizzas/<?php echo $oTipoPizza->imagen; ?>' alt='<?php echo $oTipoPizza->nombre; ?>' style='width:100%; max-width:100%; display:block; margin:0 auto;' />
			</div>
		</div>

		<form action='c-venta-add.php' method='post'>
			<input type='hidden' name='tipopizza' value='<?php echo $oTipoPizza->hashTipoPizza; ?>' />
			<div class='x-2'>
				<?php echo $cboTamanho; ?>
				<div class='label'>Tamaño</div>
			</div>
			<div class='x-2'>
				<?php echo $cboTarifas; ?>
				<div class='label'>Zona de entrega</div>
			</div>
			<div class='x-1'>
				<input type='number' min='1' step='1' name='cantidad' value='1' required />
				<div class='label'>Cantidad</div>
			</div>
			<div class='x-1'>
				<input type='submit' value='Adicionar al detalle' />
			</div>
		</form>

		<div class='clear'></div>
	</div>
</div>
</body>
</html>
