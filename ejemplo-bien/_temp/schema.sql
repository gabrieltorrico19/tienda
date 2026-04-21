-- --
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

-- Medicamentos --
Create Table mundial(
    idMundial int not null auto_increment,
    hashMundial varchar(50),
    nombre varchar(100) not null,
    anho int,
    estado enum('Activo', 'Inactivo') not null,
    Constraint PK_Mundial primary key (idMundial)
) engine=InnoDB charset=utf8mb4;

Create Table ciudad(
    idCiudad int not null auto_increment,
    hashCiudad varchar(50),
    nombre varchar(100) not null,
    imagen varchar(50),
    idMundial int not null,
    estado enum('Activo', 'Inactivo') not null,
    Constraint PK_Ciudad primary key (idCiudad),
    Constraint FK_Ciudad foreign key (idMundial) references mundial(idMundial)
) engine=InnoDB charset=utf8mb4;

Create Table estadio(
    idEstadio int not null auto_increment,
    hashEstadio varchar(50),
    nombre varchar(100) not null,
    capacidad int not null,
    imagen varchar(50),
    idCiudad int not null,
    estado enum('Activo', 'Inactivo') not null,
    Constraint PK_Estadio primary key (idEstadio),
    Constraint FK_Estadio foreign key (idCiudad) references ciudad(idCiudad)
) engine=InnoDB charset=utf8mb4;