<?php
/**
 * @author Juan Rivera Ordóñez
 * @since 23/11/2026
 * Proyecto Tema 5 - Inicio de sesion y cierre de sesion
 */

//Recuperamos la sesion
session_start();

// Si el usuario no ha iniciado la sesion, lo echamos al login
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
        <title>Programa</title>
        <link rel="stylesheet" href="../webroot/css/style.css">
        <style>
            form.volver{
                position: absolute;
                left: 0;top: 0;
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
        <h2>Mantenimiento de departamentos</h2>
    </header>
    <body>
        <main>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" name="formulario" class="volver" novalidate>
            <input type="submit" name="btnVolver" id="volver" value="Volver"/>
        </form>

         <?php
        require_once '../core/231018libreriaValidacion.php'; // Libreria de validación utilizada
        require_once '../config/configDBPDO.php'; // Constantes mas utilizadas (conexion BD) y algunos parametros siempre utilizados

            //Inicializacion de variables

            $entradaOK = true; // Variable que nos indica que todo va bien

            //Array donde recogemos los mensajes de error
            $aError = [
                'departamentoABuscar' => ""];

            //Array donde recogemos la respuestas correctas
            $aRespuesta = [
                'departamentoABuscar' => ""];

            // Comprueba si el formulario se a enviado
            if (isset($_REQUEST["enviar"])) {
                // Validar Entrada
    
                $aError["departamentoABuscar"] = validacionFormularios::comprobarAlfabetico($_REQUEST["departamentoABuscar"],50,1,0);

                foreach ($aError as $value) {
                    if (!empty($value)) $entradaOK = false;
                }
            }

            // El formulario no se ha enviado nunca
            else {
                $entradaOK = false;
            }

            ?>

            <div class="buscador">
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" novalidate>
                        <label for="departamentoABuscar" class="titulo-busqueda">Mantenimiento de Departamentos</label><br>

                        <input type="text" name="departamentoABuscar" id="departamentoABuscar" placeholder="Descripción (vacío busca todos)" value="<?php echo isset($_REQUEST['departamentoABuscar']) ? htmlspecialchars($_REQUEST['departamentoABuscar']) : ''; ?>">
                        <span class="error"><?php echo $aError['departamentoABuscar']; ?></span>

                        <button type="submit" name="enviar">Buscar</button>
                    </form>  
                </div>

            <?php

            if ($entradaOK) { // La entrada está bien, se conecta a la base de datos

            //Cargar la variable $aRespuestas y tratamiento de datos OK
            $aRespuesta["departamentoABuscar"] = $_REQUEST["departamentoABuscar"];
             
        // Comienza la conexión de base de datos con gestion de extensiones
        try{ 
            $miDB = new PDO(HOST,USER,PASSWORD); // Conexión PDO


            // Construccion de la sentencia SQL concatenando  
            $listaDepartamentos = $miDB->query("select * from T02_Departamento where T02_DescDepartamento like '%" . $aRespuesta['departamentoABuscar'] . "%'");

            
             if ($listaDepartamentos->rowCount() > 0) {
                            
                            echo '<table class="tabla-departamentos" style="margin: 15px auto;">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th class="texto-centro">Código</th>';
                            echo '<th>Descripción</th>';
                            echo '<th class="texto-centro">Fecha de Alta</th>';
                            echo '<th class="texto-derecha">Volumen de Negocio</th>';
                            echo '<th class="texto-centro">Fecha de Baja</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            
                            while ($oDepartamento = $listaDepartamentos->fetchObject()) {
                                echo '<tr>';
                                echo '<td class="texto-centro"><b>' . $oDepartamento->T02_CodDepartamento . '</b></td>';
                                echo '<td>' . $oDepartamento->T02_DescDepartamento . '</td>';

                                // Formateo de la fecha de alta a formato español (d/m/Y)
                                $fechaCreacionDepartamento = new DateTime($oDepartamento->T02_FechaCreacionDepartamento);
                                echo '<td class="texto-centro">' . $fechaCreacionDepartamento->format('d/m/Y') . '</td>';

                                // Formateo del numero a moneda española
                                echo '<td class="texto-derecha">' . number_format($oDepartamento->T02_VolumenDeNegocio, 2, ',', '.') . ' €</td>';

                                // Comprobacion en la fecha de baja
                                if (is_null($oDepartamento->T02_FechaBajaDepartamento)) {
                                    echo '<td class="texto-centro">-</td>';
                                } else {
                                    $fechaBajaDepartamento = new DateTime($oDepartamento->T02_FechaBajaDepartamento);
                                    echo '<td class="texto-centro">' . $fechaBajaDepartamento->format('d/m/Y') . '</td>';
                                }
                                echo '</tr>';
                            }
                            
                            echo '</tbody>';
                            echo '</table>';                                                  
                        } 
            
            } catch (PDOException $e) {
                echo "ERROR: ".$e->getMessage()."<br/>";
            } finally{
                unset($miDB);
            }
                    
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