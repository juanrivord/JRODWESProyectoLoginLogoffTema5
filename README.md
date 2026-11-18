# Proyecto Login Logoff Tema 5

Aplicación web en **PHP** desarrollada para la asignatura **Desarrollo Web en Entorno Servidor (DWES)** del I.E.S. Los Sauces (curso 2025-2026). Implementa un sistema básico de **inicio de sesión, registro y cierre de sesión** con control de acceso mediante sesiones y persistencia en **MariaDB/MySQL** a través de **PDO**.

> Estado: en desarrollo.

## Funcionalidades

- **Inicio público**: página de entrada con acceso a *Iniciar sesión* y *Registrarse*, junto al modelo de datos.
- **Login**: valida el formulario, comprueba las credenciales contra la base de datos (contraseña cifrada con `SHA2-256` sobre usuario + contraseña) y actualiza el número de conexiones y la fecha de la última conexión.
- **Registro**: alta de nuevos usuarios con validación de campos, confirmación de contraseña y comprobación de que el código de usuario no exista.
- **Inicio privado**: área accesible solo con sesión iniciada; muestra un saludo personalizado y permite ver detalles o cerrar sesión.
- **Detalle**: muestra el contenido de las variables superglobales (`$_SESSION`, `$_SERVER`, `$_COOKIE`, ...) y `phpinfo()`.
- **Logoff**: destruye la sesión y vuelve al inicio público.

## Estructura

```
├── indexProyectoLoginLogoffTema5.php   # Inicio público
├── codigoPHP/
│   ├── Login.php                       # Formulario de inicio de sesión
│   ├── registro.php                    # Alta de usuarios
│   ├── inicioPrivado.php               # Área privada
│   └── detalle.php                     # Variables superglobales y phpinfo()
├── config/
│   └── configDBPDO.php                 # Constantes de conexión (entornos clase / casa)
├── core/
│   └── 231018libreriaValidacion.php    # Librería de validación de formularios
├── scriptDB/
│   ├── CreaDB...sql                    # Crea la BD, tablas y usuario
│   ├── CargaInicialDB...sql            # Datos iniciales
│   └── BorraDB...sql                   # Elimina la BD y el usuario
└── webroot/
    ├── css/style.css
    └── images/
```

## Base de datos

Base de datos `DBJRODWESProyectoLoginLogoffTema5` con las tablas:

| Tabla | Descripción |
|-------|-------------|
| `T01_Usuario` | Código, contraseña (hash), descripción, última conexión, nº de conexiones, perfil (`usuario` / `administrador`) e imagen. |
| `T02_Departamento` | Código, descripción, fecha de creación, volumen de negocio y fecha de baja. |

## Puesta en marcha

1. Ejecutar en el servidor MariaDB/MySQL, en este orden:
   - `scriptDB/CreaDBJRODWESProyectoLoginLogoffTema5.sql`
   - `scriptDB/CargaInicialDBJRODWESProyectoLoginLogoffTema5.sql`
2. Ajustar en `config/configDBPDO.php` el host, usuario y contraseña del entorno que corresponda.
3. Desplegar el proyecto en un servidor web con PHP (Apache) y acceder a `indexProyectoLoginLogoffTema5.php`.

Para eliminar la base de datos: `scriptDB/BorraDBJRODWESProyectoLoginLogoffTema5.sql`.

## Tecnologías

PHP 8 · PDO · MariaDB/MySQL · HTML5 · CSS3 · Apache

## Ramas

- `master`: rama principal.
- `developerJRO`: rama de desarrollo.

## Autor

**Juan Rivera Ordóñez** — I.E.S. Los Sauces, 2025-2026.
