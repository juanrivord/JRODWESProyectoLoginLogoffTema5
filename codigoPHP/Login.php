<?php

/**
 * @author Juan Rivera Ordóñez
 * @since 12/11/2026
 * Proyecto Tema 5 - Inicio de sesion y cierre de sesion
 */

session_start();

// libreria de validacion y configuracion de la base de datos
require_once '../core/231018libreriaValidacion.php';
require_once '../config/configDBPDOClase.php';

// Si el usuario pulsa cancelar, se le redirige al indice publico
if (isset($_REQUEST['cancelar'])) {
    header("Location: ../indexLoginLogoffTema5.php");
    exit;
}

$entradaOK = true;
$aErrores = ['usuario' => null, 'password' => null];

// Procesamiento del formulario cuando se pulsa iniciar sesion
if (isset($_REQUEST['login'])) {
    // Validacion de los campos mediante la libreria
    $aErrores['usuario'] = validacionFormularios::comprobarAlfabetico($_REQUEST['usuario'], 8, 4, 1);
    $aErrores['password'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['password'], 16, 4, 1);

    // Recorremos el array de errores para comprobar si hay alguno
    foreach ($aErrores as $error) {
        if ($error != null) {
            $entradaOK = false;
        }
    }

    // Si la validacion es correcta, comprobamos las credenciales en la BBDD
    if ($entradaOK) {
        try {
            // Instanciamos el objeto PDO
            $miDB = new PDO(HOST, USER, PASSWORD);

            // Usamos la logica de encriptacion SHA2(CONCAT(usuario, password), 256)
            $consulta = $miDB->prepare(
                "SELECT * FROM T01_Usuario 
                 WHERE T01_CodUsuario = :usuario 
                 AND T01_Password = SHA2(CONCAT(:usuarioConcatenado, :password), 256)"
            );

            // Pasamos los parametros
            $consulta->execute([
                ':usuario' => $_REQUEST['usuario'],
                ':usuarioConcatenado' => $_REQUEST['usuario'],
                ':password' => $_REQUEST['password']
            ]);

            // Recuperamos el objeto usuario
            $oUsuario = $consulta->fetchObject();

            // Si el usuario no existe o la contraseña es incorrecta
            if (!$oUsuario) {
                $aErrores['password'] = "Usuario o contraseña incorrectos.";
                $entradaOK = false;
            } else {

                // Actualizamos el numero de conexiones y la fecha de ultima conexion
                $actualizar = $miDB->prepare(
                    "UPDATE T01_Usuario 
                     SET T01_NumConexiones = T01_NumConexiones + 1, 
                         T01_FechaHoraUltimaConexion = NOW() 
                     WHERE T01_CodUsuario = :usuarioUpdate"
                );
                $actualizar->execute([':usuarioUpdate' => $oUsuario->T01_CodUsuario]);

                // Guardamos en la sesion los datos requeridos para la vista privada
                $_SESSION['usuarioMDCDWESLoginLogoff'] = $oUsuario->T01_CodUsuario;
                $_SESSION['descUsuario'] = $oUsuario->T01_DescUsuario;
                // Sumamos 1 al numero de conexiones para reflejar el acceso actual
                $_SESSION['numConexiones'] = $oUsuario->T01_NumConexiones + 1;
                $_SESSION['fechaHoraUltimaConexionAnterior'] = $oUsuario->T01_FechaHoraUltimaConexion;

                // Cerramos conexion y redirigimos al area privada
                unset($miDB);
                header("Location: ./inicioPrivado.php");
                exit;
            }
        } catch (PDOException $miExcepcionPDO) {
            $aErrores['password'] = "Error de conexion: " . $miExcepcionPDO->getMessage();
            $entradaOK = false;
        } finally {
            unset($miDB);
        }
    }
} else {
    // Si no se ha enviado el formulario, forzamos a que no se procese
    $entradaOK = false;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../webroot/css/style.css">
</head>
<header id="inicio">
    <h1>Proyecto Login Logoff Tema 5</h1>
    <h2>Inicio de Sesion</h2>
</header>

<body>
    <main>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="formulario" novalidate>

            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario"
                value="<?php echo !empty($_REQUEST["usuario"]) ? $_REQUEST["usuario"] : '' ?>" />

            <?php echo !empty($aError["usuario"]) ? "<span style='color:red;'>" . $aError['usuario'] . "</span>" : '' ?>

            <br>

            <label for="contrasena">Contrasena:</label>
            <input type="password" name="contrasena" id="contrasena"
                value="<?php echo !empty($_REQUEST["contrasena"]) ? $_REQUEST["contrasena"] : '' ?>" />

            <?php echo !empty($aError["contrasena"]) ? "<span style='color:red;'>" . $aError['contrasena'] . "</span>" : '' ?>

            <br>

            <input type="submit" name="btnLogin" id="btnLogin" class="btn btn-login" value="Log in" />
            <input type="submit" name="btnCancelar" id="btnCancelar" class="btn btn-cancelar" value="Cancelar" />

            <?php echo !$usuarioEncontrado ? "<span style='color:red;'>Usuario no encontrado, nombre de usuario o contrasena incorrecta</span>" : '' ?>

        </form>

    </main>
</body>
<footer>
    <address>
        <p>&copy; 2025-2026 <span><a href="../../index.html">Juan Rivera Ordoñez</a></span>- I.E.S. Los Sauces</p>
        <a href="https://github.com/juanrivord/JRODWESProyectoLoginLogoffTema5" target="_blank"><img
                src="../webroot/images/github.png" alt="Imagen de github"></a>
        <a href="../indexProyectoLoginLogoffTema5.php"><img src="../webroot/images/casita.png"
                alt="Imagen de una casita"></a>
    </address>
</footer>

</html>