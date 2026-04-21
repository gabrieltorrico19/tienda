<?php

class Marca
{
    public $cod;
    public $nombre;
    public $descripcion;

    function __construct($cod, $nombre, $descripcion)
    {
        $this->cod = $cod;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }
}

?>