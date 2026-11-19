<?php

$weekTime = 7 * 24 * 60 * 60; // 604800 segundos son una semana
$idiomasValidos = ['es/ES', 'en/GB', 'pt/PT'];

// Si se ha pulsado una bandera, guardamos el idioma elegido en la cookie
if (isset($_REQUEST['idioma']) && in_array($_REQUEST['idioma'], $idiomasValidos)) {
    setcookie('idioma', $_REQUEST['idioma'], time() + $weekTime);
    header('Location: ' . $_SERVER['PHP_SELF']); // recargamos para que $_COOKIE tenga el valor nuevo
    exit;
}

// Si no existe la cookie, ponemos español por defecto
if (!isset($_COOKIE['idioma'])) {
    $idioma = 'es/ES';
    setcookie('idioma', $idioma, time() + $weekTime);
} else {
    $idioma = $_COOKIE['idioma'];
}

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
    <script src="../webroot/script/script.js" defer></script>
    <style>
        header form.idiomas {
            position: relative;
            background: transparent;
            left: 90vw;

            button {
                background: transparent;
                border: none;
                padding: 0;
                cursor: pointer;
            }

            button img {
                border: 2px solid transparent;
                border-radius: 50%;
                opacity: 0.5;
                transition: opacity 0.2s, border-color 0.2s;
            }

            button.activo img {
                border-color: white;
                opacity: 1;
            }
        }

        form img {
            max-width: 30px;
        }
    </style>

</head>

<body>
    <header id="inicio">
        <h1>Proyecto Login Logoff Tema 5</h1>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="idiomas">
            <button type="submit" name="idioma" value="es/ES" class="<?php echo $idioma === 'es/ES' ? 'activo' : '' ?>"><img src="./webroot/images/ES.png"
                    alt="imagen bandera españa" /></button>
            <button type="submit" name="idioma" value="en/GB" class="<?php echo $idioma === 'en/GB' ? 'activo' : '' ?>"><img src="./webroot/images/GB.png"
                    alt="imagen bandera reino unido" /></button>
            <button type="submit" name="idioma" value="pt/PT" class="<?php echo $idioma === 'pt/PT' ? 'activo' : '' ?>"><img src="./webroot/images/PT.png"
                    alt="imagen bandera portugal" /></button>
        </form>

        <h2>Inicio Publico</h2>
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
            <a href="https://github.com/juanrivord/JRODWESProyectoLoginLogoffTema5 " target="_blank"><img
                    src="./webroot/images/github.png" alt="Imagen de github"></a>
        </address>
    </footer>
</body>

</html>