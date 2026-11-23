<?php
/**
 * @author Juan Rivera Ordóñez
 * @since 12/11/2026
 * Proyecto Tema 5 - Inicio de sesion y cierre de sesion
 */

//Iniciamos la sesion
session_start();

// Si el usuario no esta logueado, lo echamos al login
if (!isset($_SESSION['usuarioJRODWESLoginLogoffTema5'])) {
    header("Location: login.php");
    exit;
}

// boton de Volver
if (isset($_REQUEST['btnVolver'])) {
    header("Location: inicioPrivado.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Detalle</title>
        <link rel="stylesheet" href="../webroot/css/style.css">
        <style>
            form.volver{
                position: absolute;
                width: 150px;height: 20px;
                right: 0;top: -40px;
                background: transparent;
                box-shadow: none;

                & #volver{
                    background: red;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    font-weight: bold;
                }
            }
            
        </style>
    </head>
    <header id="inicio">
        <h1>Proyecto Login Logoff Tema 5</h1>
        <h2>Detalles</h2>
    </header>
    <body>

        <main>

         <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" name="formulario" class="volver" novalidate>
            <input type="submit" name="btnVolver" id="volver" value="Volver"/>
        </form>

        <?php              
                // RECORRIDO DE TODAS LAS SUPERGLOBALES CON FOREACH
                echo "<h2>Recorrido de variables Superglobales</h2>";

                // Array asociativo que agrupa todas las variables superglobales de PHP
                $aSuperglobales = [
                    '$_SESSION' => $_SESSION,
                    '$_COOKIE'  => $_COOKIE,
                    '$_SERVER'  => $_SERVER,
                    '$_REQUEST' => $_REQUEST,
                    '$_GET'     => $_GET,
                    '$_POST'    => $_POST,
                    '$_FILES'   => $_FILES,
                    '$_ENV'     => $_ENV
                ];

                // Recorrido del array
                foreach ($aSuperglobales as $nombreSuperglobal => $arraySuperglobal) {
                    echo "<h3>Contenido de $nombreSuperglobal</h3>";

                    if (!empty($arraySuperglobal)) {
                        echo "<table class='tabla-superglobales'>";
                        echo "<tr><th>Clave</th><th>Contenido</th></tr>";

                        foreach ($arraySuperglobal as $nombre => $contenido) {
                            echo "<tr>";
                            echo "<td style='width: 20%;'><strong>" . $nombre . "</strong></td>";
                            
                            if (is_array($contenido)) {
                                echo "<td><pre>" . print_r($contenido, true) . "</pre></td>";
                            } else {
                                echo "<td>" . (string)$contenido . "</td>";
                            }
                            
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<div class='vacio'>La variable $nombreSuperglobal está vacía en este momento.</div>";
                    }
                }
                
                 // PHPINFO()
                echo "<h2>Informacion de phpinfo</h2>";
                echo "<p>Mediante la función <code>phpinfo()</code> se obtiene informacion detallada sobre la configuracion actual de PHP en el servidor.</p>";
                // Aqui me encuentro con un problema: cuando saco phpinfo() los estilos de mi pagina los modifica completamente, porque tiene su propio <style>
                // Mi solucion es encapsular el html que genera el phpinfo con la funcion ob_start y ob_get_clean, una vez hecho eso, extraigo el contenido unicamente
                // de <body> con preg_replace y lo muestro en un <div> a parte.

                // ob_start atrapa el html que genera el phpinfo
                ob_start();
                phpinfo();
                $phpinfo = ob_get_clean();

                // Extraigo el contenido de las etiquetas <body> unicamente
                $phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo);

                // lo muestro dentro de un <div> para mantener mis estilos y mi linea de programacion.
                echo '<div class="contenedor-phpinfo">' . $phpinfo . '</div>';

                // Informacion encontrada en:
                // Comportamiento de phpinfo() y control de salida: https://www.php.net/manual/en/outcontrol.output-buffering.php
                // Como encapsular el <style> y cambiarlo https://stackoverflow.com/questions/52865732/how-to-embed-phpinfo-within-a-page-without-affecting-that-pages-css-styles

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