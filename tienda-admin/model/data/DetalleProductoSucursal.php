<?php

class DetalleProductoSucursal
{
    public $codProducto;
    public $codSucursal;
    public $stock;
    public $stockMinimo;
    public $fechaActualizacion;

    function __construct($codProducto, $codSucursal, $stock, $stockMinimo, $fechaActualizacion)
    {
        $this->codProducto = $codProducto;
        $this->codSucursal = $codSucursal;
        $this->stock = $stock;
        $this->stockMinimo = $stockMinimo;
        $this->fechaActualizacion = $fechaActualizacion;
    }
}

?>