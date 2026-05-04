<?php

class FormaPago
{
    public $cod;
    public $nombre;
    public $estado;

    function __construct($cod = 0, $nombre = "", $estado = "activa")
    {
        $this->cod = $cod;
        $this->nombre = $nombre;
        $this->estado = $estado;
    }
}

?>