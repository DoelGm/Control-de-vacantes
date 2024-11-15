
<?php
    require '../../DB/conexionbd.php';
    
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){
    
    $id_empleado = $_POST["ID"];

    $sql = "SELECT Nombre, Apellido_paterno, Apellido_materno FROM empleados WHERE id_Empleado = '$id_empleado'";
    $resulatdo = mysqli_query($conexionDB, $sql);
    $consulta = mysqli_fetch_assoc($resulatdo);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/ortusLogo.png">
    <title>Asiganacion de herramientas</title>
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

            <li><a href="SolicitarVacante.php">Vacantes</a></li> 

            <li><a href="../../DB/CerrarSesion.php">Salir</a></li>
        </ul>
    </div>

    <div class="Encabezado">
        <h1>Asignacion de Herramientas</h1>
    </div>

    <div class="contenedor1">
        <div class="formularioAsiganacionHerramienta">
            <form action="../Controllers/controladorAsignarHerramienta.php" method="POST">
                <label for="">Nombre del empleado: </label>
                <input type="text" id="" name="" value="<?= $consulta["Nombre"]." ".$consulta["Apellido_paterno"]." ".$consulta["Apellido_materno"]?>" readonly>

                <input type="text" hidden name="ID" value="<?= $id_empleado ?>" required >

                <label for="herramienta">Herramienta:</label>
                <select name="herramienta" id="herramienta">
                    <option ></option>

                    <?php
                    $sql2 = "SELECT th.id_tipo_herramienta, th.Cantidad, th.Nombre, th.No_Serie, th.Tipo FROM tipo_herramienta  as th, vacantes as v WHERE v.id_vacante = th.id_vacante ";
                    $resulatdo2 = mysqli_query($conexionDB, $sql2);
                    while($consulta2 = mysqli_fetch_assoc($resulatdo2)){  
                        if($consulta2["Cantidad"] == 0){
                            continue;
                        }
                    ?>
                        <option value="<?= $consulta2["id_tipo_herramienta"]?>"><?php echo "Herramienta:".$consulta2["Nombre"].", Numero de serie:".$consulta2["No_Serie"].",  Tipo:".$consulta2["Tipo"] ?></option>

                    <?php
                        }
                    ?>
                </select>
                <!-- <input style="background: rgb(255, 255, 255);" placeholder="Ingrese el numero de serie de la herramienta: " type="text" name="NSerie" id="NSerie" required> -->

                <label for="fechaasiganacion">Fecha de asiganacion: </label>
                <input style="background: rgb(255, 255, 255);" type="date" name="fechaasiganacion" id="fechaasiganacion"  required>
            
        </div>
                <input class="BTN_asiganar" type="submit" value="Asignar Herramienta">
            </form>
    </div>
</body>
</html>

<?php

     }

 ?>

