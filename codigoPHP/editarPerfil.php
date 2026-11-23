<?php
/**
 * @author Juan Rivera Ordóñez
 * @since 12/11/2026
 * Proyecto Tema 5 - Inicio de sesion y cierre de sesion
 */

//Iniciamos la sesion
session_start();

// Si el usuario no ha iniciado la sesion, lo echamos al login
if (!isset($_SESSION['usuarioJRODWESLoginLogoffTema5'])) {
    header("Location: login.php");
    exit;
}

// comprueba si el boton cerrar sesion fue pulsado
if (isset($_REQUEST['btnCerrarSesion'])) {
    session_unset();
    session_destroy();
    header("Location: ../indexProyectoLoginLogoffTema5.php");
    exit();
}
// comprueba si el boton cambiar password fue pulsado
if (isset($_REQUEST['btnCambiarPassword'])) {
    header("Location: ./cambiarPassword.php");
    exit();
}

// Comprueba si el boton cancelar fue pulsado
if (isset($_REQUEST['btnCancelar'])) {
    header("Location: ./inicioPrivado.php");
    exit();
}

$aUsuario = $_SESSION['usuarioJRODWESLoginLogoffTema5'];

require_once '../config/configDBPDO.php';
require_once '../core/231018libreriaValidacion.php';

// comprueba si el boton eliminar cuenta fue pulsado
// (antes el usuario ha aceptado el mensaje de seguridad del navegador)
if (isset($_REQUEST['btnEliminarCuenta'])) {

    try {

        $miDB = new PDO(HOST, USER, PASSWORD);

        $deleteUsuario = $miDB->prepare("DELETE FROM T01_Usuario
             WHERE T01_CodUsuario = :usuario");

        $deleteUsuario->execute([
            ':usuario' => $aUsuario['T01_CodUsuario']
        ]);

        unset($miDB);

        // Destruccion de la sesion y vuelta al index
        session_unset();
        session_destroy();
        header("Location: ../indexProyectoLoginLogoffTema5.php");
        exit();

    } catch (PDOException $miExceptionPDO) {
        echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
        echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
        echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
    } finally {
        unset($miDB);
    }
}

//Inicializacion de variables
$entradaOK = true; // Variable que nos indica que todo va bien
//Array donde recogemos los mensajes de error
$aError = ['descripcion' => ""];

// Comprueba si el boton login fue pulsado
if (isset($_REQUEST["btnAplicar"])) {
    // Validar Entrada
    $aError["descripcion"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["descUsuario"] ?? '', 100, 1, 1);

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

        $updateDescripcion = $miDB->prepare("UPDATE T01_Usuario
             SET T01_DescUsuario = :descUsuario
             WHERE T01_CodUsuario = :usuario");

        $updateDescripcion->execute([
            ':descUsuario' => $_REQUEST['descUsuario'],
            ':usuario' => $aUsuario['T01_CodUsuario']
        ]);

        $aUsuario['T01_DescUsuario'] = $_REQUEST['descUsuario'];
        $_SESSION['usuarioJRODWESLoginLogoffTema5'] = $aUsuario;

        unset($miDB);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();

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
    <title>Programa</title>
    <link rel="stylesheet" href="../webroot/css/style.css">
</head>
<header id="inicio">
    <h1>Proyecto Login Logoff Tema 5</h1>
    <h2>Editar Perfil</h2>
</header>

<body>
    <main>

        <h2>Bienvenido <strong><?php echo $_SESSION['usuarioJRODWESLoginLogoffTema5']['T01_DescUsuario']; ?></strong>
        </h2>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" name="formulario" novalidate>

            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" class="inputBloqueado" value="<?php echo $aUsuario['T01_CodUsuario']; ?>"
                readonly>

            <br>

            <label for="usuario">Nombre y Apellidos:</label>
            <input type="text" id="usuario" name="descUsuario"
                value="<?php echo $_REQUEST['descUsuario'] ?? $aUsuario['T01_DescUsuario']; ?>">
            <span style="color:red;"><?php echo $aError['descripcion']; ?></span>

            <br>

            <label for="usuario">Tipo de usuario:</label>
            <input type="text" id="usuario" class="inputBloqueado" value="<?php echo $aUsuario['T01_Perfil']; ?>"
                readonly>

            <br>

            <input type="submit" name="btnAplicar" class="btn btn-login" value="Aplicar Cambios" />
            <input type="submit" name="btnCambiarPassword" class="btn btn-codigo" value="Cambiar Contraseña" />
            <input type="submit" name="btnCancelar" class="btn btn-cancelar" value="Cancelar" />

            <hr>

            <?php
            // Mensaje de confirmacion en UNA sola linea: un string de JavaScript no puede contener
            // saltos de linea reales (provocaban un error de sintaxis y el confirm no llegaba a salir).
            // json_encode genera un string JS valido y htmlspecialchars lo protege dentro del atributo.
            $mensajeConfirmacion = "¡ATENCIÓN!\n\nVas a eliminar la cuenta de " . $aUsuario['T01_CodUsuario']
                . ".\nSe borrarán todos tus datos de forma permanente y esta acción NO se puede deshacer."
                . "\n\n¿Seguro que quieres eliminar tu cuenta?";
            ?>
            <input type="submit" name="btnEliminarCuenta" class="btn btn-cancelar" value="Eliminar Cuenta"
                onclick="return confirm(<?php echo htmlspecialchars(json_encode($mensajeConfirmacion, JSON_UNESCAPED_UNICODE), ENT_QUOTES); ?>);" />

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