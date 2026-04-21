<?php

$nomUsuario = $oUsuario->nombre;
$title = "Ventas";

$content = "";
$i = 0;
foreach($listaVenta as $oVenta){
	$i++;

	$oCliente = $oRN_Cliente->GetData(sha1($oVenta->idCliente));
	$oTarifa = $oRN_Tarifas->GetData(sha1($oVenta->idTarifaEntrega));

	$nomCliente = ($oCliente != null) ? $oCliente->nombre : "Sin cliente";
	$nomZona = ($oTarifa != null) ? $oTarifa->zona : "Sin zona";
	$costoZona = ($oTarifa != null) ? ($oTarifa->precioDelivery * 1) : 0;

	$listaVentaItem = $oRN_VentaItem->GetListByIdVenta($oVenta->idVenta);
	$detalle = "";
	$subtotalProductos = 0;

	foreach($listaVentaItem as $oVentaItem){
		$oTipoPizza = $oRN_TiposPizzas->GetData(sha1($oVentaItem->idTipoPizza));
		$oTamanho = $oRN_Tamanho->GetData(sha1($oVentaItem->idTamanho));

		$nomPizza = ($oTipoPizza != null) ? $oTipoPizza->nombre : "Pizza";
		$nomTamanho = ($oTamanho != null) ? $oTamanho->nombre : "";
		$cantidad = $oVentaItem->cantidad * 1;
		$precioUnitario = $oVentaItem->precioUnitario * 1;
		$subtotal = $oVentaItem->subtotal * 1;
		$subtotalProductos += $subtotal;

		$detalle .= "
		<div class='x-1'>
			<div class='card' style='height:auto;'>
				<div class='card-title'>" . $nomPizza . " <span>Tam: " . $nomTamanho . "</span></div>
				<div class='card-subtitle'>" . $cantidad . " x " . $precioUnitario . " Bs
					<span>" . $subtotal . " Bs</span>
				</div>
			</div>
		</div>";
	}

	$content .= "
	<div class='x-1'>
		<div class='card'>
			<div class='card-title'>Venta #" . $i . "</div>
			<div class='card-subtitle'>" . $oVenta->fechaVenta . ", " . $oVenta->horaVenta . "
				<span>Total: " . $oVenta->total . " Bs</span>
			</div>
			<div class='separator'></div>
			<div class='card-title'>Cliente</div>
			<div class='card-text'>" . $nomCliente . "</div>
			<div class='card-title'>Zona de entrega</div>
			<div class='card-subtitle'>" . $nomZona . "
				<span>" . $costoZona . " Bs</span>
			</div>
			<div class='card-subtitle'>Subtotal productos: " . $subtotalProductos . " Bs</div>
			<div class='separator'></div>
			" . $detalle . "
			<div class='card-buttons'>
				<a href='c-venta-delete.php?param=" . $oVenta->hashVenta . "'><div class='card-delete'></div></a>
			</div>
			<div class='clear'></div>
		</div>
	</div>";
}

if ($content == ""){
	$content = "
	<div class='x-1'>
		<div class='card'>
			<div class='card-title'>Ups!</div>
			<div class='card-subtitle'>No hay ventas registradas.</div>
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
		<a href='../c-panel.php'><div class='btn-back'></div></a>
	</div>

	<div class='form-content'>
		<div class='title'><?php echo $title ?></div>
		<?php echo $content; ?>
		<div class='clear'></div>
	</div>

	<a href='c-venta-new.php'><div class='btn-add'></div></a>
</div>
</body>
</html>
