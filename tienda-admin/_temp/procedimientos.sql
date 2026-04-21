-- =====================================================
-- BASE DE DATOS E-COMMERCE MEJORADA (PROCEDIMIENTOS)
-- =====================================================

USE `mydb`;

-- 1. PROCEDIMIENTO PARA REGISTRAR NUEVA VENTA
DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_InsertarVenta` $$

CREATE PROCEDURE `sp_InsertarVenta`(
  IN p_ciCliente VARCHAR(20),
  IN p_observaciones VARCHAR(200),
  OUT p_nroVenta INT
)
BEGIN
  DECLARE v_existe INT;
  
  -- Validar que el cliente existe
  SELECT COUNT(*) INTO v_existe 
  FROM Cliente 
  WHERE ci = p_ciCliente AND estado = 'activo';
  
  IF v_existe = 0 THEN
    SIGNAL SQLSTATE '45000' 
    SET MESSAGE_TEXT = 'El cliente no existe o esta inactivo';
  END IF;
  
  -- Insertar nueva venta
  INSERT INTO NotaVenta (ciCliente, observaciones, estado)
  VALUES (p_ciCliente, p_observaciones, 'pendiente');
  
  -- Obtener el ID de la venta insertada
  SET p_nroVenta = LAST_INSERT_ID();
END$$

DELIMITER ;

-- 2. PROCEDIMIENTO PARA AGREGAR DETALLE A UNA VENTA
DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_AgregarDetalleVenta` $$

CREATE PROCEDURE `sp_AgregarDetalleVenta`(
  IN p_nroVenta INT,
  IN p_codProducto INT,
  IN p_cantidad INT,
  IN p_item INT
)
BEGIN
  DECLARE v_precioProducto DECIMAL(10, 2);
  DECLARE v_subtotal DECIMAL(15, 2);
  DECLARE v_totalVenta DECIMAL(15, 2);
  DECLARE v_existeProducto INT;
  
  -- Validar producto existe
  SELECT COUNT(*) INTO v_existeProducto 
  FROM Producto 
  WHERE cod = p_codProducto AND estado != 'descontinuado';
  
  IF v_existeProducto = 0 THEN
    SIGNAL SQLSTATE '45000' 
    SET MESSAGE_TEXT = 'Producto no valido o descontinuado';
  END IF;
  
  -- Obtener precio del producto
  SELECT precio INTO v_precioProducto 
  FROM Producto 
  WHERE cod = p_codProducto;
  
  -- Calcular subtotal
  SET v_subtotal = v_precioProducto * p_cantidad;
  
  -- Insertar detalle
  INSERT INTO DetalleNotaVenta (nroNotaVenta, codProducto, item, cant, precioUnitario, subtotal)
  VALUES (p_nroVenta, p_codProducto, p_item, p_cantidad, v_precioProducto, v_subtotal);
  
  -- Actualizar total de la venta
  SELECT SUM(subtotal) INTO v_totalVenta 
  FROM DetalleNotaVenta 
  WHERE nroNotaVenta = p_nroVenta;
  
  UPDATE NotaVenta 
  SET totalVenta = COALESCE(v_totalVenta, 0) 
  WHERE nro = p_nroVenta;
  
END$$

DELIMITER ;

-- 3. PROCEDIMIENTO PARA COMPLETAR VENTA Y ACTUALIZAR INVENTARIO
DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_CompletarVenta` $$

CREATE PROCEDURE `sp_CompletarVenta`(
  IN p_nroVenta INT,
  IN p_codSucursal INT
)
BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE v_codProducto INT;
  DECLARE v_cantidad INT;
  DECLARE v_stockActual INT;
  
  DECLARE cur CURSOR FOR 
    SELECT codProducto, cant 
    FROM DetalleNotaVenta 
    WHERE nroNotaVenta = p_nroVenta;
  
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  
  -- Iniciar transaccion
  START TRANSACTION;
  
  OPEN cur;
  
  read_loop: LOOP
    FETCH cur INTO v_codProducto, v_cantidad;
    IF done THEN
      LEAVE read_loop;
    END IF;
    
    -- Verificar stock disponible
    SELECT stock INTO v_stockActual 
    FROM DetalleProductoSucursal 
    WHERE codProducto = v_codProducto AND codSucursal = p_codSucursal;
    
    IF v_stockActual IS NULL OR v_stockActual < v_cantidad THEN
      ROLLBACK;
      SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = 'Stock insuficiente en la sucursal para completar la venta';
    END IF;
    
    -- Descontar del inventario
    UPDATE DetalleProductoSucursal 
    SET stock = stock - v_cantidad 
    WHERE codProducto = v_codProducto AND codSucursal = p_codSucursal;
    
  END LOOP;
  
  CLOSE cur;
  
  -- Actualizar estado de venta
  UPDATE NotaVenta 
  SET estado = 'completada' 
  WHERE nro = p_nroVenta;
  
  COMMIT;
  
END$$

DELIMITER ;

-- 4. PROCEDIMIENTO PARA CONSULTAR INVENTARIO POR SUCURSAL
DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_ConsultarInventario` $$

CREATE PROCEDURE `sp_ConsultarInventario`(
  IN p_codSucursal INT
)
BEGIN
  SELECT 
    p.cod,
    p.nombre,
    p.precio,
    m.nombre AS marca,
    c.nombre AS categoria,
    dps.stock,
    dps.stockMinimo,
    CASE 
      WHEN dps.stock <= dps.stockMinimo THEN 'BAJO'
      WHEN dps.stock <= (dps.stockMinimo * 2) THEN 'MEDIO'
      ELSE 'ALTO'
    END AS nivelStock
  FROM DetalleProductoSucursal dps
  INNER JOIN Producto p ON dps.codProducto = p.cod
  INNER JOIN Marca m ON p.codMarca = m.cod
  INNER JOIN Categoria c ON p.codCategoria = c.cod
  WHERE dps.codSucursal = p_codSucursal
  ORDER BY p.nombre;
END$$

DELIMITER ;

-- 5. PROCEDIMIENTO PARA REPORTAR VENTAS POR CLIENTE
DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_ReportarVentasCliente` $$

CREATE PROCEDURE `sp_ReportarVentasCliente`(
  IN p_ciCliente VARCHAR(20)
)
BEGIN
  SELECT 
    nv.nro AS numeroVenta,
    nv.fechaHora,
    nv.totalVenta,
    nv.estado,
    COUNT(dnv.codProducto) AS cantidadProductos
  FROM NotaVenta nv
  LEFT JOIN DetalleNotaVenta dnv ON nv.nro = dnv.nroNotaVenta
  WHERE nv.ciCliente = p_ciCliente
  GROUP BY nv.nro, nv.fechaHora, nv.totalVenta, nv.estado
  ORDER BY nv.fechaHora DESC;
END$$

DELIMITER ;

-- 6. PROCEDIMIENTO PARA ACTUALIZAR STOCK EN SUCURSAL
DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_ActualizarStock` $$

CREATE PROCEDURE `sp_ActualizarStock`(
  IN p_codProducto INT,
  IN p_codSucursal INT,
  IN p_nuevoStock INT
)
BEGIN
  DECLARE v_existe INT;
  
  -- Verificar si el registro existe
  SELECT COUNT(*) INTO v_existe 
  FROM DetalleProductoSucursal 
  WHERE codProducto = p_codProducto AND codSucursal = p_codSucursal;
  
  IF v_existe = 0 THEN
    -- Insertar nuevo registro
    INSERT INTO DetalleProductoSucursal (codProducto, codSucursal, stock)
    VALUES (p_codProducto, p_codSucursal, p_nuevoStock);
  ELSE
    -- Actualizar stock existente
    UPDATE DetalleProductoSucursal 
    SET stock = p_nuevoStock,
        fechaActualizacion = CURRENT_TIMESTAMP
    WHERE codProducto = p_codProducto AND codSucursal = p_codSucursal;
  END IF;
  
END$$

DELIMITER ;

-- 7. PROCEDIMIENTO PARA OBTENER PRODUCTOS CON BAJO STOCK
DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_ProductosBajoStock` $$

CREATE PROCEDURE `sp_ProductosBajoStock`()
BEGIN
  SELECT 
    p.cod,
    p.nombre,
    s.nombre AS sucursal,
    dps.stock,
    dps.stockMinimo,
    (dps.stockMinimo - dps.stock) AS faltante
  FROM DetalleProductoSucursal dps
  INNER JOIN Producto p ON dps.codProducto = p.cod
  INNER JOIN Sucursal s ON dps.codSucursal = s.cod
  WHERE dps.stock <= dps.stockMinimo
  AND p.estado = 'disponible'
  ORDER BY faltante DESC, s.nombre;
END$$

DELIMITER ;

-- 8. PROCEDIMIENTO PARA GENERAR REPORTE DE VENTAS POR PERIODO
DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_ReporteVentasPorPeriodo` $$

CREATE PROCEDURE `sp_ReporteVentasPorPeriodo`(
  IN p_fechaInicio DATE,
  IN p_fechaFin DATE
)
BEGIN
  SELECT 
    DATE(nv.fechaHora) AS fecha,
    COUNT(DISTINCT nv.nro) AS cantidadVentas,
    SUM(nv.totalVenta) AS totalVentas,
    AVG(nv.totalVenta) AS promedioVenta
  FROM NotaVenta nv
  WHERE DATE(nv.fechaHora) BETWEEN p_fechaInicio AND p_fechaFin
  AND nv.estado = 'completada'
  GROUP BY DATE(nv.fechaHora)
  ORDER BY fecha DESC;
END$$

DELIMITER ;

-- PROCEDIMIENTOS GENERALES
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
