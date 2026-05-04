<?php

class Producto
{
    public $cod;
    public $nombre;
    public $descripcion;
    public $precio;
    public $imagen;
    public $estado;
    public $codMarca;
    public $codIndustria;
    public $codCategoria;
    public $marca;
    public $industria;
    public $categoria;

    function __construct(
        $cod,
        $nombre,
        $descripcion,
        $precio,
        $imagen,
        $estado,
        $codMarca = 0,
        $codIndustria = 0,
        $codCategoria = 0,
        $marca = null,
        $industria = null,
        $categoria = null
    ) {
        $this->cod = $cod;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->imagen = $imagen;
        $this->estado = $estado;
        $this->codMarca = $codMarca;
        $this->codIndustria = $codIndustria;
        $this->codCategoria = $codCategoria;
        $this->marca = $marca;
        $this->industria = $industria;
        $this->categoria = $categoria;
    }
}

?>