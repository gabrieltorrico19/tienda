<?php

class Sucursal
{
    public $cod;
    public $nombre;
    public $direccion;
    public $nroTelefono;
    public $estado;
    public $fechaCreacion;

    function __construct($cod, $nombre, $direccion, $nroTelefono, $estado, $fechaCreacion)
    {
        $this->cod = $cod;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->nroTelefono = $nroTelefono;
        $this->estado = $estado;
        $this->fechaCreacion = $fechaCreacion;
    }
}

?>