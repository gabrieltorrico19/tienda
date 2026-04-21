<?php

class Tarifas{
	public $idTarifaEntrega;
	public $hashTarifaEntrega;
	public $zona;
	public $precioDelivery;
	public $estado;

	function __construct($idTarifaEntrega, $hashTarifaEntrega, $zona, $precioDelivery, $estado)
	{
		$this->idTarifaEntrega = $idTarifaEntrega;
		$this->hashTarifaEntrega = $hashTarifaEntrega;
		$this->zona = $zona;
		$this->precioDelivery = $precioDelivery;
		$this->estado = $estado;
	}
}

?>
