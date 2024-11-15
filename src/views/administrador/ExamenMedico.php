<?php
require '../../../DB/conexionbd.php';
session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['IDAdmin'];

    if(isset($_SESSION['IDAdmin'])){


$idAspirante = $_POST["ID"];

$sql = "SELECT a.* ,v.id_vacante, p.Puesto FROM aspirantes as a, vacantes as v, puestos as p WHERE  v.id_vacante = a.id_Vacante AND p.id_Puesto = v.id_Puestos AND id_Aspirante = '$idAspirante'" ; // consulta a la base de datos
$resultado = mysqli_query($conexionDB, $sql);
$consulta = mysqli_fetch_assoc($resultado);
$idVacante = $consulta["id_vacante"];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../img/ortusLogo.png">
    <title>Examen Medico</title>
    <link rel="stylesheet" href="../../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../../Styles/EstilosGlobales.css">
    
    
</head>
<body>
<div class="navbar">
        <img src="../../img/ortus_c.png" alt="" class="logo_imagen">
            <ul>
                    <li><a href="indexAdmin.php">Inicio</a></li>
                    <li><a href="aspirantesadmin.php">Aspirante</a></li>

                    <li class="dropdown">
                        <a>Empleados</a>
                        <div class="dropdown_Conetenido">
                            <a href="empleadosadmin.php">Activos</a>
                            <hr> 
                            <a href="empleadosInactivosAdmin.php">Inactivos</a>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a>Opciones de Administrador</a>
                        <div class="dropdown_Conetenido">
                            <a href="catalogoDocumento.php">Nuevos Documentos</a>
                            <hr>
                            <a href="Vacantes.php">Control de Nuevas Vacantes </a>
                            <hr> 
                            <a href="catalogoHerramientas.php">Nuevas Herramentas</a> 
                            <hr>
                            <a href="CrearVacante.php">Crear Vacante</a>
                        </div>
                    </li>

                    <li><a href="../../../DB/CerrarSesion.php">Salir</a></li>
            </ul>
</div>


    <div class="Encabezado">
        <h1>Exámenes médicos</h1>
    </div>

    
        <div class="formularioExamenmedico">
            <form action="../../Controllers/controladorExamenMedico.php" method="POST" enctype="multipart/form-data">
                <div class="datoDeExamenMedico">
                <div class="col-1">
                    <label for="nombre">Nombre: </label>
                    <input id="nombre" name="nombre" type="text" value="<?= $consulta["Nombre"]." ".$consulta["Apellido_paterno"]." ".$consulta["Apellido_materno"]?>" readonly></input>
                    <input name="idAspirante" type="number" hidden value="<?=$consulta["id_Aspirante"]?>">
                    <label for="Vacante">Vacante: </label>
                    <input id="Vacante" value="<?= $consulta["Puesto"]?>" name="Vacante" type="text" readonly>
                    
                    <label for="ExamenMedico">Tipo de examen medico:</label>
                    <select style="background: rgb(255, 255, 255);" name="TipoExamen" id="ExamenMedico" required>
                        <option></option>
                        <?php
                            // subconsulta para obtener datos sobre los examnes medicos y poder validarlos depues...
                            $sql2 = "SELECT esmv.id_tipo, v.id_vacante, esmv.id_vacante, tem.* FROM tipos_examen_medico as tem, vacantes as v,  examen_servicio_medico_vacante as esmv WHERE esmv.id_tipo = tem.id_tipo_examen AND esmv.id_vacante = v.id_vacante";
                            $resultado2 = mysqli_query($conexionDB, $sql2);
                            // bucle para mostrar todas tipos de examenes medicos al usuario mientras sea tru la consulta se guardara en la variable consulta
                            while($consulta2 = mysqli_fetch_assoc($resultado2)){
                                // Guardamos los ids de las vacantes en nuestra varaible para luego poder validarlo
                                $idVacanteExamen = $consulta2["id_vacante"];
                                // se validad y solo se mostraran los examenes medicos dependiendo la vacante 
                                 if($idVacante == $idVacanteExamen){
                            
                        ?>
                        <!-- mostramos los tipos de examenes al usuario -->
                        <option id="TipoExamen" value="<?= $consulta2["id_tipo_examen"] ?>"><?php echo $consulta2["examen"]?></option>
                        <?php
                                 }    
                         }
                        ?>
                   
                        <i></i>
                    </select>
                     
                    <label for="FechaDeExamen">Fecha de Examen</label>
                    <input style="background: rgb(255, 255, 255);"readonly value="Fecha Automatica">

                    <label for="examenAprobo">Aprobó:</label>
                    <p id="si">SI</p><input type="radio" value="1" name="examenAprobo" id="examenAprobo" required>
                    <p id="si">NO</p><input type="radio" value="0" name="examenAprobo" id="examenAprobo" required>
        
                    </div>

                    <div class="col-2">
    
                    <label for="Comentarios">Comentarios:</label>
                    <textarea name="comentario" id="Comentario" placeholder="Ingrese Comentarios" cols="72" rows="7"></textarea>
               
                    
               <label for="Archivo">Examenes:</label>
                    <input type="file" style="background: rgb(255, 255, 255);" name="examen" id="examen" accept=".pdf, .jpg, .png" multiple>

                </div>
                
                </div>
                <input style="width: 80px; text-align: center; margin-top: 10px; margin-right: 420px; background-color: #1a2740; height: 35px; " class="BTNguardar" type="submit" value="Guardar">
            </form>
        
    </div>
</body>
</html>

<?php
    }
    else{
        header('Location: ../../../index.php');
    }
?>