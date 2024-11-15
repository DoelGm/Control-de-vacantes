<?php
 require '../../DB/conexionbd.php';
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $opcionSeleccionada = $_POST["opciones"];
        }

         if(isset($_POST["enviar"])){
            $fechaSolicitud = $_POST["FechaDeSolicitud"];
            $fechaCubrir = $_POST["FechaACubrir"];
            $comentarios = $_POST["comentario"];
            $noVacantes = $_POST["No_Vacantes"];
            $Status = $_POST["status"];
            $idPuesto = $_POST["idPuesto"];
            $sql = "INSERT INTO vacantes_por_autorizar (`id_Puestos`, `id_empleado_solicitud`, `Fecha_Solicitud`, `Fecha_cubrir`, `Comentarios`,`Status`) VALUE ('$idPuesto', '$ID','$fechaSolicitud', '$fechaCubrir', '$comentarios', '$Status')";
            $insert = mysqli_query($conexionDB, $sql); 
            
            $sqlActualizar = "UPDATE vacantes SET Vacante_autorizada = '$opcionSeleccionada', noVacantes_Aceptar = '$noVacantes' WHERE '$opcionSeleccionada' = id_vacante";
            $update = mysqli_query($conexionDB, $sqlActualizar);
            

            
         }
        

        $empresa = $_SESSION['Empresa'];
        
        
    

?>
<?php
 $sql = "SELECT p.id_Puesto, p.Puesto, v.* FROM vacantes as v, departamentos as dep, puestos as p, empresas as em WHERE p.id_Departamento = dep.id_Departamento AND dep.id_empresa = em.id_Empresa AND '$empresa' = em.id_Empresa AND v.id_Puestos = p.id_Puesto"; // consulta a la tabla de puesto de la base de datos
 $resultado = mysqli_query($conexionDB, $sql);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Vacante</title>
    <link rel="stylesheet" href="../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../Styles/EstilosGlobales.css">
</head>
<body>
   
<div class="navbar">
            <img src="../img/ortus_c.png" alt="" class="logo_imagen">
            <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="aspirantes.php">Aspirante</a></li>

                    <li class="dropdown">
                        <a>Empleados</a>
                        <div class="dropdown_Conetenido">
                            <a href="empleados.php">Activos</a>
                            <a href="empleadosInactivos.php">Inactivos</a>
                        </div>
                    </li>

                    <li><a href="SolicitarVacante.php">Solicitar Vacantes</a></li> 

                    <li><a href="../../DB/CerrarSesion.php">Salir</a></li>
            </ul>
        </div>

    <div class="Encabezado">
        <h1>Actualizar Vacante</h1>
    </div>

   
        <div class="formularioSolicitud">

            <form action="" method="POST" >
                <div class="datoDeSolicitud">
                <div class="col-1">

                    <label for="puesto">Puesto: </label>
                    <select style="background: rgb(255, 255, 255);" name="opciones" onchange="submitForm2()" id="puesto" required>
                        <option></option>
                        <?php 
                        while($consulta = mysqli_fetch_assoc($resultado)){
                            echo '<option' . (($opcionSeleccionada == $consulta['id_vacante']) ? ' selected' : '') . ' value="'.$consulta['id_vacante'].'">'. $consulta['Puesto'].'</option>';
                        }
                        ?>
                        
                    </select>
                    <noscript><input type="submit" value="Enviar"></noscript>
                    <script>
                        function submitForm2() {
                            // Envía el formulario automáticamente cuando se selecciona una opción
                            document.querySelector('form').submit();
                        }
                    </script>
                    <?php
                        if(isset($opcionSeleccionada)){
                         $sql2 = "SELECT v.*, p.no_vacante, p.id_Puesto  FROM vacantes as v, puestos as p WHERE v.id_vacante = '$opcionSeleccionada' AND p.id_Puesto = v.id_Puestos "; // consulta a la tabla de puesto de la base de datos
                         $resultado2 = mysqli_query($conexionDB, $sql2);
                         $consulta2 = mysqli_fetch_assoc($resultado2);
                        }
                    ?>
                    <label for="FechaDeSolicitud">Fecha de solicitud:</label>
                    <input style="background: rgb(255, 255, 255);" type="datetime" value="<?= $consulta2["Fecha_Solicitud"] ?>" name="FechaDeSolicitud" id="FechaDeSolicitud" required>

                    <input style="background: rgb(255, 255, 255);" type="number" value="<?= $consulta2["id_Puesto"] ?>" name="idPuesto" hidden>

                    <label for="FechaACubrir">Fecha a cubrir:</label>
                    <input style="background: rgb(255, 255, 255);" type="date" value="<?= $consulta2["Fecha_cubrir"] ?>" name="FechaACubrir" id="FechaACubrir"  required>
                   
                    <label for="Status">Status: </label>
                    <select style="background: rgb(255, 255, 255);" name="status" id="Status"  required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                        
                    </select>
                    
                </div>

                <div class="col-2">
                    <label for="Comentarios">Comentarios:</label>
    
                    <textarea style="background: rgb(255, 255, 255);" name="comentario" id="Comentario" cols="72" rows="7.5" required><?php if(isset($consulta2["Comentarios"])){
                                echo $consulta2["Comentarios"];
                          }else{
                            echo "";
                          }
                    ?></textarea>

                    <label for="No_Vacantes">Numero de vacantes existentes: </label>
                    <input style="background: rgb(255, 255, 255);"  id="No_Vacantes" value="<?=$consulta2["no_vacante"]?>" name="No_Vacantes" type="number" min="1"  required step>

                   
                    
                 </div> 
          
                </div>

             </div>
             
            <input class="BTN_ActualizarVacante" type="submit" name="enviar" value="Solicitar Actualizacion">     
         </form>
        
   
</body>
</html>
<?php

    }
    else{
        header('Location: login.php');
    }