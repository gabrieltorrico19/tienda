<?php

class Cliente{
	public $idCliente;
	public $hashCliente;
	public $nombre;
	public $telefono;
	public $direccion;
	public $estado;

	function __construct($idCliente, $hashCliente, $nombre, $telefono, $direccion, $estado)
	{
		$this->idCliente = $idCliente;
		$this->hashCliente = $hashCliente;
		$this->nombre = $nombre;
		$this->telefono = $telefono;
		$this->direccion = $direccion;
		$this->estado = $estado;
	}
}

?>
