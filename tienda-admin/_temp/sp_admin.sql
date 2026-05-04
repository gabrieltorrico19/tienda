-- =====================================================
-- PROCEDIMIENTOS ALMACENADOS - TIENDA ADMIN
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

DROP PROCEDURE IF EXISTS sp_CuentaEliminar$$
CREATE PROCEDURE sp_CuentaEliminar(IN pUsuario VARCHAR(40))
BEGIN DELETE FROM Cliente WHERE usuarioCuenta = pUsuario; DELETE FROM Cuenta WHERE usuario = pUsuario; END$$

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

DROP PROCEDURE IF EXISTS sp_ClienteEliminar$$
CREATE PROCEDURE sp_ClienteEliminar(IN pCi VARCHAR(20))
BEGIN DELETE FROM NotaVenta WHERE ciCliente = pCi; DELETE FROM Cliente WHERE ci = pCi; END$$

-- ===== CATEGORIA =====
DROP PROCEDURE IF EXISTS sp_CategoriaListar$$
CREATE PROCEDURE sp_CategoriaListar()
BEGIN SELECT cod, nombre, descripcion FROM Categoria; END$$

DROP PROCEDURE IF EXISTS sp_CategoriaObtener$$
CREATE PROCEDURE sp_CategoriaObtener(IN pCod INT)
BEGIN SELECT cod, nombre, descripcion FROM Categoria WHERE cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_CategoriaInsertar$$
CREATE PROCEDURE sp_CategoriaInsertar(IN pNombre VARCHAR(50), IN pDescripcion VARCHAR(200))
BEGIN INSERT INTO Categoria (nombre, descripcion) VALUES (pNombre, pDescripcion); END$$

DROP PROCEDURE IF EXISTS sp_CategoriaActualizar$$
CREATE PROCEDURE sp_CategoriaActualizar(IN pCod INT, IN pNombre VARCHAR(50), IN pDescripcion VARCHAR(200))
BEGIN UPDATE Categoria SET nombre = pNombre, descripcion = pDescripcion WHERE cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_CategoriaEliminar$$
CREATE PROCEDURE sp_CategoriaEliminar(IN pCod INT)
BEGIN DELETE FROM Producto WHERE codCategoria = pCod; DELETE FROM Categoria WHERE cod = pCod; END$$

-- ===== MARCA =====
DROP PROCEDURE IF EXISTS sp_MarcaListar$$
CREATE PROCEDURE sp_MarcaListar()
BEGIN SELECT cod, nombre, descripcion FROM Marca; END$$

DROP PROCEDURE IF EXISTS sp_MarcaObtener$$
CREATE PROCEDURE sp_MarcaObtener(IN pCod INT)
BEGIN SELECT cod, nombre, descripcion FROM Marca WHERE cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_MarcaInsertar$$
CREATE PROCEDURE sp_MarcaInsertar(IN pNombre VARCHAR(50), IN pDescripcion VARCHAR(200))
BEGIN INSERT INTO Marca (nombre, descripcion) VALUES (pNombre, pDescripcion); END$$

DROP PROCEDURE IF EXISTS sp_MarcaActualizar$$
CREATE PROCEDURE sp_MarcaActualizar(IN pCod INT, IN pNombre VARCHAR(50), IN pDescripcion VARCHAR(200))
BEGIN UPDATE Marca SET nombre = pNombre, descripcion = pDescripcion WHERE cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_MarcaEliminar$$
CREATE PROCEDURE sp_MarcaEliminar(IN pCod INT)
BEGIN DELETE FROM Producto WHERE codMarca = pCod; DELETE FROM Marca WHERE cod = pCod; END$$

-- ===== INDUSTRIA =====
DROP PROCEDURE IF EXISTS sp_IndustriaListar$$
CREATE PROCEDURE sp_IndustriaListar()
BEGIN SELECT cod, nombre FROM Industria; END$$

DROP PROCEDURE IF EXISTS sp_IndustriaObtener$$
CREATE PROCEDURE sp_IndustriaObtener(IN pCod INT)
BEGIN SELECT cod, nombre FROM Industria WHERE cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_IndustriaInsertar$$
CREATE PROCEDURE sp_IndustriaInsertar(IN pNombre VARCHAR(50))
BEGIN INSERT INTO Industria (nombre) VALUES (pNombre); END$$

DROP PROCEDURE IF EXISTS sp_IndustriaActualizar$$
CREATE PROCEDURE sp_IndustriaActualizar(IN pCod INT, IN pNombre VARCHAR(50))
BEGIN UPDATE Industria SET nombre = pNombre WHERE cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_IndustriaEliminar$$
CREATE PROCEDURE sp_IndustriaEliminar(IN pCod INT)
BEGIN DELETE FROM Producto WHERE codIndustria = pCod; DELETE FROM Industria WHERE cod = pCod; END$$

-- ===== FORMA PAGO =====
DROP PROCEDURE IF EXISTS sp_FormaPagoListar$$
CREATE PROCEDURE sp_FormaPagoListar()
BEGIN SELECT cod, nombre, estado FROM FormaPago; END$$

DROP PROCEDURE IF EXISTS sp_FormaPagoObtener$$
CREATE PROCEDURE sp_FormaPagoObtener(IN pCod INT)
BEGIN SELECT cod, nombre, estado FROM FormaPago WHERE cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_FormaPagoInsertar$$
CREATE PROCEDURE sp_FormaPagoInsertar(IN pNombre VARCHAR(50), IN pEstado VARCHAR(20))
BEGIN INSERT INTO FormaPago (nombre, estado) VALUES (pNombre, pEstado); END$$

DROP PROCEDURE IF EXISTS sp_FormaPagoActualizar$$
CREATE PROCEDURE sp_FormaPagoActualizar(IN pCod INT, IN pNombre VARCHAR(50), IN pEstado VARCHAR(20))
BEGIN UPDATE FormaPago SET nombre = pNombre, estado = pEstado WHERE cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_FormaPagoEliminar$$
CREATE PROCEDURE sp_FormaPagoEliminar(IN pCod INT)
BEGIN DELETE FROM FormaPago WHERE cod = pCod; END$$

-- ===== SUCURSAL =====
DROP PROCEDURE IF EXISTS sp_SucursalListar$$
CREATE PROCEDURE sp_SucursalListar()
BEGIN SELECT cod, nombre, direccion, nroTelefono, estado, fechaCreacion FROM Sucursal; END$$

DROP PROCEDURE IF EXISTS sp_SucursalObtener$$
CREATE PROCEDURE sp_SucursalObtener(IN pCod INT)
BEGIN SELECT cod, nombre, direccion, nroTelefono, estado, fechaCreacion FROM Sucursal WHERE cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_SucursalInsertar$$
CREATE PROCEDURE sp_SucursalInsertar(IN pNombre VARCHAR(50), IN pDireccion VARCHAR(150), IN pNroTelefono VARCHAR(15), IN pEstado VARCHAR(20))
BEGIN INSERT INTO Sucursal (nombre, direccion, nroTelefono, estado) VALUES (pNombre, pDireccion, pNroTelefono, pEstado); END$$

DROP PROCEDURE IF EXISTS sp_SucursalActualizar$$
CREATE PROCEDURE sp_SucursalActualizar(IN pCod INT, IN pNombre VARCHAR(50), IN pDireccion VARCHAR(150), IN pNroTelefono VARCHAR(15), IN pEstado VARCHAR(20))
BEGIN UPDATE Sucursal SET nombre = pNombre, direccion = pDireccion, nroTelefono = pNroTelefono, estado = pEstado WHERE cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_SucursalEliminar$$
CREATE PROCEDURE sp_SucursalEliminar(IN pCod INT)
BEGIN DELETE FROM DetalleProductoSucursal WHERE codSucursal = pCod; DELETE FROM Sucursal WHERE cod = pCod; END$$

-- ===== PRODUCTO =====
DROP PROCEDURE IF EXISTS sp_ProductoListar$$
CREATE PROCEDURE sp_ProductoListar()
BEGIN SELECT p.cod, p.nombre, p.descripcion, p.precio, p.imagen, p.estado, m.cod AS codMarca, m.nombre AS nombreMarca, i.cod AS codIndustria, i.nombre AS nombreIndustria, c.cod AS codCategoria, c.nombre AS nombreCategoria FROM Producto p LEFT JOIN Marca m ON p.codMarca = m.cod LEFT JOIN Industria i ON p.codIndustria = i.cod LEFT JOIN Categoria c ON p.codCategoria = c.cod; END$$

DROP PROCEDURE IF EXISTS sp_ProductoObtener$$
CREATE PROCEDURE sp_ProductoObtener(IN pCod INT)
BEGIN SELECT p.cod, p.nombre, p.descripcion, p.precio, p.imagen, p.estado, p.codMarca, p.codIndustria, p.codCategoria, m.nombre AS nombreMarca, i.nombre AS nombreIndustria, c.nombre AS nombreCategoria FROM Producto p LEFT JOIN Marca m ON p.codMarca = m.cod LEFT JOIN Industria i ON p.codIndustria = i.cod LEFT JOIN Categoria c ON p.codCategoria = c.cod WHERE p.cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_ProductoInsertar$$
CREATE PROCEDURE sp_ProductoInsertar(IN pNombre VARCHAR(100), IN pDescripcion TEXT, IN pPrecio DECIMAL(10,2), IN pImagen VARCHAR(255), IN pEstado VARCHAR(20), IN pCodMarca INT, IN pCodIndustria INT, IN pCodCategoria INT)
BEGIN INSERT INTO Producto (nombre, descripcion, precio, imagen, estado, codMarca, codIndustria, codCategoria) VALUES (pNombre, pDescripcion, pPrecio, pImagen, pEstado, pCodMarca, pCodIndustria, pCodCategoria); END$$

DROP PROCEDURE IF EXISTS sp_ProductoActualizar$$
CREATE PROCEDURE sp_ProductoActualizar(IN pCod INT, IN pNombre VARCHAR(100), IN pDescripcion TEXT, IN pPrecio DECIMAL(10,2), IN pImagen VARCHAR(255), IN pEstado VARCHAR(20), IN pCodMarca INT, IN pCodIndustria INT, IN pCodCategoria INT)
BEGIN UPDATE Producto SET nombre = pNombre, descripcion = pDescripcion, precio = pPrecio, imagen = COALESCE(NULLIF(pImagen, ''), imagen), estado = pEstado, codMarca = pCodMarca, codIndustria = pCodIndustria, codCategoria = pCodCategoria WHERE cod = pCod; END$$

DROP PROCEDURE IF EXISTS sp_ProductoEliminar$$
CREATE PROCEDURE sp_ProductoEliminar(IN pCod INT)
BEGIN DELETE FROM DetalleNotaVenta WHERE codProducto = pCod; DELETE FROM DetalleProductoSucursal WHERE codProducto = pCod; DELETE FROM Producto WHERE cod = pCod; END$$

-- ===== DETALLE PRODUCTO SUCURSAL =====
DROP PROCEDURE IF EXISTS sp_DetalleProductoSucursalListar$$
CREATE PROCEDURE sp_DetalleProductoSucursalListar()
BEGIN SELECT dps.codProducto, dps.codSucursal, dps.stock, dps.stockMinimo, dps.fechaActualizacion, p.nombre AS nombreProducto, s.nombre AS nombreSucursal FROM DetalleProductoSucursal dps LEFT JOIN Producto p ON dps.codProducto = p.cod LEFT JOIN Sucursal s ON dps.codSucursal = s.cod; END$$

DROP PROCEDURE IF EXISTS sp_DetalleProductoSucursalObtener$$
CREATE PROCEDURE sp_DetalleProductoSucursalObtener(IN pCodProducto INT, IN pCodSucursal INT)
BEGIN SELECT codProducto, codSucursal, stock, stockMinimo, fechaActualizacion FROM DetalleProductoSucursal WHERE codProducto = pCodProducto AND codSucursal = pCodSucursal; END$$

DROP PROCEDURE IF EXISTS sp_ConsultarInventario$$
CREATE PROCEDURE sp_ConsultarInventario(IN pCodSucursal INT)
BEGIN SELECT p.cod, p.nombre, p.precio, dps.stock, dps.stockMinimo FROM Producto p LEFT JOIN DetalleProductoSucursal dps ON p.cod = dps.codProducto AND dps.codSucursal = pCodSucursal WHERE p.estado = 'disponible'; END$$

DROP PROCEDURE IF EXISTS sp_ActualizarStock$$
CREATE PROCEDURE sp_ActualizarStock(IN pCodProducto INT, IN pCodSucursal INT, IN pStock INT, IN pStockMinimo INT)
BEGIN INSERT INTO DetalleProductoSucursal (codProducto, codSucursal, stock, stockMinimo) VALUES (pCodProducto, pCodSucursal, pStock, pStockMinimo) ON DUPLICATE KEY UPDATE stock = pStock, stockMinimo = pStockMinimo; END$$

-- ===== NOTA VENTA =====
DROP PROCEDURE IF EXISTS sp_NotaVentaListar$$
CREATE PROCEDURE sp_NotaVentaListar()
BEGIN SELECT n.nro, n.fechaHora, n.ciCliente, n.totalVenta, n.estado, n.observaciones, c.nombres, c.apPaterno FROM NotaVenta n LEFT JOIN Cliente c ON n.ciCliente = c.ci ORDER BY n.fechaHora DESC; END$$

DROP PROCEDURE IF EXISTS sp_NotaVentaObtener$$
CREATE PROCEDURE sp_NotaVentaObtener(IN pNro INT)
BEGIN SELECT nro, fechaHora, ciCliente, totalVenta, estado, observaciones FROM NotaVenta WHERE nro = pNro; END$$

DROP PROCEDURE IF EXISTS sp_NotaVentaActualizarEstado$$
CREATE PROCEDURE sp_NotaVentaActualizarEstado(IN pNro INT, IN pEstado VARCHAR(20))
BEGIN UPDATE NotaVenta SET estado = pEstado WHERE nro = pNro; END$$

DROP PROCEDURE IF EXISTS sp_InsertarVenta$$
CREATE PROCEDURE sp_InsertarVenta(IN pCiCliente VARCHAR(20), IN pObservaciones VARCHAR(200))
BEGIN INSERT INTO NotaVenta (ciCliente, observaciones, estado) VALUES (pCiCliente, pObservaciones, 'pendiente'); END$$

-- ===== DETALLE NOTA VENTA =====
DROP PROCEDURE IF EXISTS sp_DetalleNotaVentaListar$$
CREATE PROCEDURE sp_DetalleNotaVentaListar(IN pNroNotaVenta INT)
BEGIN SELECT d.nroNotaVenta, d.codProducto, d.item, d.cant, d.precioUnitario, d.subtotal, p.nombre AS nombreProducto FROM DetalleNotaVenta d LEFT JOIN Producto p ON d.codProducto = p.cod WHERE d.nroNotaVenta = pNroNotaVenta ORDER BY d.item; END$$

DROP PROCEDURE IF EXISTS sp_AgregarDetalleVenta$$
CREATE PROCEDURE sp_AgregarDetalleVenta(IN pNroNotaVenta INT, IN pCodProducto INT, IN pCantidad INT, IN pItem INT)
BEGIN INSERT INTO DetalleNotaVenta (nroNotaVenta, codProducto, item, cant, precioUnitario, subtotal) VALUES (pNroNotaVenta, pCodProducto, pItem, pCantidad, (SELECT precio FROM Producto WHERE cod = pCodProducto), (SELECT precio * pCantidad FROM Producto WHERE cod = pCodProducto)); END$$

-- ===== CHAT =====
DROP PROCEDURE IF EXISTS sp_ConversacionListar$$
CREATE PROCEDURE sp_ConversacionListar()
BEGIN SELECT id, cliente_ci, admin_usuario, estado, fechaInicio, fechaFin FROM Conversacion ORDER BY fechaInicio DESC; END$$

DROP PROCEDURE IF EXISTS sp_ConversacionObtener$$
CREATE PROCEDURE sp_ConversacionObtener(IN pId INT)
BEGIN SELECT id, cliente_ci, admin_usuario, estado, fechaInicio, fechaFin FROM Conversacion WHERE id = pId; END$$

DROP PROCEDURE IF EXISTS sp_ConversacionInsertar$$
CREATE PROCEDURE sp_ConversacionInsertar(IN pClienteCi VARCHAR(20), IN pAdminUsuario VARCHAR(40))
BEGIN INSERT INTO Conversacion (cliente_ci, admin_usuario, estado) VALUES (pClienteCi, pAdminUsuario, 'activa'); END$$

DROP PROCEDURE IF EXISTS sp_ConversacionCerrar$$
CREATE PROCEDURE sp_ConversacionCerrar(IN pId INT)
BEGIN UPDATE Conversacion SET estado = 'cerrada', fechaFin = NOW() WHERE id = pId; END$$

DROP PROCEDURE IF EXISTS sp_MensajeListar$$
CREATE PROCEDURE sp_MensajeListar(IN pConversacionId INT)
BEGIN SELECT id, conversacion_id, remitente, tipo, contenido, leido, fechaHora FROM Mensaje WHERE conversacion_id = pConversacionId ORDER BY fechaHora ASC; END$$

DROP PROCEDURE IF EXISTS sp_MensajeInsertar$$
CREATE PROCEDURE sp_MensajeInsertar(IN pConversacionId INT, IN pRemitente VARCHAR(40), IN pTipo VARCHAR(20), IN pContenido TEXT)
BEGIN INSERT INTO Mensaje (conversacion_id, remitente, tipo, contenido) VALUES (pConversacionId, pRemitente, pTipo, pContenido); END$$

DROP PROCEDURE IF EXISTS sp_MensajeMarcarLeido$$
CREATE PROCEDURE sp_MensajeMarcarLeido(IN pConversacionId INT, IN pRemitente VARCHAR(40))
BEGIN UPDATE Mensaje SET leido = 1 WHERE conversacion_id = pConversacionId AND remitente != pRemitente; END$$

DELIMITER ;