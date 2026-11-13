<?php

    if (isset($_REQUEST['btnCerrarSesion'])) {
        header("Location: ../indexProyectoLoginLogoffTema5.php");
        exit;
    } 

    if (isset($_REQUEST['btnDetalle'])) {
        header("Location: ./detalle.php");
        exit;
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

        <h2>Bienvenido!</h2>

         <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" name="formulario" novalidate>

            <input type="submit" name="btnDetalle" class="btn btn-login"><span>Detalles</span></input>
            <input type="submit" name="btnCerrarSesion" class="btn btn-cancelar"><span>Cerrar sesion</span></input>

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