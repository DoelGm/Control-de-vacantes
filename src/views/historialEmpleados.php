<?php
    require '../../DB/conexionbd.php';
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){

    $id_empleado = $_POST["ID"];

    $query ="SELECT em.*, p.id_Puesto, p.Puesto, d.Departamento, a.id_Aspirante  FROM  empleados AS em, puestos AS p, departamentos AS d, aspirantes AS a WHERE  em.id_Empleado = '$id_empleado' AND em.id_Puesto = p.id_Puesto AND p.id_Departamento = d.id_Departamento AND em.id_Aspirante = a.id_Aspirante";

    $resultado = mysqli_query($conexionDB, $query);
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
    <title>Historial de Empleado</title>

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
    <br>
    <h2 id="Titulo">Historial</h2>
    <div id="informacion">
        <label for="nombre">Nombre</label>
        <input type="text" value="<?= $consulta["Nombre"]." ".$consulta["Apellido_paterno"]." ".$consulta["Apellido_materno"]?>" readonly id="nombre">
        <label for="vacante">Puesto</label>
        <input type="text" value="<?= $consulta["Puesto"].", ". $consulta["Departamento"]?>"  readonly id="vacante">
    </div>

<!-- Tabla de Entrevistas -->
    <div class="contenedorTablaEntrevista">
    <h2 id="TituloEntrevistas">Historial de estrevistas</h2>
    
    <form action="entrevistaAspirante.php" method="post">
        <button type="submit" class="BTNuevaEntrevista" value="<?php echo $consulta['id_Aspirante']?>" name="ID" >Nueva Entrevista</button>
    </form>


    <table id="tablaEntrevista">
        <thead>
            <tr>
            <th scope="col">Fecha de Entrevista</th>
            <th scope="col">Comentarios</th>
            <th scope="col">Archivos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query2 = "SELECT e.* FROM entrevista AS e, aspirantes AS a, empleados AS em WHERE e.id_Aspirante = a.id_Aspirante AND em.id_Empleado = '$id_empleado' AND em.id_Aspirante = a.id_Aspirante";
            $resultado2 = mysqli_query($conexionDB, $query2);

            while ($consulta2 = mysqli_fetch_assoc($resultado2)) {

            
            ?>
            <tr>
            <th scope="row"><?php echo $consulta2["fecha"] ?></th>

            <td id="tdComentarios" ><?php echo $consulta2["comentario"] ?> </td>

            <th>

            <form action="../Controllers/ControladorDescargarArchivoEntrevista.php" method="post">
                <button class="BTN_Desacargar" type="submit" name="Archi_Entrevista" value="<?php echo$consulta2['id_entrevista'] ?>">
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
    <h2 id="TituloExamenMedico">Historial de Examenes Medicos</h2>

    <form action="ExamenMedico.php" method="POST">
        <button type="submit" class="BTNexamenMedico" value="<?php echo $consulta['id_Aspirante'] ?>" name="ID">Aplicar nuevo examen</button>
    </form>


    <table id="tablaExamenMedico">
        <thead>
            <tr>
            <th scope="col">Tipo de examen</th>
            <th scope="col">Fecha de Aplicacion</th>
            <th scope="col">Comentarios</th>
            <th scope="col">Aplico</th>
            <th scope="col">Archivos</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query3 = "SELECT ema.*, tem.examen, a.id_Aspirante FROM empleados AS em, aspirantes AS a, tipos_examen_medico AS tem, examen_servicio_medico_vacante AS esmv, examen_medico_aspirante AS ema WHERE em.id_Empleado = '$id_empleado' AND em.id_Aspirante = a.id_Aspirante AND ema.id_aspirante = a.id_Aspirante AND ema.id_examen = esmv.id_examen AND esmv.id_tipo = tem.id_tipo_examen";

                $resultado3 = mysqli_query($conexionDB, $query3);

                while($consulta3 = mysqli_fetch_assoc($resultado3)) {   

                    $examen = $consulta3['id_examen_aspirante']; 
                    $aspirante = $consulta['id_Aspirante'];
                    $QuienAplico = "SELECT em.Nombre, em.Apellido_paterno, em.Apellido_materno FROM examen_medico_aspirante AS ema, empleados AS em WHERE ema.id_examen_aspirante = '$examen' AND ema.id_aspirante = '$aspirante' AND ema.id_empleados_aplico = em.id_Empleado";

                    $resultadoAplico = mysqli_query($conexionDB, $QuienAplico);
                    $Aplico = mysqli_fetch_assoc($resultadoAplico);
            ?>
            <tr>
            <th scope="row"><?php echo $consulta3["examen"]?></th>
            <th><?php echo $consulta3["fecha"] ?></th>
            <td id="tdComentarios" ><?php echo $consulta3["Comentarios"]?></td>
            <th><?php echo $Aplico["Nombre"]. " ".$Aplico["Apellido_paterno"]. " " .$Aplico["Apellido_materno"]?></th>
            <th>

            <form action="../Controllers/ControladorDescargarArchivoExamen.php" method="post">
                <button class="BTN_Desacargar" type="submit" name="id_examen_DOC" value="<?php echo$consulta3['id_examen_aspirante'] ?>">
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
    <h2 id="tituloTablaDocumentos">Historial de Documentos</h2>

    <form action="CargarArchivosEmpleado.php" method="POST">
        <button type="submit" value="<?php echo $id_empleado ?>" name="ID_Empleado" class="BTNDocumentos">Subir nuevos documento</button>
    </form>

    <?php
        $query4 = "SELECT doc.*, a.id_Aspirante FROM documentos AS doc, aspirantes AS a, empleados AS em, vacantes AS va WHERE em.id_Empleado = '$id_empleado' AND  em.id_Aspirante = a.id_Aspirante AND em.id_Vacante = va.id_vacante AND doc.id_vacante = va.id_vacante";

        $resultado4 = mysqli_query($conexionDB, $query4);
        
        $ValidacionSQL = "SELECT da.Archivo, da.id_documento, da.id_documento_aspirante FROM empleados AS em, aspirantes AS a, vacantes AS va, documentos AS doc, documentos_aspirantes AS da WHERE em.id_Empleado = '$id_empleado' AND em.id_Vacante = va.id_vacante AND doc.id_vacante = va.id_vacante AND da.id_documento = doc.id_documento AND da.id_Aspirante = em.id_Aspirante";

        $ValidacionResultado = mysqli_query($conexionDB , $ValidacionSQL);
    ?>

    <table id="tablaDocumentos">
        <thead>
            <tr>
                <th colspan="3">Archivos de Aspirante</th>
            </tr>
            <tr>
                <th scope="col">Documentos</th>
                <th scope="col">Presento</th>
                <th scope="col">Archivo</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while($consulta4 = mysqli_fetch_assoc($resultado4)){
                
            ?>

                <tr>
                <td><?php echo $consulta4["Nombre_Documento"] ?></td>
                <?php
                $presento = "NO";

                while($Fila = mysqli_fetch_assoc($ValidacionResultado)){
                    if(isset($Fila["Archivo"]) && $Fila["id_documento"] == $consulta4["id_documento"]){
                        $presento = "SI";
                        break;
                    }
                }

                ?>
                <td><?php echo $presento ?></td>
                <td>
                    <form action="../Controllers/ControladorDescargarArchivo.php" method="POST">

                        <input hidden value="<?php echo $consulta4['id_Aspirante']?>" name="id_Aspirante">

                        <button class="BTN_Desacargar" value="<?php echo $Fila['id_documento_aspirante'];?>" name="id_doc">
                        <i class="fa-solid fa-download fa-lg"></i>
                    </button>
                    </form>
                </td>
                </tr>

            <?php
                mysqli_data_seek($ValidacionResultado, 0);
                }
            ?>
        </tbody>
    </table>


<!-- _____________Separacion, esta es otra tabla ________ -->

<?php
    $query5 = "SELECT doc.*, de.* FROM documentos AS doc, documentos_empleados AS de, empleados AS em, vacantes AS va WHERE em.id_Empleado = '$id_empleado' AND em.id_Vacante = va.id_vacante AND doc.id_vacante = va.id_vacante AND doc.id_documento = de.id_documento AND de.id_empleado = '$id_empleado'";

    $respuesta = mysqli_query($conexionDB, $query5);
?>

    <table id="tablaDocumentos">

    <thead>
            <tr>
                <th colspan="3">Archivos de Empleado</th>
            </tr>
            <tr>
                <th scope="col">Documentos</th>
                <th scope="col">Archivo</th>
            </tr>
        </thead>

        <tbody>
            <?php
                    while($row = mysqli_fetch_assoc($respuesta)){
                    
                    ?>
                    <tr>
                    <td><?php echo $row['Nombre_Documento'] ?></td>
                    <td>
                        
                        <form action="../Controllers/ControladorDescargarArchivoEmpleado.php" method="POST">

                            <button class="BTN_Desacargar" type="submit" name="id_Documento" value="<?php echo $row['id_documento_empleado']?>">
                                <i class="fa-solid fa-download fa-lg"></i>
                            </button>
                            
                        </form>

                    </td>
                    </tr>
                    <?php
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