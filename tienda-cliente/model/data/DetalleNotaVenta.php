<?php

class DetalleNotaVenta
{
    public $nroNotaVenta;
    public $codProducto;
    public $item;
    public $cant;
    public $precioUnitario;
    public $subtotal;

    function __construct($nroNotaVenta, $codProducto, $item, $cant, $precioUnitario, $subtotal)
    {
        $this->nroNotaVenta = $nroNotaVenta;
        $this->codProducto = $codProducto;
        $this->item = $item;
        $this->cant = $cant;
        $this->precioUnitario = $precioUnitario;
        $this->subtotal = $subtotal;
    }
}

?>