<?php

    /**
     * @author Juan Rivera Ordóñez
     * @since 12/11/2026
     * Proyecto Tema 5 - Inicio de sesion y cierre de sesion
     */
        // comprueba si el boton btnCancelar fue pulsado
        if (isset($_REQUEST['btnCancelar'])) {
            // encaso de que si, vuelve al indice
            header("Location: ../indexProyectoLoginLogoffTema5.php");
            exit;
        }
        require_once '../config/configDBPDO.php';
        require_once '../core/231018libreriaValidacion.php';
        //Inicializacion de variables
        $entradaOK = true; // Variable que nos indica que todo va bien
        $usuarioEncontrado = true; //Variable que nos indica si el usuario del login existe
        //Array donde recogemos los mensajes de error
        $aError = [
            'usuario' => "",
            'contrasena' => ""];
        //Array donde recogemos la respuestas correctas
        $aRespuesta = [
            'usuario' => "",
            'contrasena' => ""];

        // Comprueba si el boton login fue pulsado
        if (isset($_REQUEST["btnLogin"])) {
            // Validar Entrada
            $aError["usuario"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["usuario"],1000,1,1);
            // utilizar para la creacion de la contrasena, no la validacion
            //$aError["contrasena"] = validacionFormularios::validarPassword($passwd, $maximo, $minimo, $tipo, $obligatorio);
            $aError["contrasena"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["contrasena"],1000,1,1);
            
            foreach ($aError as $value) {
                if (!empty($value)) {
                    $entradaOK = false;
                }
            }
        }
        // El formulario no se ha enviado nunca
        else {
            $entradaOK = false;
        }
        // si los datos estan bien,
        // comprueba si el usuario existe en la base de datos
        if ($entradaOK) {
            try{
                        
                $miDB = new PDO(HOST, USER, PASSWORD);

                $sqlSelect = <<<sql
                SELECT * FROM T01_Usuario
                WHERE T01_CodUsuario = :codUsuario and T01_Password = SHA2(:password,256)
                sql;
                $selectUsuarioContrasena = $miDB->prepare($sqlSelect);
                // trim elimina espacios antes y despues del texto
                $selectUsuarioContrasena->execute([
                    ':codUsuario' => trim($_REQUEST["usuario"]),
                    ':password' => trim($_REQUEST["usuario"]).trim($_REQUEST["contrasena"])
                ]);

                if($selectUsuarioContrasena->rowCount()==1){
                    header("Location: ./inicioPrivado.php");
                    exit;
                }else{
                    $usuarioEncontrado=false;
                }

            } catch (PDOException $miExceptionPDO) {


                echo "<h3 style='margin-top:0;'>Error en la base de datos.</h3>";
                echo "<p><b>Mensaje:</b> " . $miExceptionPDO->getMessage() . "</p>";
                echo "<p><b>Código:</b> " . $miExceptionPDO->getCode() . "</p>";
            } finally {
                unset($miDB);
            }

        } 
        // Mostrar Login
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="../webroot/css/style.css">
    </head>
    <header id="inicio">
        <h1>Proyecto Login Logoff Tema 5</h1>
        <h2>Inicio de Sesion</h2>
    </header>
    <body>
        <main>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate>
                
                <label for="usuario" >Usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php echo !empty($_REQUEST["usuario"]) ? $_REQUEST["usuario"]: '' ?>"/>

                <?php echo !empty($aError["usuario"]) ? "<span style='color:red;'>" . $aError['usuario'] . "</span>": '' ?>

                <br/><br/>
                
                <label for="contrasena" >Contrasena:</label>
                <input type="password" name="contrasena" id="contrasena" value="<?php echo !empty($_REQUEST["contrasena"]) ? $_REQUEST["contrasena"]: '' ?>"/>

                <?php echo !empty($aError["contrasena"]) ? "<span style='color:red;'>" . $aError['contrasena'] . "</span>": '' ?>

                <br/>

                <input type="submit" name="btnLogin" id="btnLogin" value="Log in"/>
                <input type="submit" name="btnCancelar" id="btnCancelar" value="Cancelar"/>
                
                <?php echo !$usuarioEncontrado ? "<span style='color:red;'>Usuario no encontrado, nombre de usuario o contrasena incorrecta</span>": '' ?>

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