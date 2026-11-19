# Proyecto Login Logoff Tema 5

Aplicación web en **PHP** desarrollada para la asignatura **Desarrollo Web en Entorno Servidor (DWES)** del I.E.S. Los Sauces (curso 2025-2026). Implementa un sistema de **inicio de sesión, registro, gestión de perfil y cierre de sesión** con control de acceso mediante sesiones, selección de idioma con cookies y persistencia en **MariaDB/MySQL** a través de **PDO**.

> Estado: en desarrollo.

## Funcionalidades

- **Inicio público**: página de entrada con acceso a *Iniciar sesión* y *Registrarse*, junto al modelo de datos.
- **Selector de idioma**: banderas (español, inglés y portugués) que guardan el idioma elegido en la cookie `idioma` durante una semana. Si no existe, se usa español por defecto.
- **Login**: valida el formulario, comprueba las credenciales contra la base de datos (contraseña cifrada con `SHA2-256` sobre usuario + contraseña) y actualiza el número de conexiones y la fecha de la última conexión.
- **Registro**: alta de nuevos usuarios con validación de campos, confirmación de contraseña y comprobación de que el código de usuario no exista.
- **Inicio privado**: área accesible solo con sesión iniciada; muestra un saludo personalizado en el idioma de la cookie y permite ver detalles, editar el perfil o cerrar sesión.
- **Editar perfil**: permite modificar la descripción (nombre y apellidos) del usuario, acceder al cambio de contraseña y **eliminar la cuenta** (previa confirmación en el navegador).
- **Cambiar contraseña**: pide la contraseña actual, la nueva y su repetición; comprueba que la actual es correcta y guarda la nueva con el mismo cifrado que el registro.
- **Detalle**: muestra el contenido de las variables superglobales (`$_SESSION`, `$_SERVER`, `$_COOKIE`, ...) y `phpinfo()`.
- **Logoff**: destruye la sesión y vuelve al inicio público.

## Navegación

```
Inicio público ──► Login ──► Inicio privado ──► Detalle
      │                           │
      └──► Registro ──────────────┤
                                  └──► Editar perfil ──► Cambiar contraseña
                                             │
                                             └──► Eliminar cuenta ──► Inicio público
```

Todas las páginas privadas comprueban la sesión `usuarioJRODWESLoginLogoffTema5` y redirigen al login si no existe.

## Estructura

```
├── indexProyectoLoginLogoffTema5.php   # Inicio público y selector de idioma
├── codigoPHP/
│   ├── login.php                       # Formulario de inicio de sesión
│   ├── registro.php                    # Alta de usuarios
│   ├── inicioPrivado.php               # Área privada
│   ├── editarPerfil.php                # Edición de perfil y baja de la cuenta
│   ├── cambiarPassword.php             # Cambio de contraseña
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
    ├── script/script.js                # Marca la bandera del idioma activo
    └── images/                         # Logos, iconos y banderas (ES, GB, PT)
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

PHP 8 · PDO · MariaDB/MySQL · HTML5 · CSS3 · JavaScript · Sesiones y cookies · Apache

## Ramas

- `main`: rama principal.
- `developerJRO`: rama de desarrollo.

## Autor

**Juan Rivera Ordóñez** — I.E.S. Los Sauces, 2025-2026.
