<?php

    if (isset($_REQUEST['btnVolver'])) {
        header("Location: ./inicioPrivado.php");
        exit;
    } 

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Detalle</title>
        <link rel="stylesheet" href="../webroot/css/style.css">
    </head>
    <header id="inicio">
        <h1>Proyecto Login Logoff Tema 5</h1>
        <h2>Detalles</h2>
    </header>
    <body>

        <main>

         <form action="" method="POST">
            <button name="btnVolver"><span>Volver</span></button>
        </form>

        <?php
        
        foreach ($GLOBALS as $nombre => $contenido) {
                echo "<h2>$nombre</h2>";
                echo "<pre>";
                print_r($contenido);
                echo "</pre>";
                echo "<hr>";
            }

        ?>

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