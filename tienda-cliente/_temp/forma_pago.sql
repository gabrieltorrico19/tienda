-- =====================================================
-- FORMAS DE PAGO (CLIENTE)
-- =====================================================

-- Tabla de formas de pago
CREATE TABLE IF NOT EXISTS `FormaPago` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL UNIQUE,
  `descripcion` VARCHAR(200),
  `estado` ENUM('activa', 'inactiva') DEFAULT 'activa',
  PRIMARY KEY (`cod`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Columna en NotaVenta para relacionar forma de pago
ALTER TABLE `NotaVenta`
  ADD COLUMN IF NOT EXISTS `codFormaPago` INT NULL,
  ADD KEY `fk_NotaVenta_FormaPago` (`codFormaPago`),
  ADD CONSTRAINT `fk_NotaVenta_FormaPago`
    FOREIGN KEY (`codFormaPago`) REFERENCES `FormaPago` (`cod`)
    ON DELETE SET NULL
    ON UPDATE CASCADE;

-- =====================================================
-- PROCEDIMIENTOS ALMACENADOS
-- =====================================================

DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_FormaPagoListar` $$
CREATE PROCEDURE `sp_FormaPagoListar`()
BEGIN
  SELECT * FROM FormaPago ORDER BY nombre;
END$$

DROP PROCEDURE IF EXISTS `sp_FormaPagoObtener` $$
CREATE PROCEDURE `sp_FormaPagoObtener`(IN p_cod INT)
BEGIN
  SELECT * FROM FormaPago WHERE cod = p_cod LIMIT 1;
END$$

DROP PROCEDURE IF EXISTS `sp_FormaPagoInsertar` $$
CREATE PROCEDURE `sp_FormaPagoInsertar`(
  IN p_nombre VARCHAR(50),
  IN p_descripcion VARCHAR(200),
  IN p_estado ENUM('activa', 'inactiva')
)
BEGIN
  INSERT INTO FormaPago (nombre, descripcion, estado)
  VALUES (p_nombre, p_descripcion, p_estado);
END$$

DROP PROCEDURE IF EXISTS `sp_FormaPagoActualizar` $$
CREATE PROCEDURE `sp_FormaPagoActualizar`(
  IN p_cod INT,
  IN p_nombre VARCHAR(50),
  IN p_descripcion VARCHAR(200),
  IN p_estado ENUM('activa', 'inactiva')
)
BEGIN
  UPDATE FormaPago
  SET nombre = p_nombre,
      descripcion = p_descripcion,
      estado = p_estado
  WHERE cod = p_cod;
END$$

DROP PROCEDURE IF EXISTS `sp_FormaPagoEliminar` $$
CREATE PROCEDURE `sp_FormaPagoEliminar`(IN p_cod INT)
BEGIN
  UPDATE FormaPago SET estado = 'inactiva' WHERE cod = p_cod;
END$$

DROP PROCEDURE IF EXISTS `sp_NotaVentaAsignarFormaPago` $$
CREATE PROCEDURE `sp_NotaVentaAsignarFormaPago`(
  IN p_nro INT,
  IN p_codFormaPago INT
)
BEGIN
  UPDATE NotaVenta
  SET codFormaPago = p_codFormaPago
  WHERE nro = p_nro;
END$$

DELIMITER ;
