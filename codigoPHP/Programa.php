<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Programa</title>
        <link rel="stylesheet" href="../webroot/css/style.css">
    </head>
    <header id="inicio">
            <img src="../webroot/images/logo.png" alt="Logo de I.E.S. Los Sauces" class="logo">
        <h1>TEMA 5: Desarrollo de aplicaciones web</h1>
    </header>
    <body>

        <?php
        require_once '../core/231018libreriaValidacion.php'; 
        require_once '../config/configDBPDO.php';

        echo "<a href='../indexProyectoTema4.php'>⬅ Volver al inicio</a><br><br>";
        

        ?>
        
    </body>
    <footer>
        <address>
            <p>&copy; 2025-2026 <span><a href="../indexProyectoTema5.php">Juan Rivera Ordoñez</a></span>- I.E.S. Los Sauces</p>
            <a href="https://github.com/juanrivord/JRODWESProyectoTema5"><img src="../webroot/images/github.png" alt="Imagen de github"></a>
            <a href="../indexProyectoTema4.php"><img src="../webroot/images/casita.png" alt="Imagen de una casita"></a>
        </address>
    </footer>
</html>