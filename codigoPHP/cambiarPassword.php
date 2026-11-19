<?php
/**
 * @author Juan Rivera Ordóñez
 * @since 19/11/2026
 * Proyecto Tema 5 - Cambiar contraseña
 */

//Iniciamos la sesion
session_start();

// Si el usuario no ha iniciado la sesion, lo echamos al login
if (!isset($_SESSION['usuarioJRODWESLoginLogoffTema5'])) {
    header("Location: login.php");
    exit;
}

// Comprueba si el boton cancelar fue pulsado -> volvemos a editar perfil
if (isset($_REQUEST['btnCancelar'])) {
    header("Location: ./editarPerfil.php");
    exit();
}

$aUsuario = $_SESSION['usuarioJRODWESLoginLogoffTema5'];

require_once '../config/configDBPDO.php';
require_once '../core/231018libreriaValidacion.php';

//Inicializacion de variables
$entradaOK = true; // Variable que nos indica que todo va bien
//Array donde recogemos los mensajes de error
$aError = [
    'passwordActual' => "",
    'passwordNueva' => "",
    'repetirPassword' => ""
];

// Comprueba si el boton aceptar fue pulsado
if (isset($_REQUEST["btnAceptar"])) {
    // Validar Entrada (mismos criterios que en el registro)
    $aError["passwordActual"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["passwordActual"] ?? '', 32, 1, 1);
    $aError["passwordNueva"] = validacionFormularios::validarPassword($_REQUEST["passwordNueva"] ?? '', 32, 4, 2, 1);
    $aError["repetirPassword"] = validacionFormularios::comprobarNoVacio($_REQUEST["repetirPassword"] ?? '');

    // comprobar que las dos contraseñas nuevas son iguales
    if (empty($aError["repetirPassword"]) && $_REQUEST["passwordNueva"] !== $_REQUEST["repetirPassword"]) {
        $aError["repetirPassword"] = "Las contraseñas nuevas no son iguales";
    }

    foreach ($aError as $value) {
        if (!empty($value)) {
            $entradaOK = false;
        }
    }

    // Si el formato es correcto, comprobamos que la contraseña actual es la buena
    if ($entradaOK) {
        try {

            $miDB = new PDO(HOST, USER, PASSWORD);

            $selectPassword = $miDB->prepare("SELECT T01_CodUsuario FROM T01_Usuario
                 WHERE T01_CodUsuario = :usuario AND T01_Password = SHA2(:password, 256)");

            $selectPassword->execute([
                ':usuario' => $aUsuario['T01_CodUsuario'],
                ':password' => $aUsuario['T01_CodUsuario'] . trim($_REQUEST['passwordActual'])
            ]);

            if ($selectPassword->rowCount() != 1) {
                $entradaOK = false;
                $aError['passwordActual'] = "La contraseña actual no es correcta";
            }

        } catch (PDOException $miExceptionPDO) {
            $entradaOK = false;
            echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
            echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
            echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
            unset($miDB);
        }
    }
}
// El formulario no se ha enviado nunca
else {
    $entradaOK = false;
}

// si los datos estan bien, actualizamos la contraseña
if ($entradaOK) {

    try {

        $updatePassword = $miDB->prepare("UPDATE T01_Usuario
             SET T01_Password = SHA2(:password, 256)
             WHERE T01_CodUsuario = :usuario");

        // La contraseña se guarda como SHA2(usuario + contraseña), igual que en el registro
        $updatePassword->execute([
            ':password' => $aUsuario['T01_CodUsuario'] . trim($_REQUEST['passwordNueva']),
            ':usuario' => $aUsuario['T01_CodUsuario']
        ]);

        // Actualizamos tambien el usuario guardado en la sesion
        $aUsuario['T01_Password'] = hash('sha256', $aUsuario['T01_CodUsuario'] . trim($_REQUEST['passwordNueva']));
        $_SESSION['usuarioJRODWESLoginLogoffTema5'] = $aUsuario;

        unset($miDB);
        // Volvemos a editar perfil
        header('Location: ./editarPerfil.php');
        exit();

    } catch (PDOException $miExceptionPDO) {
        echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
        echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
        echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
    } finally {
        unset($miDB);
    }

}
// Mostrar formulario
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
    <h2>Cambiar Contraseña</h2>
</header>

<body>
    <main>

        <h2>Usuario: <strong><?php echo $aUsuario['T01_CodUsuario']; ?></strong></h2>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" name="formulario" novalidate>

            <label for="passwordActual">Contraseña actual:</label>
            <input type="password" id="passwordActual" name="passwordActual">
            <span style="color:red;"><?php echo $aError['passwordActual']; ?></span>

            <br>

            <label for="passwordNueva">Nueva contraseña:</label>
            <input type="password" id="passwordNueva" name="passwordNueva">
            <span style="color:red;"><?php echo $aError['passwordNueva']; ?></span>

            <br>

            <label for="repetirPassword">Repetir nueva contraseña:</label>
            <input type="password" id="repetirPassword" name="repetirPassword">
            <span style="color:red;"><?php echo $aError['repetirPassword']; ?></span>

            <br>

            <input type="submit" name="btnAceptar" class="btn btn-login" value="Aceptar" />
            <input type="submit" name="btnCancelar" class="btn btn-cancelar" value="Cancelar" />

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