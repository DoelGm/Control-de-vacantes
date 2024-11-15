<?php
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){

        $empresa = $_SESSION['Empresa'];

?>
<?php
 require '../../DB/conexionbd.php';
 $sql = "SELECT p.id_Puesto, p.Puesto, p.id_Departamento, dep.Departamento FROM departamentos as dep, puestos as p, empresas as em WHERE p.id_Departamento = dep.id_Departamento AND dep.id_empresa = em.id_Empresa AND '$empresa' = em.id_Empresa"; // consulta a la tabla de puesto de la base de datos
 $resultado = mysqli_query($conexionDB, $sql);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/ortusLogo.png">
    <title>Solicitar Vacante</title>
    <link rel="stylesheet" href="../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../Styles/EstilosGlobales.css">
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

    <div class="Encabezado">
        <h1>Solicitar Vacante</h1>
    </div>

   
        <div class="formularioSolicitud">
            <form action="../Controllers/controladorSolicitarVacantes.php" method="POST" >
                <div class="datoDeSolicitud">
                <div class="col-1">

                    <label for="puesto">Puesto: </label>
                    <select style="background: rgb(255, 255, 255);" name="puesto" id="puesto"  required>
                        <option></option>
                        <?php 
                        while($consulta = mysqli_fetch_assoc($resultado)){
     
                        ?>
                        <option value="<?=$consulta["id_Puesto"]?>"><?=$consulta["Puesto"].", Departamento: ".$consulta["Departamento"]?></option>
                        <?php
                        }
                        ?>
                    </select>

                    <!-- <label for="FechaDeSolicitud">Fecha de solicitud:</label>
                    <input type="date" name="FechaDeSolicitud" id="FechaDeSolicitud" required> -->

                    <label for="FechaACubrir">Fecha a cubrir:</label>
                    <input style="background: rgb(255, 255, 255);" type="date" name="FechaACubrir" id="FechaACubrir"  required>
                    
                    <label for="Comentarios">Herramientas:</label>
                    <textarea style="background: rgb(255, 255, 255);" placeholder="Ingrese las herramientas para la vacante" name="herramientas" id="Comentario" cols="72" rows="7.5"  required></textarea>
                    
                </div>

                <div class="col-2">
                    <label for="Comentarios">Comentarios:</label>
                    <textarea style="background: rgb(255, 255, 255);" placeholder="Ingrese Comentarios" name="comentario" id="Comentario" cols="72" rows="7.5"  required></textarea>

                    <label for="No_Vacantes">No_Vacantes: </label>
                    <input style="background: rgb(255, 255, 255);" placeholder="Ingrese el numero de vacantes" id="No_Vacantes" name="No_Vacantes" type="number" min="1"  required step>

                    <!-- <label for="Status" readonly>Status:</label>
                    <select style="background: rgb(255, 255, 255);" name="Status" id=""  required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                        
                    </select> -->
                    
                 </div> 
          
                </div>

             </div>
            <input class="BTN_SolicitarVacante" type="submit" value="Solicitar">     
         </form>
        
   
</body>
</html>
<?php

}
else{
    header('Location: ../../index.php');
}