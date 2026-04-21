<?php

class Cliente
{
    public $ci;
    public $nombres;
    public $apPaterno;
    public $apMaterno;
    public $correo;
    public $direccion;
    public $nroCelular;
    public $usuarioCuenta;
    public $fechaRegistro;
    public $estado;

    function __construct(
        $ci,
        $nombres,
        $apPaterno,
        $apMaterno,
        $correo,
        $direccion,
        $nroCelular,
        $usuarioCuenta,
        $fechaRegistro,
        $estado
    ) {
        $this->ci = $ci;
        $this->nombres = $nombres;
        $this->apPaterno = $apPaterno;
        $this->apMaterno = $apMaterno;
        $this->correo = $correo;
        $this->direccion = $direccion;
        $this->nroCelular = $nroCelular;
        $this->usuarioCuenta = $usuarioCuenta;
        $this->fechaRegistro = $fechaRegistro;
        $this->estado = $estado;
    }
}

?>