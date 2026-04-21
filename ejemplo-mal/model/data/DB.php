<?php

class DB
{
    public static function get(): mysqli
    {
        static $conexion = null;
        if ($conexion instanceof mysqli) {
            return $conexion;
        }

        $host = "localhost";
        $usuario = "root";
        $password = "123456789";
        $base_de_datos = "comercio_electronico";

        $conexion = new mysqli($host, $usuario, $password, $base_de_datos);
        if ($conexion->connect_error) {
            die("Error de conexion: " . $conexion->connect_error);
        }

        $conexion->set_charset("utf8");
        return $conexion;
    }
}
