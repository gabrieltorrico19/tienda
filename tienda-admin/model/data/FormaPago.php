<?php

class FormaPago
{
    public $cod;
    public $nombre;
    public $descripcion;
    public $estado;

    function __construct($cod, $nombre, $descripcion, $estado)
    {
        $this->cod = $cod;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
    }
}

?>