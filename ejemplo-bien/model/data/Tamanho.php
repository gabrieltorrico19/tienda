<?php

class Tamanho{
	public $idTamanho;
	public $hashTamanho;
	public $nombre;
	public $precio;
	public $estado;

	function __construct($idTamanho, $hashTamanho, $nombre, $precio, $estado)
	{
		$this->idTamanho = $idTamanho;
		$this->hashTamanho = $hashTamanho;
		$this->nombre = $nombre;
		$this->precio = $precio;
		$this->estado = $estado;
	}
}

?>
