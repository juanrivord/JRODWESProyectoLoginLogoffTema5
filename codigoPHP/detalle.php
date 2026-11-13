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
                $aSuperglobales = [
                    '$_SESSION' => $_SESSION,
                    '$_COOKIE' => $_COOKIE,
                    '$_SERVER' => $_SERVER,
                    '$_REQUEST' => $_REQUEST,
                    '$_GET' => $_GET,
                    '$_POST' => $_POST,
                    '$_FILES' => $_FILES,
                    '$_ENV' => $_ENV
                ];

                // Recorrido del array
                foreach ($aSuperglobales as $nombreSuperglobal => $arraySuperglobal) {
                    echo "<h3 class='superGlobal'>$nombreSuperglobal</h3>";

                    if (!empty($arraySuperglobal)) {
                        echo "<ul>";

                        foreach ($arraySuperglobal as $nombre => $contenido) {
                            if (is_array($contenido)) {
                                $contenido = "<pre>" . print_r($contenido, true) . "</pre>";
                            }
                            echo "<li><span style='color:blue;font-weight:bold'>$nombre : </span>" . htmlspecialchars($contenido) . "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<div class='vacio'>La variable $nombreSuperglobal esta vacia en este momento.</div>";
                    }
                }

                phpinfo();
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