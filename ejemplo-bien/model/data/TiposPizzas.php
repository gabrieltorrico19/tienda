<?php

class TiposPizzas{
	public $idTipoPizza;
	public $hashTipoPizza;
	public $nombre;
	public $descripcion;
	public $imagen;
	public $estado;

	function __construct($idTipoPizza, $hashTipoPizza, $nombre, $descripcion, $imagen, $estado)
	{
		$this->idTipoPizza = $idTipoPizza;
		$this->hashTipoPizza = $hashTipoPizza;
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->imagen = $imagen;
		$this->estado = $estado;
	}
}

?>
