
<?php
    require '../../../DB/conexionbd.php';
    session_start();

     $nombre = $_SESSION['Nombre'];
     $departamento = $_SESSION['Departamento'];
     $ID = $_SESSION['Identificador'];

     if(isset($_SESSION['Identificador'])){
    
         $empresa = $_SESSION['Empresa'];

         $sql = "SELECT empl.id_Empleado, empl.Nombre, empl.Apellido_paterno, empl.Apellido_materno, p.Puesto,
               GROUP_CONCAT(h.nombre_herramienta SEPARATOR '<br>') as herramientas,
               GROUP_CONCAT(IFNULL(h.no_serie, 'No tiene numero de serie') SEPARATOR '<br>') as tipos,
               GROUP_CONCAT(IFNULL(he.fecha_asignacion, '') SEPARATOR '<br>') as fechas_asignacion,
               GROUP_CONCAT(IFNULL(he.fecha_devolucion, 'Aun no se a devuelto') SEPARATOR '<br>') as fechas_devolucion
        FROM herramienta_relacion as her
        INNER JOIN herramientas_empleado as he ON he.id_herramienta_asiganda = her.id_herramienta_asignada
        INNER JOIN herramientas as h ON her.id_herramienta = h.id_herramienta
        INNER JOIN empleados as empl ON empl.id_Empleado = her.id_empleado
        INNER JOIN puestos as p ON empl.id_Puesto = p.id_Puesto
        WHERE h.id_departamento = '$departamento'
        GROUP BY empl.id_Empleado";
            $resultado = mysqli_query($conexionDB, $sql);
                        
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Equipo Asignado</title>
    <link rel="stylesheet" href="../../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../../Styles/EstilosGlobales.css">
    <link rel="shortcut icon" href="../../img/ortusLogo.png">
</head>
<body>
        <div class="navbar">
                <img src="../../img/ortus_c.png" alt="" class="logo_imagen">
                <ul>
                        
                        <li><a href="almacenSistemas.php">Almacen de herramietas</a></li>

                        <li><a href="herramientaAsignada.php">Equipo prestado</a></li>

                        <li class="dropdown">
                            <a>Asignacion de equipo</a>
                            <div class="dropdown_Conetenido">
                                <a href="asignarUsuarios.php">Empleados</a>
                            </div>
                        </li>
                        <li class="Salir"><a class="Salir" href="../../../DB/CerrarSesion.php">Salir</a></li>
                </ul>
        </div>       
        <div class="contenedorTablaVacantes">
        <table id="tablaVacantes">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Empleado</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Herramientas</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Fecha de asignación</th>
                    <th scope="col">Fecha de devolución</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($filas = mysqli_fetch_assoc($resultado)){
                        // if($filas["Status"] == 0){
                        //     continue;
                        // }
                        
                ?>
                <tr>
                    <td><?php echo $filas["id_Empleado"]; ?></td>
                    <td><?php echo $filas["Nombre"]." ".$filas["Apellido_paterno"]." ".$filas["Apellido_materno"] ?></td>
                    <td><?php echo $filas["Puesto"] ?></td>
                    <td class="equipo"><?php echo $filas["herramientas"]; ?></td>
                    <td class="equipo"><?php echo $filas["tipos"]; ?></td>
                    <td class="equipo"><?php echo $filas["fechas_asignacion"]; ?></td>
                    <td class="equipo">
                    <?php 
                        if (!empty($filas["fechas_devolucion"])) {
                            echo $filas["fechas_devolucion"];}
                        ?>
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
         header('Location: ../../../index.php');
     }