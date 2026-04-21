<?php

class VentaItem{
	public $idVenta;
	public $idTipoPizza;
	public $idTamanho;
	public $hashVentaItem;
	public $cantidad;
	public $precioUnitario;
	public $subtotal;
	public $estado;

	function __construct($idVenta, $idTipoPizza, $idTamanho, $hashVentaItem, $cantidad, $precioUnitario, $subtotal, $estado)
	{
		$this->idVenta = $idVenta;
		$this->idTipoPizza = $idTipoPizza;
		$this->idTamanho = $idTamanho;
		$this->hashVentaItem = $hashVentaItem;
		$this->cantidad = $cantidad;
		$this->precioUnitario = $precioUnitario;
		$this->subtotal = $subtotal;
		$this->estado = $estado;
	}
}

?>
