-- =====================================================
-- BASE DE DATOS E-COMMERCE MEJORADA (TABLAS)
-- =====================================================

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `mydb`;

-- Tabla de Cuenta (Usuarios)
CREATE TABLE `Cuenta` (
  `usuario` VARCHAR(40) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `fechaCreacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `estado` ENUM('activo', 'inactivo') DEFAULT 'activo',
  PRIMARY KEY (`usuario`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabla de Cliente
CREATE TABLE `Cliente` (
  `ci` VARCHAR(20) NOT NULL,
  `nombres` VARCHAR(50) NOT NULL,
  `apPaterno` VARCHAR(30) NOT NULL,
  `apMaterno` VARCHAR(30) NOT NULL,
  `correo` VARCHAR(50) NOT NULL,
  `direccion` VARCHAR(100) NOT NULL,
  `nroCelular` VARCHAR(15) NOT NULL,
  `usuarioCuenta` VARCHAR(40) NOT NULL,
  `fechaRegistro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `estado` ENUM('activo', 'inactivo') DEFAULT 'activo',
  PRIMARY KEY (`ci`),
  UNIQUE KEY `uk_usuario_cuenta` (`usuarioCuenta`),
  KEY `idx_correo` (`correo`),
  CONSTRAINT `fk_Cliente_Cuenta`
    FOREIGN KEY (`usuarioCuenta`)
    REFERENCES `Cuenta` (`usuario`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabla de Sucursal
CREATE TABLE `Sucursal` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `direccion` VARCHAR(150) NOT NULL,
  `nroTelefono` VARCHAR(15) NOT NULL,
  `estado` ENUM('activa', 'inactiva') DEFAULT 'activa',
  `fechaCreacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod`),
  KEY `idx_nombre` (`nombre`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabla de Industria
CREATE TABLE `Industria` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL UNIQUE,
  PRIMARY KEY (`cod`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabla de Marca
CREATE TABLE `Marca` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL UNIQUE,
  `descripcion` VARCHAR(200),
  PRIMARY KEY (`cod`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabla de Categoria
CREATE TABLE `Categoria` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL UNIQUE,
  `descripcion` VARCHAR(200),
  PRIMARY KEY (`cod`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabla de Producto
CREATE TABLE `Producto` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` VARCHAR(300) NOT NULL,
  `precio` DECIMAL(10, 2) NOT NULL,
  `imagen` VARCHAR(255) NOT NULL,
  `estado` ENUM('disponible', 'agotado', 'descontinuado') DEFAULT 'disponible',
  `codMarca` INT NOT NULL,
  `codIndustria` INT NOT NULL,
  `codCategoria` INT NOT NULL,
  `fechaCreacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `ultimaActualizacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod`),
  KEY `idx_nombre` (`nombre`),
  KEY `idx_estado` (`estado`),
  KEY `fk_Producto_Industria` (`codIndustria`),
  KEY `fk_Producto_Marca` (`codMarca`),
  KEY `fk_Producto_Categoria` (`codCategoria`),
  CONSTRAINT `fk_Producto_Industria`
    FOREIGN KEY (`codIndustria`)
    REFERENCES `Industria` (`cod`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Producto_Marca`
    FOREIGN KEY (`codMarca`)
    REFERENCES `Marca` (`cod`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Producto_Categoria`
    FOREIGN KEY (`codCategoria`)
    REFERENCES `Categoria` (`cod`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabla de Detalle Producto Sucursal (Inventario)
CREATE TABLE `DetalleProductoSucursal` (
  `codProducto` INT NOT NULL,
  `codSucursal` INT NOT NULL,
  `stock` INT NOT NULL DEFAULT 0,
  `stockMinimo` INT DEFAULT 5,
  `fechaActualizacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`codProducto`, `codSucursal`),
  KEY `idx_stock` (`stock`),
  KEY `fk_DetalleProductoSucursal_Sucursal` (`codSucursal`),
  CONSTRAINT `fk_DetalleProductoSucursal_Producto`
    FOREIGN KEY (`codProducto`)
    REFERENCES `Producto` (`cod`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_DetalleProductoSucursal_Sucursal`
    FOREIGN KEY (`codSucursal`)
    REFERENCES `Sucursal` (`cod`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabla de Nota Venta
CREATE TABLE `NotaVenta` (
  `nro` INT NOT NULL AUTO_INCREMENT,
  `fechaHora` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ciCliente` VARCHAR(20) NOT NULL,
  `totalVenta` DECIMAL(15, 2) NOT NULL DEFAULT 0,
  `estado` ENUM('pendiente', 'completada', 'cancelada') DEFAULT 'pendiente',
  `observaciones` VARCHAR(200),
  PRIMARY KEY (`nro`),
  KEY `idx_fecha` (`fechaHora`),
  KEY `idx_estado` (`estado`),
  KEY `fk_NotaVenta_Cliente` (`ciCliente`),
  CONSTRAINT `fk_NotaVenta_Cliente`
    FOREIGN KEY (`ciCliente`)
    REFERENCES `Cliente` (`ci`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Tabla de Detalle Nota Venta
CREATE TABLE `DetalleNotaVenta` (
  `nroNotaVenta` INT NOT NULL,
  `codProducto` INT NOT NULL,
  `item` INT NOT NULL,
  `cant` INT NOT NULL,
  `precioUnitario` DECIMAL(10, 2) NOT NULL,
  `subtotal` DECIMAL(15, 2) NOT NULL,
  PRIMARY KEY (`nroNotaVenta`, `codProducto`),
  KEY `idx_item` (`item`),
  KEY `fk_DetalleNotaVenta_Producto` (`codProducto`),
  CONSTRAINT `fk_DetalleNotaVenta_NotaVenta`
    FOREIGN KEY (`nroNotaVenta`)
    REFERENCES `NotaVenta` (`nro`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_DetalleNotaVenta_Producto`
    FOREIGN KEY (`codProducto`)
    REFERENCES `Producto` (`cod`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Indices adicionales
CREATE INDEX idx_NotaVenta_Cliente_Fecha ON NotaVenta(ciCliente, fechaHora);
CREATE INDEX idx_DetalleNotaVenta_Producto ON DetalleNotaVenta(codProducto);
CREATE INDEX idx_Producto_Marca_Categoria ON Producto(codMarca, codCategoria);
