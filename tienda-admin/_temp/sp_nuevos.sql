-- =====================================================
-- SP NUEVOS (ADMIN)
-- =====================================================

DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_CuentaListar` $$
CREATE PROCEDURE `sp_CuentaListar`()
BEGIN
  SELECT * FROM Cuenta ORDER BY usuario;
END$$

DROP PROCEDURE IF EXISTS `sp_CuentaObtener` $$
CREATE PROCEDURE `sp_CuentaObtener`(IN p_usuario VARCHAR(40))
BEGIN
  SELECT * FROM Cuenta WHERE usuario = p_usuario LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_CuentaInsertar` $$
CREATE PROCEDURE `sp_CuentaInsertar`(
  IN p_usuario VARCHAR(40),
  IN p_password VARCHAR(255),
  IN p_email VARCHAR(100),
  IN p_estado ENUM('activo', 'inactivo')
)
BEGIN
  INSERT INTO Cuenta (usuario, password, email, estado)
  VALUES (p_usuario, p_password, p_email, p_estado);
END$$

DROP PROCEDURE IF EXISTS `sp_CuentaActualizar` $$
CREATE PROCEDURE `sp_CuentaActualizar`(
  IN p_usuario VARCHAR(40),
  IN p_password VARCHAR(255),
  IN p_email VARCHAR(100),
  IN p_estado ENUM('activo', 'inactivo')
)
BEGIN
  UPDATE Cuenta
  SET password = p_password,
      email = p_email,
      estado = p_estado
  WHERE usuario = p_usuario;
END$$

DROP PROCEDURE IF EXISTS `sp_CuentaEliminar` $$
CREATE PROCEDURE `sp_CuentaEliminar`(IN p_usuario VARCHAR(40))
BEGIN
  UPDATE Cuenta SET estado = 'inactivo' WHERE usuario = p_usuario;
END$$

DROP PROCEDURE IF EXISTS `sp_ClienteListar` $$
CREATE PROCEDURE `sp_ClienteListar`()
BEGIN
  SELECT * FROM Cliente ORDER BY nombres, apPaterno, apMaterno;
END$$

DROP PROCEDURE IF EXISTS `sp_ClienteObtener` $$
CREATE PROCEDURE `sp_ClienteObtener`(IN p_ci VARCHAR(20))
BEGIN
  SELECT * FROM Cliente WHERE ci = p_ci LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_ClienteInsertar` $$
CREATE PROCEDURE `sp_ClienteInsertar`(
  IN p_ci VARCHAR(20),
  IN p_nombres VARCHAR(50),
  IN p_apPaterno VARCHAR(30),
  IN p_apMaterno VARCHAR(30),
  IN p_correo VARCHAR(50),
  IN p_direccion VARCHAR(100),
  IN p_nroCelular VARCHAR(15),
  IN p_usuarioCuenta VARCHAR(40),
  IN p_estado ENUM('activo', 'inactivo')
)
BEGIN
  INSERT INTO Cliente (ci, nombres, apPaterno, apMaterno, correo, direccion, nroCelular, usuarioCuenta, estado)
  VALUES (p_ci, p_nombres, p_apPaterno, p_apMaterno, p_correo, p_direccion, p_nroCelular, p_usuarioCuenta, p_estado);
END$$

DROP PROCEDURE IF EXISTS `sp_ClienteActualizar` $$
CREATE PROCEDURE `sp_ClienteActualizar`(
  IN p_ci VARCHAR(20),
  IN p_nombres VARCHAR(50),
  IN p_apPaterno VARCHAR(30),
  IN p_apMaterno VARCHAR(30),
  IN p_correo VARCHAR(50),
  IN p_direccion VARCHAR(100),
  IN p_nroCelular VARCHAR(15),
  IN p_estado ENUM('activo', 'inactivo')
)
BEGIN
  UPDATE Cliente
  SET nombres = p_nombres,
      apPaterno = p_apPaterno,
      apMaterno = p_apMaterno,
      correo = p_correo,
      direccion = p_direccion,
      nroCelular = p_nroCelular,
      estado = p_estado
  WHERE ci = p_ci;
END$$

DROP PROCEDURE IF EXISTS `sp_ClienteEliminar` $$
CREATE PROCEDURE `sp_ClienteEliminar`(IN p_ci VARCHAR(20))
BEGIN
  UPDATE Cliente SET estado = 'inactivo' WHERE ci = p_ci;
END$$

DROP PROCEDURE IF EXISTS `sp_SucursalListar` $$
CREATE PROCEDURE `sp_SucursalListar`()
BEGIN
  SELECT * FROM Sucursal ORDER BY nombre;
END$$

DROP PROCEDURE IF EXISTS `sp_SucursalObtener` $$
CREATE PROCEDURE `sp_SucursalObtener`(IN p_cod INT)
BEGIN
  SELECT * FROM Sucursal WHERE cod = p_cod LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_SucursalInsertar` $$
CREATE PROCEDURE `sp_SucursalInsertar`(
  IN p_nombre VARCHAR(50),
  IN p_direccion VARCHAR(150),
  IN p_nroTelefono VARCHAR(15),
  IN p_estado ENUM('activa', 'inactiva')
)
BEGIN
  INSERT INTO Sucursal (nombre, direccion, nroTelefono, estado)
  VALUES (p_nombre, p_direccion, p_nroTelefono, p_estado);
END$$

DROP PROCEDURE IF EXISTS `sp_SucursalActualizar` $$
CREATE PROCEDURE `sp_SucursalActualizar`(
  IN p_cod INT,
  IN p_nombre VARCHAR(50),
  IN p_direccion VARCHAR(150),
  IN p_nroTelefono VARCHAR(15),
  IN p_estado ENUM('activa', 'inactiva')
)
BEGIN
  UPDATE Sucursal
  SET nombre = p_nombre,
      direccion = p_direccion,
      nroTelefono = p_nroTelefono,
      estado = p_estado
  WHERE cod = p_cod;
END$$

DROP PROCEDURE IF EXISTS `sp_SucursalEliminar` $$
CREATE PROCEDURE `sp_SucursalEliminar`(IN p_cod INT)
BEGIN
  UPDATE Sucursal SET estado = 'inactiva' WHERE cod = p_cod;
END$$

DROP PROCEDURE IF EXISTS `sp_IndustriaObtener` $$
CREATE PROCEDURE `sp_IndustriaObtener`(IN p_cod INT)
BEGIN
  SELECT * FROM Industria WHERE cod = p_cod LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_IndustriaInsertar` $$
CREATE PROCEDURE `sp_IndustriaInsertar`(IN p_nombre VARCHAR(50))
BEGIN
  INSERT INTO Industria (nombre) VALUES (p_nombre);
END$$

DROP PROCEDURE IF EXISTS `sp_IndustriaActualizar` $$
CREATE PROCEDURE `sp_IndustriaActualizar`(IN p_cod INT, IN p_nombre VARCHAR(50))
BEGIN
  UPDATE Industria SET nombre = p_nombre WHERE cod = p_cod;
END$$

DROP PROCEDURE IF EXISTS `sp_IndustriaEliminar` $$
CREATE PROCEDURE `sp_IndustriaEliminar`(IN p_cod INT)
BEGIN
  DELETE FROM Industria WHERE cod = p_cod;
END$$

DROP PROCEDURE IF EXISTS `sp_MarcaObtener` $$
CREATE PROCEDURE `sp_MarcaObtener`(IN p_cod INT)
BEGIN
  SELECT * FROM Marca WHERE cod = p_cod LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_MarcaInsertar` $$
CREATE PROCEDURE `sp_MarcaInsertar`(IN p_nombre VARCHAR(50), IN p_descripcion VARCHAR(200))
BEGIN
  INSERT INTO Marca (nombre, descripcion) VALUES (p_nombre, p_descripcion);
END$$

DROP PROCEDURE IF EXISTS `sp_MarcaActualizar` $$
CREATE PROCEDURE `sp_MarcaActualizar`(
  IN p_cod INT,
  IN p_nombre VARCHAR(50),
  IN p_descripcion VARCHAR(200)
)
BEGIN
  UPDATE Marca SET nombre = p_nombre, descripcion = p_descripcion WHERE cod = p_cod;
END$$

DROP PROCEDURE IF EXISTS `sp_MarcaEliminar` $$
CREATE PROCEDURE `sp_MarcaEliminar`(IN p_cod INT)
BEGIN
  DELETE FROM Marca WHERE cod = p_cod;
END$$

DROP PROCEDURE IF EXISTS `sp_CategoriaObtener` $$
CREATE PROCEDURE `sp_CategoriaObtener`(IN p_cod INT)
BEGIN
  SELECT * FROM Categoria WHERE cod = p_cod LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_CategoriaInsertar` $$
CREATE PROCEDURE `sp_CategoriaInsertar`(IN p_nombre VARCHAR(50), IN p_descripcion VARCHAR(200))
BEGIN
  INSERT INTO Categoria (nombre, descripcion) VALUES (p_nombre, p_descripcion);
END$$

DROP PROCEDURE IF EXISTS `sp_CategoriaActualizar` $$
CREATE PROCEDURE `sp_CategoriaActualizar`(
  IN p_cod INT,
  IN p_nombre VARCHAR(50),
  IN p_descripcion VARCHAR(200)
)
BEGIN
  UPDATE Categoria SET nombre = p_nombre, descripcion = p_descripcion WHERE cod = p_cod;
END$$

DROP PROCEDURE IF EXISTS `sp_CategoriaEliminar` $$
CREATE PROCEDURE `sp_CategoriaEliminar`(IN p_cod INT)
BEGIN
  DELETE FROM Categoria WHERE cod = p_cod;
END$$

DROP PROCEDURE IF EXISTS `sp_DetalleProductoSucursalListar` $$
CREATE PROCEDURE `sp_DetalleProductoSucursalListar`()
BEGIN
  SELECT * FROM DetalleProductoSucursal ORDER BY codSucursal, codProducto;
END$$

DROP PROCEDURE IF EXISTS `sp_DetalleProductoSucursalObtener` $$
CREATE PROCEDURE `sp_DetalleProductoSucursalObtener`(
  IN p_codProducto INT,
  IN p_codSucursal INT
)
BEGIN
  SELECT * FROM DetalleProductoSucursal
  WHERE codProducto = p_codProducto AND codSucursal = p_codSucursal
  LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_NotaVentaListar` $$
CREATE PROCEDURE `sp_NotaVentaListar`()
BEGIN
  SELECT * FROM NotaVenta ORDER BY fechaHora DESC;
END$$

DROP PROCEDURE IF EXISTS `sp_NotaVentaObtener` $$
CREATE PROCEDURE `sp_NotaVentaObtener`(IN p_nro INT)
BEGIN
  SELECT * FROM NotaVenta WHERE nro = p_nro LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_NotaVentaActualizarEstado` $$
CREATE PROCEDURE `sp_NotaVentaActualizarEstado`(
  IN p_nro INT,
  IN p_estado ENUM('pendiente', 'completada', 'cancelada')
)
BEGIN
  UPDATE NotaVenta SET estado = p_estado WHERE nro = p_nro;
END$$

DROP PROCEDURE IF EXISTS `sp_DetalleNotaVentaListar` $$
CREATE PROCEDURE `sp_DetalleNotaVentaListar`(IN p_nroNotaVenta INT)
BEGIN
  SELECT * FROM DetalleNotaVenta WHERE nroNotaVenta = p_nroNotaVenta ORDER BY item;
END$$

DELIMITER ;
