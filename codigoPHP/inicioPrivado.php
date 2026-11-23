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
// comprueba si el boton entrar detalle fue pulsado
if (isset($_REQUEST['btnDetalle'])) {
    header("Location: ./detalle.php");
    exit();
}

// comprueba si el boton editar perfil fue pulsado
if (isset($_REQUEST['btnEditarPerfil'])) {
    header("Location: ./editarPerfil.php");
    exit();
}

// comprueba si el boton editar perfil fue pulsado
if (isset($_REQUEST['btnDepartamentos'])) {
    header("Location: ./mtoDepartamentos.php");
    exit();
}

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
        <h2>Inicio Privado</h2>
    </header>
    <body>
        <main>

        <?php 
        
        $nombre = $_SESSION['usuarioJRODWESLoginLogoffTema5']['T01_DescUsuario'];

        // Saludo segun el idioma guardado en la cookie (español por defecto)
        switch ($_COOKIE['idioma'] ?? 'es/ES') {
            case 'en/GB':
                echo "<h2>Welcome! <strong>" . $nombre . "</strong></h2>";
                break;
            case 'pt/PT':
                echo "<h2>Bem-vindo! <strong>" . $nombre . "</strong></h2>";
                break;
            default:
                echo "<h2>¡Bienvenido! <strong>" . $nombre . "</strong></h2>";
        }

        ?>

        
        

         <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" name="formulario" novalidate>

            <input type="submit" name="btnDetalle" class="btn" value="Detalles"/>
            <input type="submit" name="btnDepartamentos" class="btn" value="Departamentos"/>
            <input type="submit" name="btnEditarPerfil" class="btn btn-login" value="Editar Perfil"/>
            <input type="submit" name="btnCerrarSesion" class="btn btn-cancelar" value="Cerrar Sesion"/>

        </form>

        

        </main>
    
    </body>
    <footer>
        <address>
            <p>&copy; 2025-2026 <span><a href="../../index.html">Juan Rivera Ordoñez</a></span>- I.E.S. Los Sauces</p>
            <a href="https://github.com/juanrivord/JRODWESProyectoLoginLogoffTema5" target="_blank"><img src="../webroot/images/github.png" alt="Imagen de github"></a>
            <a href="../indexProyectoLoginLogoffTema5.php"><img src="../webroot/images/casita.png" alt="Imagen de una casita"></a>
        </address>
    </footer>
</html>