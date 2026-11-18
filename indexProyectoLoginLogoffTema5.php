<?php

    $weekTime = 7*24*60*60; // 604800 segundos son una semana
    $idioma = 'es/ES';
    setcookie ('idioma', $idioma, time() + $weekTime);

    

    if (isset($_REQUEST['btnLogin'])) {
        header("Location: ./codigoPHP/login.php");
        exit;
    } 

    if (isset($_REQUEST['btnSignIn'])) {
        header("Location: ./codigoPHP/registro.php");
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
        <img src="./webroot/images/ES.png" alt="imagen bandera españa"/>
        <img src="./webroot/images/GB.png" alt="imagen bandera reino unido"/>
        <img src="./webroot/images/PT.png" alt="imagen bandera portugal"/>
    </header>
    <main>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" name="formulario" novalidate>
            <button name="btnLogin" class="btn btn-login"><span>Iniciar Sesion</span></button>
            <button name="btnSignIn" class="btn btn-signin"><span>Registrarse</span></button>
        </form>

        <img src="./webroot/images/modelo.png" alt="modelo de datos">

    </main>
    <footer>
        <address>
            <p>&copy; 2025-2026 <span><a href="../index.html">Juan Rivera Ordoñez</a></span>- I.E.S. Los Sauces</p>
            <a href="https://github.com/juanrivord/JRODWESProyectoLoginLogoffTema5 " target="_blank"><img src="./webroot/images/github.png" alt="Imagen de github"></a>
        </address>
    </footer>
</body>

</html>