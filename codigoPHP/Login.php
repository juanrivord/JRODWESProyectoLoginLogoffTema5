<?php

/**
 * @author Juan Rivera Ordóñez
 * @since 12/11/2026
 * Proyecto Tema 5 - Inicio de sesion y cierre de sesion
 */

//Inicia la sesion
session_start();

// Si el usuario ya ha iniciado la sesion, lo redireccionamos al accesso privado
if (isset($_SESSION['usuarioJRODWESLoginLogoffTema5'])) {
    header("Location: inicioPrivado.php");
    exit;
}

// comprueba si el boton cancelar fue pulsado
if (isset($_REQUEST['cancelar'])) {
    // encaso de que si, vuelve al indice
    header("Location: ../indexProyectoLoginLogoffTema5.php");
    exit;
}
require_once '../config/configDBPDO.php';
require_once '../core/231018libreriaValidacion.php';

//Inicializacion de variables
$entradaOK = true; // Variable que nos indica que todo va bien
$usuarioEncontrado = true; //Variable que nos indica si el usuario del login existe
//Array donde recogemos los mensajes de error
$aError = [
    'usuario' => "",
    'contrasena' => ""
];

// Comprueba si el boton login fue pulsado
if (isset($_REQUEST["login"])) {
    // Validar Entrada
    $aError["usuario"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["usuario"], 1000, 1, 1);
    // utilizar para la creacion de la contrasena, no la validacion
    //$aError["contrasena"] = validacionFormularios::validarPassword($passwd, $maximo, $minimo, $tipo, $obligatorio);
    $aError["contrasena"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["contrasena"], 1000, 1, 1);

    foreach ($aError as $value) {
        if (!empty($value)) {
            $entradaOK = false;
        }
    }
}
// El formulario no se ha enviado nunca
else {
    $entradaOK = false;
}
// si los datos estan bien,
// comprueba si el usuario existe en la base de datos
if ($entradaOK) {
    try {

        $miDB = new PDO(HOST, USER, PASSWORD);

        $sqlSelect = <<<sql
                SELECT * FROM T01_Usuario
                WHERE T01_CodUsuario = :codUsuario and T01_Password = SHA2(:password,256)
                sql;
        $selectUsuarioContrasena = $miDB->prepare($sqlSelect);
        // trim elimina espacios antes y despues del texto
        $selectUsuarioContrasena->execute([
            ':codUsuario' => trim($_REQUEST["usuario"]),
            ':password' => trim($_REQUEST["usuario"] . $_REQUEST["contrasena"])
        ]);

        if ($selectUsuarioContrasena->rowCount() != 1) {
            $usuarioEncontrado = false;
        } else {
            //actualizamos los datos del usuario
            $actualizarUsuario = $miDB->prepare(
                "UPDATE T01_Usuario 
                            SET T01_NumConexiones = T01_NumConexiones + 1, 
                                T01_FechaHoraUltimaConexion = NOW() 
                            WHERE T01_CodUsuario = :usuarioUpdate"
            );
            $actualizarUsuario->execute([':usuarioUpdate' => $_REQUEST["usuario"]]);

            //creamos el objeto usuario
            $aUsuario = $selectUsuarioContrasena->fetch();
            // Guardamos en la sesion los datos requeridos para la vista privada en
            $_SESSION['usuarioJRODWESLoginLogoffTema5'] = $aUsuario;

            // Cerramos conexion y redirigimos al area privada
            unset($miDB);
            header("Location: ./inicioPrivado.php");
            exit;
        }
    } catch (PDOException $miExceptionPDO) {


        echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
        echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
        echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
    } finally {
        unset($miDB);
    }
}
// Mostrar Login
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
            <input type="text" name="usuario" id="usuario" value="<?php echo !empty($_REQUEST["usuario"]) ? $_REQUEST["usuario"] : '' ?>" />

            <?php echo !empty($aError["usuario"]) ? "<span style='color:red;'>" . $aError['usuario'] . "</span>" : '' ?>

            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" id="contrasena" value="<?php echo !empty($_REQUEST["contrasena"]) ? $_REQUEST["contrasena"] : '' ?>" />

            <?php echo !empty($aError["contrasena"]) ? "<span style='color:red;'>" . $aError['contrasena'] . "</span>" : '' ?>

            <br />

            <?php echo !$usuarioEncontrado ? "<span style='color:red;'>Usuario no encontrado, nombre de usuario o contrasena incorrecta</span>" : '' ?>

            <input type="submit" name="login" id="login" class="btn btn-login" value="Log in" />
            <input type="submit" name="cancelar" id="cancelar" class="btn btn-cancelar" value="Cancelar" />
            
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