<?php

    if (isset($_REQUEST['btnLogin'])) {
        header("Location: ./codigoPHP/login.php");
        exit;
    } 

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWES. Juan Rivera Ordoñez</title>
    <link rel="stylesheet" href="./webroot/css/style.css">
</head>

<body>
    <header id="inicio">
        <h1>Proyecto Login Logoff Tema 5</h1>
        <h2>Inicio Publico</h2>
    </header>
    <main>

        <img src="./webroot/images/modelo.png" alt="modelo de datos">

        <form action="" method="POST">
            <button name="btnLogin" class="btn btn-login"><span>Iniciar Sesion</span></button>
        </form>

    </main>
    <footer>
        <address>
            <p>&copy; 2025-2026 <span><a href="../index.html">Juan Rivera Ordoñez</a></span>- I.E.S. Los Sauces</p>
            <a href="https://github.com/juanrivord/JRODWESProyectoLoginLogoffTema5 " target="_blank"><img src="./webroot/images/github.png" alt="Imagen de github"></a>
        </address>
    </footer>
</body>

</html>