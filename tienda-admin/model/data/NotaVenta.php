<?php

class NotaVenta
{
    public $nro;
    public $fechaHora;
    public $ciCliente;
    public $totalVenta;
    public $estado;
    public $observaciones;

    function __construct($nro, $fechaHora, $ciCliente, $totalVenta, $estado, $observaciones)
    {
        $this->nro = $nro;
        $this->fechaHora = $fechaHora;
        $this->ciCliente = $ciCliente;
        $this->totalVenta = $totalVenta;
        $this->estado = $estado;
        $this->observaciones = $observaciones;
    }
}

?>