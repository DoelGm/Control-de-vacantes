<?php
require '../../DB/conexionbd.php';

    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){


  $id_aspirante = $_POST["ID"];  
  $sql = "SELECT a.* ,v.id_vacante, p.Puesto, d.Departamento FROM aspirantes as a, vacantes as v, puestos as p, departamentos AS d WHERE  v.id_vacante = a.id_Vacante AND p.id_Puesto = v.id_Puestos AND a.id_Aspirante = '$id_aspirante' AND p.id_Departamento = d.id_Departamento "; // consulta a la base de datos
  $resultado = mysqli_query($conexionDB, $sql);
  $consulta = mysqli_fetch_assoc($resultado);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../Styles/EstilosGlobales.css">
    
    <link rel="shortcut icon" href="../img/ortusLogo.png">

    <title>Historial de aspirante</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
<div class="navbar">
            <img src="../img/ortus_c.png" alt="" class="logo_imagen">
            <ul>
                    <li><a href="indexEmpleado.php">Inicio</a></li>
                    <li><a href="aspirantes.php">Aspirante</a></li>

                    <li class="dropdown">
                        <a>Empleados</a>
                        <div class="dropdown_Conetenido">
                            <a href="empleados.php">Activos</a>
                            <a href="empleadosInactivos.php">Inactivos</a>
                        </div>
                    </li>

                    <li><a href="SolicitarVacante.php">Solicitar Vacantes</a></li> 

                    <li class="Salir"><a class="Salir" href="../../DB/CerrarSesion.php">Salir</a></li>
            </ul>
        </div>

    <h2 class="Encabezado">Historial</h2>

    <div id="informacion">
        <label for="nombre">Nombre</label>
        <input type="text" value="<?= $consulta["Nombre"]." ".$consulta["Apellido_paterno"]." ".$consulta["Apellido_materno"]?>" readonly id="nombre">
        <label for="vacante">Vacante</label>
        <input type="text" value="<?= $consulta["Puesto"].", ".$consulta['Departamento']?>" readonly id="vacante">
    </div>

    <!-- tabla de Entrevistas -->
    <div class="contenedorTablaEntrevista">
    <h2 id="TituloEntrevistas">Historial de estrevistas</h2>
    
    <form action="entrevistaAspirante.php" method="post">
        <button type="submit" class="BTN_Historial_Aspirante" value="<?php echo $id_aspirante ?>" name="ID">Nueva Entrevista</button>
    </form>
    
    <table id="tablaEntrevista">
        <thead>
            <tr>
            <th scope="col">Fecha de Entrevista</th>
            <th scope="col">Comentarios</th>
            <th scope="col">Archivo</th>
            </tr>
        </thead>
        <tbody>
        <?php
        require '../../DB/conexionbd.php';
        // $sql = " SELECT * FROM aspirantes"; // consulta a la base de datos
        $sql2 = "SELECT e.* FROM entrevista as e WHERE e.id_Aspirante ='$id_aspirante'";
        // $resultado = mysqli_query($mysqli, $sql);
        $resultado2 = mysqli_query($conexionDB, $sql2);
        ?>
        <?php 
            while ($consulta2 = mysqli_fetch_assoc($resultado2) ) {
                    
                ?>
            <tr>
            <th scope="row"><?php echo $consulta2["fecha"] ?></th>
            <td id="tdComentarios" ><?php echo $consulta2["comentario"] ?></td>
            <th>

            <form action="../Controllers/ControladorDescargarArchivoEntrevista.php" method="post">
                <button class="BTN_Desacargar" type="submit" name="Archi_Entrevista" value="<?php echo $consulta2['id_entrevista']; ?>">
                    <i class="fa-solid fa-download fa-lg"></i>
                </button>
            </form>

            </th>
            <?php
              }
            ?>
            </tr>
        </tbody>
        </table>
   </div>
   <!-- tabla de tabla de Examen Medico -->
   <div class="ContenedorTablaExamenMedico">
    <h2 id="TituloEntrevistas">Historial de Examenes Medicos</h2>
    
    <form action="ExamenMedico.php" method="post">
        <button type="submit" class="BTN_Historial_Aspirante" value="<?php echo $id_aspirante?>" name="ID" >Nuevo examen</button>
    </form>

    <div class="informacionExamenMedico">
    </div>
    <table id="tablaExamenMedico">
        <thead>
            <tr>
            <th scope="col">Tipo de examen</th>
            <th scope="col">Fecha de Aplicacion</th>
            <th scope="col">Comentarios</th>
            <th scope="col">Aplico</th>
            <th scope="col">Archivo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql3 = "SELECT ema.*, empl.Nombre, empl.Apellido_materno, 
            empl.Apellido_paterno, tem.* FROM tipos_examen_medico as tem, examen_servicio_medico_vacante as esmv, 
            empleados as empl, examen_medico_aspirante AS ema, 
            aspirantes AS a WHERE esmv.id_tipo = tem.id_tipo_examen AND ema.id_examen = esmv.id_examen 
            AND id_Empleado = id_empleados_aplico AND 
            ema.id_aspirante = a.id_Aspirante AND a.id_Aspirante = '$id_aspirante'";
            $resultado4 = mysqli_query($conexionDB , $sql3);
            

            ?>
            <?php
            while($consulta4 = mysqli_fetch_assoc($resultado4)) { 
            
            ?>
            <tr>
            <th scope="row"><?php echo $consulta4["examen"]?></th>
            <th><?php echo $consulta4["fecha"]?></th>
            <td id="tdComentarios" ><?php echo $consulta4["Comentarios"]?></td>
            <th><?php echo $consulta4["Nombre"]." ".$consulta4["Apellido_paterno"]." ".$consulta4["Apellido_materno"]?></th>
            <th>
            <form action="../Controllers/ControladorDescargarArchivoExamen.php" method="post">
                <button class="BTN_Desacargar" type="submit" name="id_examen_DOC" value="<?php echo $consulta4['id_examen_aspirante']; ?>">
                    <i class="fa-solid fa-download fa-lg"></i>
                </button>
            </form>
            </th>
            </tr>
                <?php
            }

                ?>
        </tbody>
        </table>
   </div>
   <!-- tabla de tabla de Documentos  -->
   <div class="contenedorDocumentos">
    <h2 id="TituloEntrevistas">Historial de Documentos</h2>
    
    <form action="CargarArchivosAspirante.php" method="POST">
        <button type="submit" value="<?php echo $id_aspirante ?>" name="ID_Aspirante" class="BTN_Historial_Aspirante">Nuevo documento</button>
    </form>
    
    <?php
        
        $sql4 = "SELECT doc.* FROM documentos AS doc, aspirantes AS a, vacantes AS va WHERE a.id_Aspirante = '$id_aspirante' AND a.id_Vacante = va.id_vacante AND doc.id_vacante = va.id_vacante";

        $resulta = mysqli_query($conexionDB, $sql4);

        $SQLvalidacion = " SELECT da.Archivo, da.id_documento, da.id_documento_aspirante FROM aspirantes AS a, vacantes AS va, documentos AS doc, documentos_aspirantes AS da WHERE a.id_Aspirante = '$id_aspirante' AND a.id_Vacante = va.id_vacante AND doc.id_vacante = va.id_vacante AND da.id_documento = doc.id_documento AND da.id_Aspirante = '$id_aspirante'";

        $ValidacionResultado = mysqli_query($conexionDB, $SQLvalidacion);

        

    ?>
   <table id="tablaDocumentos">
    <thead>
        <tr>
        <th scope="col">Documentos</th>
        <th scope="col">Presento</th>
        <th scope="col">Archivo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while($consulta3 = mysqli_fetch_assoc($resulta)) {
        echo '<tr>';
        echo '<td>'.$consulta3["Nombre_Documento"].'</td>';
        
        $presento = "NO";
        
        while($fila = mysqli_fetch_assoc($ValidacionResultado)){
            if(isset($fila['Archivo']) && $fila['id_documento'] == $consulta3['id_documento']){
            $presento = "SI";
            break; // Se encontró el documento, se sale del bucle interno
            }
        }
        
        echo '<td>'.$presento.'</td>';

        echo '<td class="">';
            ?>
            <form action="../Controllers/ControladorDescargarArchivo.php" method="post">

                <input hidden value="<?php echo $id_aspirante?>" name="id_Aspirante">

                <button class="BTN_Desacargar" type="submit" name="id_doc" value="<?php echo $fila['id_documento_aspirante'] ?>">
                    <i class="fa-solid fa-download fa-lg"></i>
                </button>

            </form>
            <?php
        echo '</td>';
        echo '</tr>';
        
        // Reiniciar el puntero del resultado de ValidacionResultado
        mysqli_data_seek($ValidacionResultado, 0);

        
        }
        ?>
    </tbody>
</table>


   </div>

</body>
</html>

<?php
}
else{
    header('Location: ../../index.php');
}
    