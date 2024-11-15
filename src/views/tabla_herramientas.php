<?php
 require '../../DB/conexionbd.php';
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){

        $sql = "SELECT he.*, empl.Nombre, empl.Apellido_paterno, empl.Apellido_materno, p.Puesto, the.Nombre as herramienta, the.id_tipo_herramienta FROM herramientas as he, tipo_herramienta as the,  empleados as empl, puestos as p WHERE  he.id_empleado = empl.id_Empleado AND empl.id_Puesto = p.id_Puesto ORDER BY fecha_devolucion IS NULL DESC";
        $resultado = mysqli_query($conexionDB, $sql);
        
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../Styles/EstilosGlobales.css">
    <title></title>
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

                    <li><a href="SolicitarVacante.php">Vacantes</a></li> 

                    <li><a href="../../DB/CerrarSesion.php">Salir</a></li>
            </ul>
</div> 



<table>
    <thead>
        <tr>
            <!-- Titulos  -->
            <th>ID</th>
            <th>Solicito</th>
            <th>Puesto</th>
            <th>Herramienta</th>
            <th>Fecha de solicitud</th>
            <th>Fecha de devulucion</th>
            <th>Acciones</th>
        </tr>
    </thead>
    
    <tbody>
    <?php 
    while ($consulta = mysqli_fetch_assoc($resultado)) {
    ?>
        <!-- Informacion -->
        <tr>
            <td><?php echo $consulta["id_herramienta"]?></td>
            <td><?php echo $consulta["Nombre"]." ".$consulta["Apellido_paterno"]." ".$consulta["Apellido_materno"]?></td>
            <td><?php echo $consulta["Puesto"] ?></td>
            <td><?php echo $consulta["herramienta"] ?></td>
            <td><?php echo $consulta["fecha_asignacion"] ?></td>
            <td><?php if(isset($consulta["fecha_devolucion"])){
                        echo $consulta["fecha_devolucion"];
                      }else{
                        echo "No devuelto";
                      } 
            ?>
            </td>
            <td>
            <?php
                if(empty($consulta["fecha_devolucion"])){
            ?>
            <li class="dropdown1">
                <a id="acciones">Acciones<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="2 0 8 16">
                <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z"/>
                </svg></a>
                    <div class="dropdown_opcionestablaHerramientas">
                        <form action="../Controllers/controladorDevulucionHerramienta.php" method="post">
                            <input type="number" value="<?= $consulta["id_tipo_herramienta"]?>" name="idTipoHerramienta" hidden></input>
                            <button type="submit" id="btn" value="<?=$consulta["id_herramienta"]?>" name="ID">devulucion</button>
                        </form> 
                    </div>
            </li>
            </td>

            <?php
              }else{
                echo "Articulo devuelto";
              }
            ?>
            </td>
        </tr>
    <?php 
    }
    ?>
    </tbody>
</table>
</body>
</html>
<?php
    }else{
        header('Location: ../../index.php');
    }

?>