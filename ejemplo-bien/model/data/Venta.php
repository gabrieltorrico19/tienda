<?php

class Venta{
	public $idVenta;
	public $hashVenta;
	public $fechaVenta;
	public $horaVenta;
	public $total;
	public $idCliente;
	public $idUsuario;
	public $idTarifaEntrega;
	public $observacion;
	public $estado;

	function __construct($idVenta, $hashVenta, $fechaVenta, $horaVenta, $total, $idCliente, $idUsuario, $idTarifaEntrega, $observacion, $estado)
	{
		$this->idVenta = $idVenta;
		$this->hashVenta = $hashVenta;
		$this->fechaVenta = $fechaVenta;
		$this->horaVenta = $horaVenta;
		$this->total = $total;
		$this->idCliente = $idCliente;
		$this->idUsuario = $idUsuario;
		$this->idTarifaEntrega = $idTarifaEntrega;
		$this->observacion = $observacion;
		$this->estado = $estado;
	}
}

?>
