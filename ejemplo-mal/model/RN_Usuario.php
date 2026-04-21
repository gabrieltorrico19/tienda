<?php

require_once __DIR__ . "/data/DB.php";

class RN_Usuario
{
    public static function validarAdmin(string $usuario, string $password): bool
    {
        $conexion = DB::get();
        $stmt = $conexion->prepare("SELECT 1 FROM usuarios WHERE usuario = ? AND password = ? LIMIT 1");
        $stmt->bind_param("ss", $usuario, $password);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $ok = $resultado->num_rows === 1;
        $stmt->close();

        return $ok;
    }
}
