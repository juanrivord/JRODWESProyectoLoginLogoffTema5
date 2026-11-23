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
    </head>
    <header id="inicio">
        <h1>Proyecto Login Logoff Tema 5</h1>
        <h2>Mantenimiento de departamentos</h2>
    </header>
    <body>
        <main>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" name="formulario" novalidate>
            <input type="submit" name="btnVolver" value="Volver"/>
        </form>

        <?php
        require_once '../core/231018libreriaValidacion.php';
        require_once '../config/configDBPDO.php';

        // CONEXION ACERTADA
        try{
            $miDB = new PDO(HOST,USER,PASSWORD);

            $consulta = $miDB->query("SELECT * FROM T02_Departamento");

            echo "<h3>DEPARTAMENTOS</h3>";
            echo '<table>';
            echo '<thead>';
            echo '<th>Código</th>';
            echo '<th>Descripción</th>';
            echo '<th>Fecha de creación</th>';
            echo '<th>Volumen de negocio</th>';
            echo '<th>Fecha de baja</th>';                       
            echo '</thead>';
            while ($registro = $consulta->fetchObject()) {
                echo("<tr>");
                echo("<td>".$registro->T02_CodDepartamento."</td>");
                echo("<td>".$registro->T02_DescDepartamento."</td>");
                // Construimos la fecha a partir de la que hay en la base de datos, una nueva por cada vez que sacamos una fecha
                $oFechaAlta = new DateTime($registro->T02_FechaCreacionDepartamento);
                // La mostramos formateada
                echo("<td>".$oFechaAlta->format('d/m/Y')."</td>");
                // Formateamos el numero para que se vea en euros €
                echo("<td>".number_format($registro->T02_VolumenDeNegocio,2,',','.')."€</td>");
                // Si la fecha esta vacia no la creamos, en cambio si exite, creamos el objeto de fecha
                if (is_null($registro->T02_FechaBajaDepartamento)) {
                    echo '<td></td>';
                } else {
                    $oFechaBaja = new DateTime($registro->T02_FechaBajaDepartamento);
                    echo '<td>'.$oFechaBaja->format('d/m/Y').'</td>';
                }
                echo("</tr>");
            }

            echo("</table>");


           
            
        } catch (PDOException $e) {
            echo "ERROR: ".$e->getMessage()."<br/>";
        } finally{
            unset($miDB);
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