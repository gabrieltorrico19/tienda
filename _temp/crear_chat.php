<?php
require_once "../tienda-cliente/model/data/DB.php";

$db = new DataBase();
$conn = $db->Open();

$sql = "
CREATE TABLE IF NOT EXISTS `Conversacion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cliente_ci` VARCHAR(20) NOT NULL,
  `admin_usuario` VARCHAR(40) NOT NULL,
  `estado` ENUM('activa', 'cerrada') DEFAULT 'activa',
  `fechaInicio` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `fechaFin` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `idx_cliente` (`cliente_ci`),
  KEY `idx_admin` (`admin_usuario`),
  KEY `idx_estado` (`estado`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS `Mensaje` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `conversacion_id` INT NOT NULL,
  `remitente` VARCHAR(40) NOT NULL,
  `tipo` ENUM('cliente', 'admin') NOT NULL,
  `contenido` TEXT NOT NULL,
  `leido` TINYINT(1) DEFAULT 0,
  `fechaHora` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_conversacion` (`conversacion_id`),
  KEY `idx_remitente` (`remitente`),
  KEY `idx_fecha` (`fechaHora`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
";

if (mysqli_multi_query($conn, $sql)) {
    echo "Tablas creadas correctamente.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>