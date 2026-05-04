<?php
require_once dirname(__DIR__) . "/tienda-cliente/model/data/DB.php";

$db = new DataBase();
$conn = $db->Open();

echo "<h2>Setting up Database...</h2>";

// Create tables directly
$tables = array(
    "CREATE TABLE IF NOT EXISTS Cuenta (
        usuario VARCHAR(40) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        fechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        estado ENUM('activo', 'inactivo') DEFAULT 'activo',
        PRIMARY KEY (usuario)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS Cliente (
        ci VARCHAR(20) NOT NULL,
        nombres VARCHAR(50) NOT NULL,
        apPaterno VARCHAR(30) NOT NULL,
        apMaterno VARCHAR(30) NOT NULL,
        correo VARCHAR(50) NOT NULL,
        direccion VARCHAR(100) NOT NULL,
        nroCelular VARCHAR(15) NOT NULL,
        usuarioCuenta VARCHAR(40) NOT NULL,
        fechaRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        estado ENUM('activo', 'inactivo') DEFAULT 'activo',
        PRIMARY KEY (ci),
        UNIQUE KEY uk_usuario_cuenta (usuarioCuenta)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS Sucursal (
        cod INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(50) NOT NULL,
        direccion VARCHAR(150) NOT NULL,
        nroTelefono VARCHAR(15) NOT NULL,
        estado ENUM('activa', 'inactiva') DEFAULT 'activa',
        fechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (cod)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS Industria (
        cod INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(50) NOT NULL UNIQUE,
        PRIMARY KEY (cod)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS Marca (
        cod INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(50) NOT NULL UNIQUE,
        descripcion VARCHAR(200),
        PRIMARY KEY (cod)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS Categoria (
        cod INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(50) NOT NULL UNIQUE,
        descripcion VARCHAR(200),
        PRIMARY KEY (cod)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS Producto (
        cod INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(100) NOT NULL,
        descripcion VARCHAR(300) NOT NULL,
        precio DECIMAL(10,2) NOT NULL,
        imagen VARCHAR(255) NOT NULL,
        estado ENUM('disponible', 'agotado', 'descontinuado') DEFAULT 'disponible',
        codMarca INT NOT NULL,
        codIndustria INT NOT NULL,
        codCategoria INT NOT NULL,
        fechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        ultimaActualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (cod)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS DetalleProductoSucursal (
        codProducto INT NOT NULL,
        codSucursal INT NOT NULL,
        stock INT NOT NULL DEFAULT 0,
        stockMinimo INT DEFAULT 5,
        fechaActualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (codProducto, codSucursal)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS NotaVenta (
        nro INT NOT NULL AUTO_INCREMENT,
        fechaHora DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        ciCliente VARCHAR(20) NOT NULL,
        totalVenta DECIMAL(15,2) NOT NULL DEFAULT 0,
        estado ENUM('pendiente', 'completada', 'cancelada') DEFAULT 'pendiente',
        observaciones VARCHAR(200),
        PRIMARY KEY (nro)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS DetalleNotaVenta (
        nroNotaVenta INT NOT NULL,
        codProducto INT NOT NULL,
        item INT NOT NULL,
        cant INT NOT NULL,
        precioUnitario DECIMAL(10,2) NOT NULL,
        subtotal DECIMAL(15,2) NOT NULL,
        PRIMARY KEY (nroNotaVenta, codProducto)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "CREATE TABLE IF NOT EXISTS FormaPago (
        cod INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(50) NOT NULL,
        descripcion VARCHAR(200),
        PRIMARY KEY (cod)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
);

$tablesCreated = 0;
foreach ($tables as $sql) {
    if (mysqli_query($conn, $sql)) {
        $tablesCreated++;
    } else {
        $err = mysqli_error($conn);
        if (strpos($err, "already exists") === false) {
            echo "<p style='color:red'>Table error: $err</p>";
        }
    }
}
echo "<p>Created $tablesCreated tables</p>";

// Create stored procedures
$procs = array(
    "CREATE PROCEDURE IF NOT EXISTS sp_ProductoListar()
    BEGIN
        SELECT 
            p.cod, 
            p.nombre, 
            p.descripcion, 
            p.precio, 
            p.imagen, 
            p.estado,
            p.codMarca,
            p.codIndustria, 
            p.codCategoria,
            m.nombre AS marca,
            i.nombre AS industria,
            c.nombre AS categoria
        FROM Producto p
        LEFT JOIN Marca m ON p.codMarca = m.cod
        LEFT JOIN Industria i ON p.codIndustria = i.cod
        LEFT JOIN Categoria c ON p.codCategoria = c.cod
        WHERE p.estado = 'disponible';
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_ProductoObtener(IN p_cod INT)
    BEGIN
        SELECT 
            p.cod, 
            p.nombre, 
            p.descripcion, 
            p.precio, 
            p.imagen, 
            p.estado,
            p.codMarca,
            p.codIndustria, 
            p.codCategoria,
            m.nombre AS marca,
            i.nombre AS industria,
            c.nombre AS categoria
        FROM Producto p
        LEFT JOIN Marca m ON p.codMarca = m.cod
        LEFT JOIN Industria i ON p.codIndustria = i.cod
        LEFT JOIN Categoria c ON p.codCategoria = c.cod
        WHERE p.cod = p_cod;
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_CuentaListar()
    BEGIN
        SELECT usuario, email, fechaCreacion, estado FROM Cuenta;
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_CuentaObtener(IN p_usuario VARCHAR(40))
    BEGIN
        SELECT usuario, email, fechaCreacion, estado FROM Cuenta WHERE usuario = p_usuario;
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_CuentaInsertar(IN p_usuario VARCHAR(40), IN p_password VARCHAR(255), IN p_email VARCHAR(100))
    BEGIN
        INSERT INTO Cuenta (usuario, password, email) VALUES (p_usuario, p_password, p_email);
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_ClienteListar()
    BEGIN
        SELECT ci, nombres, apPaterno, apMaterno, correo, direccion, nroCelular, usuarioCuenta, fechaRegistro, estado FROM Cliente;
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_ClienteObtener(IN p_ci VARCHAR(20))
    BEGIN
        SELECT * FROM Cliente WHERE ci = p_ci;
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_SucursalListar()
    BEGIN
        SELECT cod, nombre, direccion, nroTelefono, estado FROM Sucursal;
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_MarcaListar()
    BEGIN
        SELECT cod, nombre, descripcion FROM Marca;
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_CategoriaListar()
    BEGIN
        SELECT cod, nombre, descripcion FROM Categoria;
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_IndustriaListar()
    BEGIN
        SELECT cod, nombre FROM Industria;
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_FormaPagoListar()
    BEGIN
        SELECT cod, nombre, descripcion FROM FormaPago;
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_NotaVentaInsertar(IN p_ciCliente VARCHAR(20))
    BEGIN
        INSERT INTO NotaVenta (ciCliente) VALUES (p_ciCliente);
        SELECT LAST_INSERT_ID() AS nro;
    END",

    "CREATE PROCEDURE IF NOT EXISTS sp_DetalleNotaVentaInsertar(IN p_nroNotaVenta INT, IN p_codProducto INT, IN p_item INT, IN p_cant INT, IN p_precioUnitario DECIMAL(10,2))
    BEGIN
        INSERT INTO DetalleNotaVenta (nroNotaVenta, codProducto, item, cant, precioUnitario, subtotal)
        VALUES (p_nroNotaVenta, p_codProducto, p_item, p_cant, p_precioUnitario, p_cant * p_precioUnitario);
    END"
);

$procsCreated = 0;
foreach ($procs as $sql) {
    if (mysqli_multi_query($conn, $sql)) {
        do {
            // Consume results
        } while (mysqli_more_results($conn) && mysqli_next_result($conn));
        $procsCreated++;
    } else {
        $err = mysqli_error($conn);
        if (strpos($err, "already exists") === false && strpos($err, "Syntax") === false) {
            echo "<p style='color:red'>Proc error: $err</p>";
        }
    }
}
echo "<p>Created $procsCreated stored procedures</p>";

// Create test accounts
echo "<h3>Creating Test Accounts...</h3>";

$sql = "INSERT INTO Cuenta (usuario, password, email, estado) 
        VALUES ('admin', 'admin123', 'admin@example.com', 'activo')
        ON DUPLICATE KEY UPDATE password = 'admin123'";
mysqli_query($conn, $sql);
echo "<p>Admin: admin / admin123</p>";

$sql = "INSERT INTO Cuenta (usuario, password, email, estado) 
        VALUES ('cliente_demo', 'demo123', 'cliente@example.com', 'activo')
        ON DUPLICATE KEY UPDATE password = 'demo123'";
mysqli_query($conn, $sql);
echo "<p>Cliente: cliente_demo / demo123</p>";

$sql = "INSERT INTO Cliente (ci, nombres, apPaterno, apMaterno, correo, direccion, nroCelular, usuarioCuenta, estado)
        VALUES ('12345678', 'Cliente', 'Prueba', 'Demo', 'cliente@example.com', 'Sin direccion', '70000000', 'cliente_demo', 'activo')
        ON DUPLICATE KEY UPDATE nombres = 'Cliente'";
mysqli_query($conn, $sql);
echo "<p>Cliente profile: CI 12345678</p>";

// Add test data
$sql = "INSERT INTO Marca (cod, nombre, descripcion) VALUES (1, 'Nike', 'Sports brand') ON DUPLICATE KEY UPDATE nombre = 'Nike'";
mysqli_query($conn, $sql);
$sql = "INSERT INTO Industria (cod, nombre) VALUES (1, 'Calzado') ON DUPLICATE KEY UPDATE nombre = 'Calzado'";
mysqli_query($conn, $sql);
$sql = "INSERT INTO Categoria (cod, nombre, descripcion) VALUES (1, 'Deportes', 'Sports footwear') ON DUPLICATE KEY UPDATE nombre = 'Deportes'";
mysqli_query($conn, $sql);
$sql = "INSERT INTO FormaPago (cod, nombre, descripcion) VALUES (1, 'Efectivo', 'Pago en efectivo') ON DUPLICATE KEY UPDATE nombre = 'Efectivo'";
mysqli_query($conn, $sql);
$sql = "INSERT INTO FormaPago (cod, nombre, descripcion) VALUES (2, 'QR', 'Pago con codigo QR') ON DUPLICATE KEY UPDATE nombre = 'QR'";
mysqli_query($conn, $sql);

$sql = "INSERT INTO Producto (cod, nombre, descripcion, precio, imagen, codMarca, codIndustria, codCategoria)
        VALUES (1, 'Zapatillas Nike', 'Running shoes', 299.99, 'calzado/nike1.jpg', 1, 1, 1)
        ON DUPLICATE KEY UPDATE nombre = 'Zapatillas Nike'";
mysqli_query($conn, $sql);

$sql = "INSERT INTO Sucursal (cod, nombre, direccion, nroTelefono) VALUES (1, 'Tienda Principal', 'Av. Principal 123', '70000000') ON DUPLICATE KEY UPDATE nombre = 'Tienda Principal'";
mysqli_query($conn, $sql);

$sql = "INSERT INTO DetalleProductoSucursal (codProducto, codSucursal, stock) VALUES (1, 1, 50)";
mysqli_query($conn, $sql);

echo "<p>Added test product: Zapatillas Nike - Bs. 299.99</p>";

echo "<h3>Setup Complete!</h3>";
echo "<p><a href='../tienda-cliente/'>Go to Tienda Cliente</a></p>";
echo "<p><a href='../tienda-admin/'>Go to Tienda Admin</a></p>";
?>