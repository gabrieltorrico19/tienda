# Documentación Técnica del Proyecto Tienda E-Commerce

## 1. Visión General del Proyecto

### 1.1 Descripción del Sistema

El proyecto **Tienda E-Commerce** es una aplicación web completa de comercio electrónico desarrollada en **PHP vanilla** (sin framework) que implements two complete applications:

- **Tienda Admin**: Panel de administración para gestionar productos, usuarios, inventarios y más.
- **Tienda Cliente**: Tienda en línea para que los clientes browsen productos, agreguen al carrito y realicen compras.

### 1.2 Tecnología Utilizada

```
┌─────────────────────────────────────────────────────────────────┐
│                    STACK TECNOLÓGICO                          │
├─────────────────────────────────────────────────────────────────┤
│ Lenguaje:           PHP 8.2+ (Vanilla)                        │
│ Base de Datos:       MySQL (MariaDB via XAMPP)                │
│ Servidor:           Apache (XAMPP)                           │
│ Frontend:           HTML5, CSS3, Bootstrap 4.5, JavaScript   │
│ PDF Generation:     Dompdf                                 │
└─────────────────────────────────────────────────────────────────┘
```

### 1.3 Estructura General del Proyecto

```
tienda/
├── tienda-admin/           # Aplicación de Administración
│   ├── control/           # Controladores (C)
│   ├── model/             # Modelos y Datos (M)
│   │   ├── data/           # Entidades/Clases
│   │   └── RN_*.php       # Reglas de Negocio
│   ├── view/              # Vistas (V)
│   │   ├── css/           # Estilos
│   │   ├── Usuario/       # Módulo Usuario
│   │   ├── Producto/      # Módulo Producto
│   │   └── ...
│   └── _temp/             # Archivos temporales
│
├── tienda-cliente/          # Aplicación Cliente
│   ├── control/           # Controladores
│   ├── model/             # Modelos
│   └── view/             # Vistas
│
└── _temp/                 # Archivos temporales
```

---

## 2. Arquitectura MVC Personalizada

### 2.1 Modelo Vista Controlador (MVC)

El proyecto implementa una variante del patrón MVC tradicional:

```
┌─────────────────────────────────────────────────────────────────┐
│           ARQUITECTURA MVC DEL PROYECTO                         │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│   REQUEST → CONTROLLER → MODEL → VIEW → RESPONSE              │
│             │          │        │      │                      │
│             ▼          ▼        ▼      ▼                      │
│         c-*.php   RN_*.php  data/*.php  v-*.php            │
│                    │                                 │
│                    ▼                                 │
│               DB.php (DataBase)                          │
│                    │                                 │
│                    ▼                                 │
│              MySQL Database                              │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

### 2.2 Flujo de Datos

```
┌─────────────────────────────────────────────────────────────────┐
│                    FLUJO DE DATOS                            │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│  1. Usuario accede a URL                                    │
│     ↓                                                      │
│  2. Controlador (c-*.php) recibe request                   │
│     ↓                                                      │
│  3. Verifica sesión y permisos                              │
│     ↓                                                      │
│  4. Llama a RN_* (Reglas de Negocio)                        │
│     ↓                                                      │
│  5. RN_* ejecuta SP en DB.php                              │
│     ↓                                                      │
│  6. DB.php conecta a MySQL y ejecuta Query                │
│     ↓                                                      │
│  7. Resultado vuelve a RN_* → Controlador                  │
│     ↓                                                      │
│  8. Controlador pasa datos a Vista (v-*.php)            │
│     ↓                                                      │
│  9. Vista renderiza HTML respuesta                        │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

---

## 3. Base de Datos

### 3.1 Esquema de Base de Datos (mydb)

```
┌─────────────────────────────────────────────────────────────────┐
│              DIAGRAMA ENTIDAD-RELACIÓN                     │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│    ┌──────────┐      ┌──────────┐                         │
│    │ CUENTA   │◄────│ CLIENTE │                         │
│    └──────────┘      └──────────┘                         │
│         │                 │                                 │
│         │            ┌────┴────┐                           │
│    ┌────┴────┐  ┌──┴──┐  ┌──┴──┐                       │
│    │PRODUCTO │  │MARCA│  │CATEG│  │INDUSTRIA             │
│    └────┬────┘  └─────┘  └─────┘  └─────┘                 │
│         │                                                  │
│    ┌────┴────┐  ┌────────────────┐                       │
│    │NOTAVENTA│  │DETALLE_NOTA_VENTA                    │
│    └────┬────┘  └─────────────────────────────────┐        │
│         │                                                  │
│    ┌────┴────┐  ┌─────────────────────────────────┐        │
│    │SUCURSAL │  │DETALLE_PRODUCTO_SUCURSAL         │
│    └─────────┘  └─────────────────────────────────┘        │
│                                                             │
│    ┌──────────┐      ┌──────────┐                         │
│    │CONVERSACION│◄────│ MENSAJE  │                         │
│    └──────────┘      └──────────┘                         │
│                                                             │
│    ┌──────────────┐                                       │
│    │  FORMAPAGO │                                       │
│    └──────────────┘                                       │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

### 3.2 Descripción de Tablas

#### Tabla: **cuenta**
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| usuario | VARCHAR(40) | PK | Nombre de usuario único |
| password | VARCHAR(255) | - | Contraseña (texto plano en desarrollo) |
| email | VARCHAR(100) | UNIQUE | Correo electrónico |
| fechaCreacion | TIMESTAMP | - | Fecha de creación |
| estado | ENUM('activo','inactivo') | - | Estado de la cuenta |

**Relación**: Un `cuenta` puede tener:
- Un `cliente` (si usuarioCuenta = usuario) → rol de cliente
- Sin `cliente` → rol de administrador

---

#### Tabla: **cliente**
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| ci | VARCHAR(20) | PK | Carnet de identidad |
| nombres | VARCHAR(50) | - | Nombres del cliente |
| apPaterno | VARCHAR(30) | - | Apellido paterno |
| apMaterno | VARCHAR(30) | - | Apellido materias |
| correo | VARCHAR(50) | FK→cuenta.email | Correo |
| direccion | VARCHAR(100) | - | Dirección |
| nroCelular | VARCHAR(15) | - | Número de celular |
| usuarioCuenta | VARCHAR(40) | FK→cuenta.usuario | Usuario linked |
| fechaRegistro | TIMESTAMP | - | Fecha de registro |
| estado | ENUM('activo','inactivo') | - | Estado |

---

#### Tabla: **producto**
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| cod | INT | PK | Código auto-incremental |
| nombre | VARCHAR(100) | - | Nombre del producto |
| descripcion | VARCHAR(300) | - | Descripción |
| precio | DECIMAL(10,2) | - | Precio |
| imagen | VARCHAR(255) | - | Ruta de imagen |
| estado | ENUM('disponible','agotado','descontinuado') | - | Estado |
| codMarca | INT | FK→marca.cod | Marca |
| codIndustria | INT | FK→industria.cod | Industria |
| codCategoria | INT | FK→categoria.cod | Categoría |

---

#### Tabla: **marca**
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| cod | INT | PK | Código |
| nombre | VARCHAR(50) | - | Nombre |
| descripcion | VARCHAR(200) | - | Descripción |

---

#### Tabla: **categoria**
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| cod | INT | PK | Código |
| nombre | VARCHAR(50) | - | Nombre |
| descripcion | VARCHAR(200) | - | Descripción |

---

#### Tabla: **industria**
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| cod | INT | PK | Código |
| nombre | VARCHAR(50) | - | Nombre |

---

#### Tabla: **formapago**
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| cod | INT | PK | Código |
| nombre | VARCHAR(50) | - | Nombre |
| estado | ENUM('activa','inactiva') | - | Estado |

---

#### Tabla: **sucursal**
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| cod | INT | PK | Código |
| nombre | VARCHAR(50) | - | Nombre |
| direccion | VARCHAR(150) | - | Dirección |
| nroTelefono | VARCHAR(15) | - | Teléfono |
| estado | ENUM('activa','inactiva') | - | Estado |
| fechaCreacion | TIMESTAMP | - | Fecha |

---

#### Tabla: **notaventa**
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| nro | INT | PK | Número de nota |
| fechaHora | DATETIME | - | Fecha y hora |
| ciCliente | VARCHAR(20) | FK→cliente.ci | Cliente |
| totalVenta | DECIMAL(15,2) | - | Total |
| estado | VARCHAR(20) | - | Estado |
| observaciones | VARCHAR(200) | - | Observaciones |

---

#### Tabla: **detallenotaventa**
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| nroNotaVenta | INT | PK/FK | Nota de venta |
| codProducto | INT | PK/FK | Producto |
| item | INT | PK | Ítem |
| cant | INT | - | Cantidad |
| precioUnitario | DECIMAL(10,2) | - |Precio |
| subtotal | DECIMAL(15,2) | - | Subtotal |

---

#### Tabla: **detalleproductosucursal**
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| codProducto | INT | PK/FK | Producto |
| codSucursal | INT | PK/FK | Sucursal |
| stock | INT | - | Stock |
| stockMinimo | INT | - | Stock mínimo |
| fechaActualizacion | TIMESTAMP | - |Última actualización |

---

#### Tabla: **conversacion** (Chat)
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| id | INT | PK | ID de conversación |
| cliente_ci | VARCHAR(20) | FK→cliente.ci | Cliente |
| admin_usuario | VARCHAR(40) | FK→cuenta.usuario | Admin |
| estado | VARCHAR(20) | - | Estado |
| fechaInicio | TIMESTAMP | - | Inicio |
| fechaFin | TIMESTAMP | - | Fin |

---

#### Tabla: **mensaje** (Chat)
| Campo | Tipo | Clave | Descripción |
|-------|------|------|-----------|
| id | INT | PK | ID de mensaje |
| conversacion_id | INT | FK→conversacion.id | Conversación |
| remitente | VARCHAR(40) | - | Remitente |
| tipo | VARCHAR(20) | - | Tipo |
| contenido | TEXT | - | Contenido |
| leido | TINYINT | - | Leído |
| fechaHora | TIMESTAMP | - | Fecha |

---

### 3.3 Procedimientos Almacenados (SP)

El proyecto utiliza Stored Procedures para todas las operaciones CRUD:

#### Prefijos de SP:
- `sp_Cuenta*` - Operaciones de Cuenta
- `sp_Cliente*` - Operaciones de Cliente
- `sp_Producto*` - Operaciones de Producto
- `sp_Marca*` - Operaciones de Marca
- `sp_Categoria*` - Operaciones de Categoría
- `sp_Industria*` - Operaciones de Industria
- `sp_FormaPago*` - Operaciones de Forma de Pago
- `sp_Sucursal*` - Operaciones de Sucursal
- `sp_NotaVenta*` - Operaciones de Nota de Venta
- `sp_Detalle*` - Operaciones de Detalles
- `sp_Conversacion*` / `sp_Mensaje*` - Chat

#### Ejemplos de SP:

```sql
-- Listar cuentas
DELIMITER $$
CREATE PROCEDURE sp_CuentaListar()
BEGIN 
    SELECT usuario, password, email, fechaCreacion, estado 
    FROM Cuenta; 
END$$

-- Obtener cuenta por usuario
CREATE PROCEDURE sp_CuentaObtener(IN pUsuario VARCHAR(40))
BEGIN 
    SELECT usuario, password, email, fechaCreacion, estado 
    FROM Cuenta 
    WHERE usuario = pUsuario; 
END$$

-- Insertar cuenta
CREATE PROCEDURE sp_CuentaInsertar(
    IN pUsuario VARCHAR(40), 
    IN pPassword VARCHAR(255), 
    IN pEmail VARCHAR(100), 
    IN pEstado VARCHAR(20)
)
BEGIN 
    INSERT INTO Cuenta (usuario, password, email, estado) 
    VALUES (pUsuario, pPassword, pEmail, pEstado); 
END$$
DELIMITER ;
```

---

## 4. Módulo Administrador (tienda-admin)

### 4.1 Estructura de Carpetas

```
tienda-admin/
├── control/                    # Controladores
│   ├── auth/                # Autenticación
│   │   ├── c-login.php      # Login
│   │   └── c-auth.php     # Autenticar
│   ├── admin/              # Dashboard
│   ├── Producto/          # CRUD Producto
│   ├── Marca/            # CRUD Marca
│   ├── Categoria/        # CRUD Categoria
│   ├── Industria/        # CRUD Industria
│   ├── FormaPago/       # CRUD FormaPago
│   ├── Sucursal/         # CRUD Sucursal
│   ├── Inventario/       # Inventario
│   ├── Usuario/         # CRUD Usuario (NEW!)
│   ├── chat/            # Chat
│   └── config.php        # Configuración
│
├── model/                    # Modelos
│   ├── data/              # Entidades
│   │   ├── db.php        # Conexión DB
│   │   ├── config.php    # Config
│   │   ├── Cuenta.php   # Entidad Cuenta
│   │   ├── Cliente.php  # Entidad Cliente
│   │   ├── Producto.php # Entidad Producto
│   │   └── ...
��   │
│   └── RN_*.php          # Reglas de Negocio
│       ├── RN_Cuenta.php
│       ├── RN_Cliente.php
│       ├── RN_Producto.php
│       ├── RN_Marca.php
│       └── ...
│
├── view/                    # Vistas
│   ├── css/               # Estilos
│   ├── auth/              # Login view
│   ├── admin/             # Dashboard
│   ├── Producto/          # Producto views
│   ├── Marca/            # Marca views
│   ├── Usuario/           # Usuario views (NEW!)
│   └── ...
│
├── recursos/               # Recursos (imágenes)
├── _temp/                 # Temp
└── index.php             # Entrada
```

### 4.2 Flujo de Autenticación Admin

```
┌─────────────────────────────────────────────────────────────────┐
│        FLUJO DE LOGIN ADMIN                                    │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│   1. Usuario accede a /tienda-admin/                        │
│           ↓                                                │
│   2. index.php → redirect a c-login.php                    │
│           ↓                                                │
│   3. Muestra v-login.php (formulario)                       │
│           ↓                                                │
│   4. Usuario envía user/pass                               │
│           ↓                                                │
│   5. POST → c-auth.php                                   │
│           ↓                                                │
│   6. RN_Cuenta::Verificar() → validan credenciales        │
│           ↓                                                │
│   7. Si OK: Sesión[AGROVET4] = usuario encoded           │
│      Si FAIL: Sesión[LOGIN_ERROR] → c-login.php             │
│           ↓                                                │
│   8. Redirige a c-admin-panel.php                         │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

### 4.3 Controladores de Admin

Cada módulo tiene el siguiente conjunto de controladores:

| Archivo | Función |
|---------|--------|
| `c-*-list.php` | Lista todos los registros |
| `c-*-new.php` | Muestra formulario de creación |
| `c-*-save.php` | Procesa creación |
| `c-*-edit.php` | Muestra formulario de edición |
| `c-*-update.php` | Procesa edición |
| `c-*-delete.php` | Procesa eliminación |

### 4.4 Modelo de Datos Admin (Entidades)

#### Cuenta (Entidad)
```php
class Cuenta {
    public $usuario;
    public $password;
    public $email;
    public $fechaCreacion;
    public $estado;
}
```

#### Cliente (Entidad)
```php
class Cliente {
    public $ci;
    public $nombres;
    public $apPaterno;
    public $apMaterno;
    public $correo;
    public $direccion;
    public $nroCelular;
    public $usuarioCuenta;
    public $fechaRegistro;
    public $estado;
}
```

#### Producto (Entidad)
```php
class Producto {
    public $cod;
    public $nombre;
    public $descripcion;
    public $precio;
    public $imagen;
    public $estado;
    public $codMarca;
    public $codIndustria;
    public $codCategoria;
}
```

### 4.5 Reglas de Negocio (RN_*) 

#### RN_Cuenta.php
```php
class RN_Cuenta extends DataBase {
    function GetList()           // Lista todas las cuentas
    function GetData($usuario)  // Obtiene una cuenta
    function Save($oCuenta)    // Crea cuenta
    function Update($oCuenta)  // Actualiza cuenta
    function Delete($usuario)  // Elimina cuenta
    function Verificar($u,$p)  // Valida login
}
```

#### RN_Cliente.php
```php
class RN_Cliente extends DataBase {
    function GetList()           // Lista todos los clientes
    function GetData($ci)       // Obtiene un cliente
    function Save($oCliente)    // Crea cliente
    function Update($oCliente)  // Actualiza cliente
    function Delete($ci)        // Elimina cliente
}
```

### 4.6 Módulos Implementados

| Módulo | CRUD | Descripción |
|--------|------|-------------|
| Administradores | ✅ | Gestión de admins (cuentas sin cliente) |
| Clientes | ✅ | Gestión de clientes (cuentas con cliente) |
| Productos | ✅ | Gestión de productos |
| Marcas | ✅ | Gestión de marcas |
| Categorías | ✅ | Gestión de categorías |
| Industrias | ✅ | Gestión de industrias |
| Formas de Pago | ✅ | Gestión de formas de pago |
| Sucursales | ✅ | Gestión de sucursales |
| Inventario | ✅ | Stock por sucursal |
| Chat | ✅ | Chat cliente-admin |

---

## 5. Módulo Cliente (tienda-cliente)

### 5.1 Estructura de Carpetas

```
tienda-cliente/
├── control/                    # Controladores
│   ├── auth/                # Autenticación
│   │   ├── c-login.php     # Login
│   │   ├── c-register.php  # Registro
│   │   └── c-logout.php   # Logout
│   ├── tienda/             # Tienda
│   │   ├── c-tienda-main.php    # Catálogo
│   │   ├── c-tienda-cart.php    # Carrito
│   │   ├── c-tienda-checkout.php # Checkout
│   │   ├── c-tienda-pago-qr.php  # Pago QR
│   │   └── ...
│   ├── chat/               # Chat
│   ├── c-auth.php         # Autenticación
│   └── config.php         # Config
│
├── model/                    # Modelos
│   ├── data/              # Entidades
│   └── RN_*.php          # Reglas de negocio
│
├── view/                    # Vistas
│   ├── auth/              # Vistas auth
│   ├── tienda/            # Vistas tienda
│   └── css/              # Estilos
│
├── recursos/               # Recursos
│   └── productos/        # Imágenes de productos
│
└── index.php             # Entrada
```

### 5.2 Flujo de Compra Cliente

```
┌─────────────────────────────────────────────────────────────────┐
│             FLUJO DE COMPRA CLIENTE                              │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│  1. Index (/) → Muestra catálogo productos                   │
│           ↓                                                │
│  2. Usuario agrega producto al carrito                    │
│     (c-tienda-cart.php?accion=agregar&id=X)                │
│           ↓                                                │
│  3. Carrito guarda en $_SESSION['carrito']                │
│           ↓                                                │
│  4. Usuario va a Carrito → Ver productos                 │
│           ↓                                                │
│  5. Checkout → Verifica sesión cliente                  │
│           ↓                                                │
│  6. Selecciona forma de pago y sucursal                  │
│           ↓                                                │
│  7. Confirmar → Crea NotaVenta + DetalleNotaVenta         │
│           ↓                                                │
│  8. Redirige a página de éxito                          │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

### 5.3 Autenticación Cliente

```
┌─────────────────────────────────────────────────────────────────┐
│        FLUJO DE LOGIN CLIENTE                                │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│   1. POST user/pass → c-auth.php                          │
│           ↓                                                │
│   2. RN_Cuenta::Verificar() valida credenciales           │
│           ↓                                                │
│   3. Vérifica que tenga cliente asociado               │
│      (RN_Cliente::GetDataByUsuario)                     │
│           ↓                                                │
│   4. Si OK: Sesión[CLIENTE_USER] = usuario             │
│            Sesión[CLIENTE_CI] = ci                     │
│      Si FAIL: Sesión[LOGIN_ERROR]                       │
│           ↓                                                │
│   5. Redirige a index.php (tienda)                      │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

### 5.4 Carrito de Compras

El carrito se maneja en sesión:

```php
// Estructura del carrito en $_SESSION
$_SESSION['carrito'] = [
    [
        'id_producto' => 1,
        'nombre' => 'Nike Air Max',
        'precio' => 150.00,
        'cantidad' => 2
    ],
    ...
];
```

---

## 6. Diagramas de Clase

### 6.1 Diagrama de Clase - Cuenta y Cliente

```
┌─────────────────────────────────────────────────────────────────┐
│              DIAGRAMA: Cuenta y Cliente                     │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│    ┌──────────────────┐        ┌──────────────────┐        │
│    │     Cuenta       │        │     Cliente      │        │
│    ├──────────────────┤        ├──────────────────┤        │
│    │ - usuario        │        │ - ci            │        │
│    │ - password      │◄───FK──│ - nombres       │        │
│    │ - email         │        │ - apPaterno      │        │
│    │ - fechaCreacion │        │ - apMaterno     │        │
│    │ - estado       │        │ - correo        │        │
│    ├─────────────────���┤        │ - direccion     │        │
│    │ + GetList()     │        │ - nroCelular    │        │
│    │ + GetData()     │        │ - usuarioCuenta │───FK──►│
│    │ + Save()        │        │ - fechaRegistro │        │
│    │ + Update()     │        │ - estado        │        │
│    │ + Delete()     │        ├──────────────────┤        │
│    │ + Verificar()  │        │ + GetList()      │        │
│    └──────────────────┘        │ + GetData()     │        │
│                              │ + Save()       │        │
│                              │ + Update()     │        │
│                              │ + GetDataByUsuario()│        │
│                              └──────────────────┘        │
│                                                             │
│    RELACIÓN:                                                │
│    - Cuenta (1) ──── FK ──── Cliente (0..1)              │
│    - Si tiene cliente → es CLIENTE                        │
│    - Si NO tiene cliente → es ADMIN                      │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

### 6.2 Diagrama de Clase - Producto

```
┌─────────────────────────────────────────────────────────────────┐
│              DIAGRAMA: Producto y Relaciones                │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│                              ┌──────────────────┐           │
│    ┌──────────────────┐     │     Categoria    │           │
│    │     Marca        │     ├──────────────────┤           │
│    ├──────────────────┤     │ - cod            │           │
│    │ - cod           │     │ - nombre         │     ↑      │
│    │ - nombre        │◄─── │ - descripcion    │     │      │
│    │ - descripcion   │     └──────────────────┘     │       │
│    └──────────────────┘                            │       │
│                              ┌──────────────────┐  │      │
│    ┌──────────────────┐     │     Industria     │  │      │
│    │    Producto      │     ├──────────────────┤  │      │
│    ├──────────────────┤     │ - cod           │  │      │
│    │ - cod           │──────│ - nombre        │──┘      │
│    │ - nombre        │     └──────────────────┘           │
│    │ - descripcion  │                                     │
│    │ - precio      │     ┌──────────────────┐           │
│    │ - imagen      │     │   FormaPago       │           │
│    │ - estado      │     ├──────────────────┤           │
│    │ - codMarca    │────►│ - cod            │           │
│    │ - codIndustria│     │ - nombre        │           │
│    │ - codCategoria│────│ - estado       │           │
│    └──────────────────┘   └──────────────────┘           │
│                                                             │
│    RELACIONES:                                             │
│    - Producto (N) ─── (1) Marca                           │
│    - Producto (N) ─── (1) Categoria                     │
│    - Producto (N) ─── (1) Industria                     │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

### 6.3 Diagrama de Clase - Venta

```
┌─────────────────────────────────────────────────────────────────┐
│              DIAGRAMA: Notas de Venta                       │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│    ┌──────────────────┐      ┌──────────────────────┐     │
│    │    NotaVenta      │      │ DetalleNotaVenta    │     │
│    ├──────────────────┤      ├──────────────────────┤     │
│    │ - nro            │◄──1-n│ - nro NotaVenta      │     │
│    │ - fechaHora      │      │ - cod Producto       │     │
│    │ - ciCliente     │──────│ - item               │     │
│    │ - totalVenta    │      │ - cant               │     │
│    │ - estado       │      │ - precioUnitario    │     │
│    │ - observaciones│      │ - subtotal          │     │
│    └──────────────────┘      └──────────────────────┘     │
│                                                             │
│    ┌──────────────────┐      ┌──────────────────────┐     │
│    │    Sucursal       │      │DetalleProductoSucursal│    │
│    ├──────────────────┤      ├──────────────────────┤     │
│    │ - cod            │◄──1-n│ - cod Producto      │     │
│    │ - nombre        │      │ - cod Sucursal       │     │
│    │ - direccion     │      │ - stock             │     │
│    │ - nroTelefono  │      │ - stockMinimo        │     │
│    │ - estado       │      │ - fechaActualizacion │     │
│    └──────────────────┘      └──────────────────────┘     │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

---

## 7. Diagramas de Secuencia

### 7.1 Secuencia - Login Admin

```
┌───────────────────────────────────────��─��───────────────────────┐
│           SEQ: Login Admin                                      │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│  Actor    Browser         Servidor                           │
│    │       │                 │                                │
│    │──GET──│                 │                                │
│    │───────│─── index.php ──│── c-login.php              │
│    │       │                 │                                │
│    │       │   GET          │── v-login.php (HTML)       │
│    │       │◄───────        │                            │
│    │       │                 │                            │
│    │  POST(user/pass)       │                            │
│    │───────│─── c-auth.php ──│                            │
│    │       │                 │                            │
│    │       │  RN_Cuenta::Verificar(user,pass)         │
│    │       │◄─────────────── │                            │
│    │       │                 │                            │
│    │  if OK│                 │                            │
│    │       │  $_SESSION['AGROVET4'] = usuario       │
│    │───────│─── c-admin-panel.php                   │
│    │       │                 │                            │
│    │  else│                 │                            │
│    │       │  $_SESSION['LOGIN_ERROR'] = msg      │
│    │───────│─── c-login.php                         │
│    │       │                 │                            │
│    ▼       ▼                 ▼                            │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

### 7.2 Secuencia - Crear Producto

```
┌─────────────────────────────────────────────────────────────────┐
│           SEQ: Crear Producto (Admin)                          │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│  Admin  Browser     Admin-Backend     DB                       │
│    │      │            │            │                            │
│    │ GET  │            │            │                            │
│    │──────│──c-producto-new.php                          │
│    │            GET      │──v-producto-new.php           │
│    │◄─────────────      │                             │
│    │            POST   │                             │
│    │──────│──c-producto-save.php                        │
│    │            │       │                             │
│    │            RN_Producto::Save(producto)          │
│    │            │       │                             │
│    │            ───────│──SP:ProductoInsertar       │
│    │            │       │      │                      │
│    │            │       │      ▼                    │
│    │            │       │── Insert into Producto │
│    │            │       │      │                      │
│    │            │       │      ▼                    │
│    │            │       │── OK                    │
│    │            │◄──────│                        │
│    │    redirect to c-producto-list.php          │
│    │◄────────────                             │
│    ▼                ▼            ▼                            │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

### 7.3 Secuencia - Compra Cliente

```
┌─────────────────────────────────────────────────────────────────┐
│           SEQ: Compra Cliente                                  │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│  Cliente  Browser    Tienda-Backend   DB                    │
│    │       │             │            │                       │
│    │ GET   │             │            │                       │
│    │──────│──index.php──│            │                       │
│    │            GET │──c-tienda-main.php           │
│    │            │    │── RN_Producto::GetList()   │
│    │            │    │      │                       │
│    │            │    │◄────│ SP:ProductoListar()    │
│    │            │    │◄────│ SELECT               │
│    │       GET  │──v-tienda-main.php               │
│    │◄────────────│── (HTML con productos)       │
│    │            │            │                       │
│    │ GET: agregar&id=1                         │
│    │──────│──c-tienda-cart.php?accion=agregar   │
│    │            │── $_SESSION['carrito'][] = item│
│    │       redirect: c-tienda-cart.php       │
│    │◄───���─���──────│── (carrito HTML)            │
│    │            │            │                       │
│    │ POST: checkout                           │
│    │──────│──c-tienda-checkout.php               │
│    │            │── Verificar sesión           │
│    │            │── Crear NotaVenta          │
│    │            │── Crear DetalleNotaVenta    │
│    │            │      │                       │
│    │            │◄────│ OK                     │
│    │       redirect: c-payment-success.php │
│    │◄────────────│── (éxito)                  │
│    ▼       ▼            ▼            ▼                        │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

---

## 8. Planificador Scrum / Sprints

### 8.1 Resumen de Sprints Implementados

```
┌─────────────────────────────────────────────────────────────────┐
│              RESUMEN SCRUM - PROYECTO TIENDA                      │
├─────────────────────────────────────────────────────────────────┤
│                                                             │
│  SPRINT 1: Fundamentos (Completado)                          │
│  ├── Configurar proyecto                                     │
│  ├── Estructura MVC                                         │
│  ├── Conexión Database                                       │
│  └── Stored Procedures básicos                              │
│                                                             │
│  SPRINT 2: Módulos Admin (Completado)                         │
│  ├── Login Admin                                            │
│  ├── Dashboard                                             │
│  ├── CRUD Producto                                          │
│  ├── CRUD Marca                                             │
│  ├── CRUD Categoría                                         │
│  ├── CRUD Industria                                         │
│  ├── CRUD FormaPago                                         │
│  └── CRUD Sucursal                                          │
│                                                             │
│  SPRINT 3: Módulos Avanzados (Completado)                   │
│  ├── Módulo Usuario (Admin/Cliente)                        │
│  ├── Gestión de Inventario                                  │
│  ├── Chat cliente-admin                                      │
│  └── Mejoras varias                                         │
│                                                             │
│  SPRINT 4: Cliente E-Commerce (Completado)                   │
│  ├── Catálogo productos                                    │
│  ├── Carrito de compras                                     │
│  ├── Login cliente                                          │
│  ├── Checkout                                               │
│  ├── Formas de pago                                          │
│  └── Correcciones varias                                      │
│                                                             │
│  SPRINT 5: Pruebas y Documentación (Completado)              │
│  ├��─ Pruebas funcionales                                    │
│  ├── Corrección de bugs                                      │
│  └── Documentación técnica                                   │
│                                                             │
└─────────────────────────────────────────────────────────────────┘
```

### 8.2 Detalle de Sprint 1: Fundamentos

| Tarea | Estado | Días |
|-------|--------|------|
| Configurar XAMPP | ✅ | 1 |
| Crear DB mydb | ✅ | 1 |
| Crear tablas | ✅ | 1 |
| Crear SPs básicos | ✅ | 2 |
| Estructura MVC | ✅ | 1 |
| **Total Sprint 1** | | **6** |

### 8.3 Detalle de Sprint 2: Módulos Admin

| Tarea | Estado | Días |
|-------|--------|------|
| Login Admin | ✅ | 2 |
| Dashboard | ✅ | 1 |
| CRUD Producto | ✅ | 3 |
| CRUD Marca | ✅ | 2 |
| CRUD Categoría | ✅ | 2 |
| CRUD Industria | ✅ | 2 |
| CRUD FormaPago | ✅ | 2 |
| CRUD Sucursal | ✅ | 2 |
| **Total Sprint 2** | | **16** |

### 8.4 Detalle de Sprint 3: Módulos Avanzados

| Tarea | Estado | Días |
|-------|--------|------|
| Módulo Usuarios Admin | ✅ | 3 |
| Módulo Usuarios Cliente | ✅ | 3 |
| Inventario | ✅ | 2 |
| Chat | ✅ | 3 |
| Correcciones | ✅ | 3 |
| **Total Sprint 3** | | **14** |

### 8.5 Detalle de Sprint 4: Cliente E-Commerce

| Tarea | Estado | Días |
|-------|--------|------|
| Catálogo productos | ✅ | 2 |
| Carrito compras | ✅ | 2 |
| Login cliente | ✅ | 2 |
| Checkout | ✅ | 3 |
| Formas pago | ✅ | 2 |
| Pago QR | ✅ | 2 |
| **Total Sprint 4** | | **13** |

### 8.6 Detalle de Sprint 5: Pruebas y Docs

| Tarea | Estado | Días |
|-------|--------|------|
| Pruebas Admin | ✅ | 2 |
| Pruebas Cliente | ✅ | 2 |
|Corrección bugs | ✅ | 1 |
| Documentación | ✅ | 2 |
| **Total Sprint 5** | | **7** |

---

## 9. Glosario de Términos

| Término | Definición |
|--------|-----------|
| **SP** | Stored Procedure - Procedimiento almacenado en MySQL |
| **MVC** | Modelo-Vista-Controlador - Patrón arquitectónico |
| **CRUD** | Create, Read, Update, Delete - Operaciones básicas |
| **RN** | Regla de Negocio - Clase PHP con lógica de negocio |
| **CI** | Carnet de Identidad - Documento de identificación |
| **DTO** | Data Transfer Object - Objeto para transferir datos |
| **FK** | Foreign Key - Clave foránea en base de datos |
| **PK** | Primary Key - Clave primaria |
| **ENUM** | Tipo de dato enumerado |

---

## 10. Configuración del Proyecto

### 10.1 Rutas del Proyecto

```
# URL del proyecto
http://localhost/tienda/

# Admin
http://localhost/tienda/tienda-admin/

# Cliente  
http://localhost/tienda/tienda-cliente/

# Base de datos
Host: localhost:3306
DB: mydb
User: root
Password: (vacío)
```

### 10.2 Archivos de Configuración

```php
// tienda-admin/control/config.php
$appTitle = "Tienda Admin";
date_default_timezone_set('America/La_Paz');

// tienda-admin/model/data/DB.php
private $serverName = "localhost:3306";
private $user = "root";
private $pswd = "";
private $dbName = "mydb";
```

---

## 11. Autores y Créditos

**Desarrollado por**: Equipo de desarrollo  
**Proyecto**: Tienda E-Commerce  
**Fecha**: Mayo 2026  
**Versión**: 1.0

---

*Documento generado automáticamente basado en el código del proyecto.*