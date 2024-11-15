<?php
    require '../../DB/conexionbd.php';
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){
    
        $empresa = $_SESSION['Empresa'];

        $fechaActual = date('Y-m-d H:i:');
    

        $sql = "SELECT v.*, p.Puesto, dep.Departamento, p.no_vacante 
        FROM vacantes AS v, puestos AS p, departamentos as dep, empleados as empl,
        empresas as em WHERE v.id_Puestos = p.id_Puesto AND p.id_Departamento = dep.id_Departamento 
        AND dep.id_empresa AND em.id_Empresa AND v.Status = 1 AND v.id_empleado_autoriza = empl.id_Empleado
        AND em.id_Empresa = '$empresa' ORDER BY DATEDIFF(v.Fecha_cubrir, '$fechaActual')ASC";
        $resultado1 = mysqli_query($conexionDB, $sql);
        $resultado = mysqli_query($conexionDB, $sql);

        $listado = array();
         while($consulta = mysqli_fetch_assoc($resultado1)){
            $listado = $resultado1;
             $fechaVence = $consulta["Fecha_cubrir"];    
             $idVacanteVencio = $consulta["id_vacante"];    
             if($fechaActual > $fechaVence){
                 $sql2 = "UPDATE vacantes SET Status = 0 WHERE '$fechaActual' > '$fechaVence' AND '$idVacanteVencio' = id_vacante ";
                 $update = mysqli_query($conexionDB, $sql2);
             }
         }
        
        
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Index</title>
    <link rel="stylesheet" href="../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../Styles/EstilosGlobales.css">
    <link rel="shortcut icon" href="../img/ortusLogo.png">
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
        <div class="contenedorTablaVacantes">
        <table id="tablaVacantes">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Puesto</th>
                <th scope="col">Departamento</th>
                <!-- <th scope="col">Fecha de solicitud</th> -->
                <th scope="col">Vence</th>
                <th  scope="col">Comentarios</th>
                <th scope="col">Vacantes</th>
                <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
                while($filas = mysqli_fetch_assoc($resultado)){
                  
                ?>
                <tr>
                <th scope="row"><?php echo $filas["id_vacante"]; ?></th>
                <th><?php echo $filas["Puesto"]; ?></th>
                <th><?php echo $filas["Departamento"];?></th>
                <!-- <th></th> -->
                <!-- echo $filas["Fecha_Solicitud"]; -->
                <th><?php echo $filas["Fecha_cubrir"]; ?></th>
                <td id="tdComentarios"><?php echo $filas["Comentarios"];?></td>
                <th><?php echo $filas["no_vacante"];?></th>
                <th><?php if($filas["Status"] == 1){
                           echo "Activa"; 
                        }else{
                            echo "Inactiva";
                        }  
                    ?>
                </th>
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