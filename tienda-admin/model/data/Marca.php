<?php

class Marca
{
    public $cod;
    public $nombre;
    public $descripcion;

    function __construct($cod = 0, $nombre = "", $descripcion = "")
    {
        $this->cod = $cod;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }
}

?>