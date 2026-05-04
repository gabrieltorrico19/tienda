-- =====================================================
-- PROCEDIMIENTOS ALMACENADOS - TIENDA CLIENTE
-- =====================================================
USE mydb;

DELIMITER $$

-- ===== CUENTA =====
DROP PROCEDURE IF EXISTS sp_CuentaListar$$
CREATE PROCEDURE sp_CuentaListar()
BEGIN SELECT usuario, password, email, fechaCreacion, estado FROM Cuenta; END$$

DROP PROCEDURE IF EXISTS sp_CuentaObtener$$
CREATE PROCEDURE sp_CuentaObtener(IN pUsuario VARCHAR(40))
BEGIN SELECT usuario, password, email, fechaCreacion, estado FROM Cuenta WHERE usuario = pUsuario; END$$

DROP PROCEDURE IF EXISTS sp_CuentaInsertar$$
CREATE PROCEDURE sp_CuentaInsertar(IN pUsuario VARCHAR(40), IN pPassword VARCHAR(255), IN pEmail VARCHAR(100), IN pEstado VARCHAR(20))
BEGIN INSERT INTO Cuenta (usuario, password, email, estado) VALUES (pUsuario, pPassword, pEmail, pEstado); END$$

DROP PROCEDURE IF EXISTS sp_CuentaActualizar$$
CREATE PROCEDURE sp_CuentaActualizar(IN pUsuario VARCHAR(40), IN pPassword VARCHAR(255), IN pEmail VARCHAR(100), IN pEstado VARCHAR(20))
BEGIN UPDATE Cuenta SET password = pPassword, email = pEmail, estado = pEstado WHERE usuario = pUsuario; END$$

-- ===== CLIENTE =====
DROP PROCEDURE IF EXISTS sp_ClienteListar$$
CREATE PROCEDURE sp_ClienteListar()
BEGIN SELECT ci, nombres, apPaterno, apMaterno, correo, direccion, nroCelular, usuarioCuenta, fechaRegistro, estado FROM Cliente; END$$

DROP PROCEDURE IF EXISTS sp_ClienteObtener$$
CREATE PROCEDURE sp_ClienteObtener(IN pCi VARCHAR(20))
BEGIN SELECT ci, nombres, apPaterno, apMaterno, correo, direccion, nroCelular, usuarioCuenta, fechaRegistro, estado FROM Cliente WHERE ci = pCi; END$$

DROP PROCEDURE IF EXISTS sp_ClienteInsertar$$
CREATE PROCEDURE sp_ClienteInsertar(IN pCi VARCHAR(20), IN pNombres VARCHAR(50), IN pApPaterno VARCHAR(30), IN pApMaterno VARCHAR(30), IN pCorreo VARCHAR(50), IN pDireccion VARCHAR(100), IN pNroCelular VARCHAR(15), IN pUsuarioCuenta VARCHAR(40), IN pEstado VARCHAR(20))
BEGIN INSERT INTO Cliente (ci, nombres, apPaterno, apMaterno, correo, direccion, nroCelular, usuarioCuenta, estado) VALUES (pCi, pNombres, pApPaterno, pApMaterno, pCorreo, pDireccion, pNroCelular, pUsuarioCuenta, pEstado); END$$

DROP PROCEDURE IF EXISTS sp_ClienteActualizar$$
CREATE PROCEDURE sp_ClienteActualizar(IN pCi VARCHAR(20), IN pNombres VARCHAR(50), IN pApPaterno VARCHAR(30), IN pApMaterno VARCHAR(30), IN pCorreo VARCHAR(50), IN pDireccion VARCHAR(100), IN pNroCelular VARCHAR(15), IN pEstado VARCHAR(20))
BEGIN UPDATE Cliente SET nombres = pNombres, apPaterno = pApPaterno, apMaterno = pApMaterno, correo = pCorreo, direccion = pDireccion, nroCelular = pNroCelular, estado = pEstado WHERE ci = pCi; END$$

-- ===== CATEGORIA =====
DROP PROCEDURE IF EXISTS sp_CategoriaListar$$
CREATE PROCEDURE sp_CategoriaListar()
BEGIN SELECT cod, nombre, descripcion FROM Categoria; END$$

-- ===== MARCA =====
DROP PROCEDURE IF EXISTS sp_MarcaListar$$
CREATE PROCEDURE sp_MarcaListar()
BEGIN SELECT cod, nombre, descripcion FROM Marca; END$$

-- ===== INDUSTRIA =====
DROP PROCEDURE IF EXISTS sp_IndustriaListar$$
CREATE PROCEDURE sp_IndustriaListar()
BEGIN SELECT cod, nombre FROM Industria; END$$

-- ===== PRODUCTO =====
DROP PROCEDURE IF EXISTS sp_ProductoListar$$
CREATE PROCEDURE sp_ProductoListar()
BEGIN SELECT p.cod, p.nombre, p.descripcion, p.precio, p.imagen, p.estado, m.nombre AS nombreMarca, i.nombre AS nombreIndustria, c.nombre AS nombreCategoria FROM Producto p LEFT JOIN Marca m ON p.codMarca = m.cod LEFT JOIN Industria i ON p.codIndustria = i.cod LEFT JOIN Categoria c ON p.codCategoria = c.cod WHERE p.estado = 'disponible'; END$$

DROP PROCEDURE IF EXISTS sp_ProductoObtener$$
CREATE PROCEDURE sp_ProductoObtener(IN pCod INT)
BEGIN SELECT cod, nombre, descripcion, precio, imagen, estado FROM Producto WHERE cod = pCod AND estado = 'disponible'; END$$

-- ===== SUCURSAL =====
DROP PROCEDURE IF EXISTS sp_SucursalListar$$
CREATE PROCEDURE sp_SucursalListar()
BEGIN SELECT cod, nombre, direccion, nroTelefono FROM Sucursal WHERE estado = 'activa'; END$$

-- ===== FORMA PAGO =====
DROP PROCEDURE IF EXISTS sp_FormaPagoListar$$
CREATE PROCEDURE sp_FormaPagoListar()
BEGIN SELECT cod, nombre FROM FormaPago WHERE estado = 'activa'; END$$

-- ===== NOTA VENTA =====
DROP PROCEDURE IF EXISTS sp_NotaVentaListar$$
CREATE PROCEDURE sp_NotaVentaListar()
BEGIN SELECT nro, fechaHora, ciCliente, totalVenta, estado, observaciones FROM NotaVenta; END$$

DROP PROCEDURE IF EXISTS sp_NotaVentaObtener$$
CREATE PROCEDURE sp_NotaVentaObtener(IN pNro INT)
BEGIN SELECT nro, fechaHora, ciCliente, totalVenta, estado, observaciones FROM NotaVenta WHERE nro = pNro; END$$

DROP PROCEDURE IF EXISTS sp_NotaVentaInsertar$$
CREATE PROCEDURE sp_NotaVentaInsertar(IN pCiCliente VARCHAR(20), IN pObservaciones VARCHAR(200))
BEGIN INSERT INTO NotaVenta (ciCliente, observaciones, estado) VALUES (pCiCliente, pObservaciones, 'pendiente'); END$$

DROP PROCEDURE IF EXISTS sp_NotaVentaActualizar$$
CREATE PROCEDURE sp_NotaVentaActualizar(IN pNro INT, IN pTotal DECIMAL(15,2), IN pEstado VARCHAR(20))
BEGIN UPDATE NotaVenta SET totalVenta = pTotal, estado = pEstado WHERE nro = pNro; END$$

DROP PROCEDURE IF EXISTS sp_NotaVentaActualizarEstado$$
CREATE PROCEDURE sp_NotaVentaActualizarEstado(IN pNro INT, IN pEstado VARCHAR(20))
BEGIN UPDATE NotaVenta SET estado = pEstado WHERE nro = pNro; END$$

-- ===== DETALLE NOTA VENTA =====
DROP PROCEDURE IF EXISTS sp_DetalleNotaVentaListar$$
CREATE PROCEDURE sp_DetalleNotaVentaListar(IN pNroNotaVenta INT)
BEGIN SELECT nroNotaVenta, codProducto, item, cant, precioUnitario, subtotal FROM DetalleNotaVenta WHERE nroNotaVenta = pNroNotaVenta; END$$

DROP PROCEDURE IF EXISTS sp_DetalleNotaVentaInsertar$$
CREATE PROCEDURE sp_DetalleNotaVentaInsertar(IN pNroNotaVenta INT, IN pCodProducto INT, IN pItem INT, IN pCant INT, IN pPrecioUnitario DECIMAL(10,2), IN pSubtotal DECIMAL(15,2))
BEGIN INSERT INTO DetalleNotaVenta (nroNotaVenta, codProducto, item, cant, precioUnitario, subtotal) VALUES (pNroNotaVenta, pCodProducto, pItem, pCant, pPrecioUnitario, pSubtotal); END$$

-- ===== DETALLE PRODUCTO SUCURSAL =====
DROP PROCEDURE IF EXISTS sp_DetalleProductoSucursalListar$$
CREATE PROCEDURE sp_DetalleProductoSucursalListar()
BEGIN SELECT codProducto, codSucursal, stock, stockMinimo FROM DetalleProductoSucursal; END$$

DROP PROCEDURE IF EXISTS sp_DetalleProductoSucursalObtener$$
CREATE PROCEDURE sp_DetalleProductoSucursalObtener(IN pCodProducto INT, IN pCodSucursal INT)
BEGIN SELECT codProducto, codSucursal, stock, stockMinimo FROM DetalleProductoSucursal WHERE codProducto = pCodProducto AND codSucursal = pCodSucursal; END$$

-- ===== CHAT CLIENTE =====
DROP PROCEDURE IF EXISTS sp_ConversacionObtenerPorCliente$$
CREATE PROCEDURE sp_ConversacionObtenerPorCliente(IN pClienteCi VARCHAR(20))
BEGIN SELECT id, cliente_ci, admin_usuario, estado, fechaInicio, fechaFin FROM Conversacion WHERE cliente_ci = pClienteCi AND estado = 'activa' ORDER BY fechaInicio DESC LIMIT 1; END$$

DROP PROCEDURE IF EXISTS sp_MensajeListar$$
CREATE PROCEDURE sp_MensajeListar(IN pConversacionId INT)
BEGIN SELECT id, conversacion_id, remitente, tipo, contenido, leido, fechaHora FROM Mensaje WHERE conversacion_id = pConversacionId ORDER BY fechaHora ASC; END$$

DROP PROCEDURE IF EXISTS sp_MensajeInsertar$$
CREATE PROCEDURE sp_MensajeInsertar(IN pConversacionId INT, IN pRemitente VARCHAR(40), IN pTipo VARCHAR(20), IN pContenido TEXT)
BEGIN INSERT INTO Mensaje (conversacion_id, remitente, tipo, contenido) VALUES (pConversacionId, pRemitente, pTipo, pContenido); END$$

DROP PROCEDURE IF EXISTS sp_MensajeUltimoId$$
CREATE PROCEDURE sp_MensajeUltimoId(IN pConversacionId INT)
BEGIN SELECT MAX(id) AS ultimoId FROM Mensaje WHERE conversacion_id = pConversacionId; END$$

DROP PROCEDURE IF EXISTS sp_MensajeNoLeidos$$
CREATE PROCEDURE sp_MensajeNoLeidos(IN pConversacionId INT, IN pRemitente VARCHAR(40))
BEGIN SELECT COUNT(*) AS noLeidos FROM Mensaje WHERE conversacion_id = pConversacionId AND remitente != pRemitente AND leido = 0; END$$

DELIMITER ;