
Create Table perfil(
    idPerfil int not null auto_increment,
    hashPerfil varchar(50),
    nombre varchar(100) not null,
    descripcion text,
    estado enum('Activo', 'Inactivo') not null,
    Constraint PK_Perfil primary key (idPerfil)
) engine=InnoDB charset=utf8mb4;

Create Table usuario(
    idUsuario int not null auto_increment,
    hashUsuario varchar(50),
    nombre varchar(100) not null,
    username varchar(100) not null,
    pswd blob not null,
    idPerfil int not null,
    estado enum('Activo', 'Inactivo') not null,
    Constraint PK_Usuario primary key (idUsuario),
    Constraint FK_Usuario foreign key (idPerfil) references perfil(idPerfil)
) engine=InnoDB charset=utf8mb4;

CREATE TABLE IF NOT EXISTS tipopizza (
	idTipoPizza INT NOT NULL AUTO_INCREMENT,
	hashTipoPizza VARCHAR(50),
	nombre VARCHAR(100) NOT NULL,
	descripcion TEXT,
	imagen VARCHAR(100),
	estado ENUM('Activo', 'Inactivo') NOT NULL,
	CONSTRAINT PK_TipoPizza PRIMARY KEY (idTipoPizza),
	CONSTRAINT UQ_TipoPizza_Nombre UNIQUE (nombre)
) ENGINE=InnoDB CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tamanho (
	idTamanho INT NOT NULL AUTO_INCREMENT,
	hashTamanho VARCHAR(50),
	nombre VARCHAR(50) NOT NULL,
	precio DECIMAL(10,2) NOT NULL,
	estado ENUM('Activo', 'Inactivo') NOT NULL,
	CONSTRAINT PK_Tamanho PRIMARY KEY (idTamanho),
	CONSTRAINT UQ_Tamanho_Nombre UNIQUE (nombre)
) ENGINE=InnoDB CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tarifaentrega (
	idTarifaEntrega INT NOT NULL AUTO_INCREMENT,
	hashTarifaEntrega VARCHAR(50),
	zona VARCHAR(100) NOT NULL,
	precioDelivery DECIMAL(10,2) NOT NULL,
	estado ENUM('Activo', 'Inactivo') NOT NULL,
	CONSTRAINT PK_TarifaEntrega PRIMARY KEY (idTarifaEntrega),
	CONSTRAINT UQ_TarifaEntrega_Zona UNIQUE (zona)
) ENGINE=InnoDB CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS cliente (
	idCliente INT NOT NULL AUTO_INCREMENT,
	hashCliente VARCHAR(50),
	nombre VARCHAR(100) NOT NULL,
	telefono VARCHAR(20),
	direccion VARCHAR(200),
	estado ENUM('Activo', 'Inactivo') NOT NULL,
	CONSTRAINT PK_Cliente PRIMARY KEY (idCliente)
) ENGINE=InnoDB CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS venta (
	idVenta INT NOT NULL AUTO_INCREMENT,
	hashVenta VARCHAR(50),
	fechaVenta DATE NOT NULL,
	horaVenta TIME NOT NULL,
	total DECIMAL(10,2) NOT NULL,
	idCliente INT NOT NULL,
	idUsuario INT NOT NULL,
	idTarifaEntrega INT NOT NULL,
	observacion VARCHAR(150),
	estado ENUM('Activo', 'Inactivo') NOT NULL,
	CONSTRAINT PK_Venta PRIMARY KEY (idVenta),
	CONSTRAINT FK_Venta_Cliente FOREIGN KEY (idCliente) REFERENCES cliente(idCliente),
	CONSTRAINT FK_Venta_Usuario FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario),
	CONSTRAINT FK_Venta_Tarifa FOREIGN KEY (idTarifaEntrega) REFERENCES tarifaentrega(idTarifaEntrega)
) ENGINE=InnoDB CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS venta_item (
	idVenta INT NOT NULL,
	idTipoPizza INT NOT NULL,
	idTamanho INT NOT NULL,
	hashVentaItem VARCHAR(50),
	cantidad INT NOT NULL,
	precioUnitario DECIMAL(10,2) NOT NULL,
	subtotal DECIMAL(10,2) NOT NULL,
	estado ENUM('Activo', 'Inactivo') NOT NULL,
	CONSTRAINT PK_VentaItem PRIMARY KEY (idVenta, idTipoPizza, idTamanho),
	CONSTRAINT FK_VentaItem_Venta FOREIGN KEY (idVenta) REFERENCES venta(idVenta),
	CONSTRAINT FK_VentaItem_TipoPizza FOREIGN KEY (idTipoPizza) REFERENCES tipopizza(idTipoPizza),
	CONSTRAINT FK_VentaItem_Tamanho FOREIGN KEY (idTamanho) REFERENCES tamanho(idTamanho)
) ENGINE=InnoDB CHARSET=utf8mb4;


