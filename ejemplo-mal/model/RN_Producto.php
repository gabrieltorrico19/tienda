<?php

require_once __DIR__ . "/data/DB.php";

class RN_Producto
{
    public static function listar(): array
    {
        $conexion = DB::get();
        $resultado = $conexion->query("SELECT * FROM productos");
        if (!$resultado) {
            return [];
        }

        $productos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = $fila;
        }

        return $productos;
    }

    public static function obtenerPorId(int $idProducto): ?array
    {
        $conexion = DB::get();
        $stmt = $conexion->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $idProducto);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $producto = $resultado->fetch_assoc();
        $stmt->close();

        return $producto ?: null;
    }

    public static function crear(array $data, string $nombreImagen): bool
    {
        $conexion = DB::get();
        $stmt = $conexion->prepare(
            "INSERT INTO productos (nombre, descripcion, precio, imagen, stock) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssdsi",
            $data["nombre"],
            $data["descripcion"],
            $data["precio"],
            $nombreImagen,
            $data["stock"]
        );
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public static function actualizar(int $idProducto, array $data, string $nombreImagen): bool
    {
        $conexion = DB::get();
        $stmt = $conexion->prepare(
            "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ?, stock = ? WHERE id_producto = ?"
        );
        $stmt->bind_param(
            "ssdsii",
            $data["nombre"],
            $data["descripcion"],
            $data["precio"],
            $nombreImagen,
            $data["stock"],
            $idProducto
        );
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    public static function eliminar(int $idProducto): bool
    {
        $conexion = DB::get();
        $stmt = $conexion->prepare("DELETE FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $idProducto);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}
