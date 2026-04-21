<?php

class Cuenta
{
    public $usuario;
    public $password;
    public $email;
    public $fechaCreacion;
    public $estado;

    function __construct($usuario, $password, $email, $fechaCreacion, $estado)
    {
        $this->usuario = $usuario;
        $this->password = $password;
        $this->email = $email;
        $this->fechaCreacion = $fechaCreacion;
        $this->estado = $estado;
    }
}

?>