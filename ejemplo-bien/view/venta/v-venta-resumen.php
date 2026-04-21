<?php

$nomUsuario = $oUsuario->nombre;
$title = "Resumen de Venta";

$cboCliente = CreateCbo($listaCliente, "cliente", "idCliente", "nombre");

$content = "";
$importeProductos = 0;

foreach($listaDetalle as $item){
	$hashTipoPizza = isset($item['hashTipoPizza']) ? $item['hashTipoPizza'] : (isset($item['hashProducto']) ? $item['hashProducto'] : "");
	$hashTamanho = isset($item['hashTamanho']) ? $item['hashTamanho'] : "";
	$cantidad = isset($item['cantidad']) ? ($item['cantidad'] * 1) : 0;
	$nombrePizza = isset($item['nombrePizza']) ? $item['nombrePizza'] : "";
	$imagenPizza = isset($item['imagenPizza']) ? $item['imagenPizza'] : "";
	$nombreTamanho = isset($item['nombreTamanho']) ? $item['nombreTamanho'] : "";
	$precioUnitario = isset($item['precioUnitario']) ? ($item['precioUnitario'] * 1) : 0;
	$subtotal = isset($item['subtotal']) ? ($item['subtotal'] * 1) : 0;

	if ($hashTipoPizza == "" || $hashTamanho == "" || $cantidad < 1){
		continue;
	}

	if ($nombrePizza == "" || $imagenPizza == "" || $nombreTamanho == "" || $precioUnitario <= 0 || $subtotal <= 0){
		$oTipoPizza = Buscar($listaTiposPizzas, "hashTipoPizza", $hashTipoPizza);
		$oTamanho = Buscar($listaTamanho, "hashTamanho", $hashTamanho);
		if ($oTipoPizza == null || $oTamanho == null){
			continue;
		}
		$nombrePizza = $oTipoPizza->nombre;
		$imagenPizza = $oTipoPizza->imagen;
		$nombreTamanho = $oTamanho->nombre;
		$precioUnitario = $oTamanho->precio * 1;
		$subtotal = $cantidad * $precioUnitario;
	}
	$importeProductos += $subtotal;

	$content .= "
	<div class='x-1'>
		<div class='card'>
			<div class='card-title' style='text-align:center;'>" . $nombrePizza . "</div>
			<div class='card-subtitle' style='text-align:center;'>Tamaño " . $nombreTamanho . " - " . $cantidad . " x " . $precioUnitario . " Bs
				<span>" . $subtotal . " Bs</span>
			</div>
			<div class='separator'></div>
			<img src='../../view/img/pizzas/" . $imagenPizza . "' style='width:100%; display:block; border-radius:10px;'>
		</div>
	</div>";
}

if ($content == ""){
	$content = "
	<div class='x-1'>
		<div class='card'>
			<div class='card-title'>No hay productos en el detalle</div>
			<div class='card-subtitle'>Regrese para adicionar al menos una pizza.</div>
		</div>
	</div>";
}

$infoTarifas = "No se ha seleccionado zona de entrega";
if ($oTarifaSeleccionada != null){
	$infoTarifas = $oTarifaSeleccionada->zona . " - " . $oTarifaSeleccionada->precioDelivery . " Bs";
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
		<a href='c-venta-new.php?continue'><div class='btn-back'></div></a>
	</div>

	<div class='form-content'>
		<div class='title'><?php echo $title ?></div>

		<form action='c-venta-save.php' method='post'>
			<div class='x-1'>
				<?php echo $cboCliente; ?>
				<div class='label'>Cliente</div>
			</div>
			<div class='x-1'>
				<div class='card'>
					<div class='card-title'>Zona de entrega</div>
					<div class='card-subtitle'><?php echo $infoTarifas; ?></div>
				</div>
			</div>
			<div class='x-1'>
				<input type='text' name='obs' placeholder='Observación' />
				<div class='label'>Observación</div>
			</div>

			<?php echo $content; ?>

			<div class='x-1'>
				<div class='card'>
					<div class='card-title'>Subtotal productos</div>
					<div class='card-subtitle'><?php echo $importeProductos; ?> Bs</div>
				</div>
			</div>

			<div class='x-2'>
				<a href='c-venta-new.php?continue'><input type='button' value='Continuar adicionando' /></a>
			</div>
			<div class='x-2'>
				<input type='submit' value='Finalizar venta' />
			</div>
		</form>

		<div class='clear'></div>
	</div>
</div>
</body>
</html>
