
<?php
    require '../../../DB/conexionbd.php';
    
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    $departamento = $_SESSION['Departamento'];

    // echo $departamento;
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
    <link rel="shortcut icon" href="../../img/ortusLogo.png">
    <title>Asiganacion de herramientas</title>
    <link rel="stylesheet" href="../../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../../Styles/EstilosGlobales.css">
</head>
<body>
        <div class="navbar">
            <img src="../../img/ortus_c.png" alt="" class="logo_imagen">
            <ul>
                    
                    <li><a href="almacenTaller.php">Almacen de herramietas</a></li>

                    <li><a href="herramientaAsignada.php">Herramienta prestada</a></li>

                    <li class="dropdown">
                        <a>Asignacion de harramienta</a>
                        <div class="dropdown_Conetenido">
                            <a href="empleados.php">Empleados</a>
                        </div>
                    </li>
                    <li class="Salir"><a class="Salir" href="../../../DB/CerrarSesion.php">Salir</a></li>
            </ul>
        </div> 

    <div class="Encabezado">
        <h1>Asignacion de Herramientas</h1>
    </div>

    <div class="contenedor1">
        <div class="formularioAsiganacionHerramienta">
            <form action="../../Controllers/controladorAsignarHerramienta.php" method="POST">
                <label for="">Nombre del empleado: </label>
                <input type="text" id="" name="" value="<?= $consulta["Nombre"]." ".$consulta["Apellido_paterno"]." ".$consulta["Apellido_materno"]?>" readonly>

                <input type="text" hidden name="ID" value="<?= $id_empleado ?>" required >

                <label for="herramienta">Herramienta:</label>
                <select name="herramienta" id="herramienta">
                    <option></option>

                    <?php
                    $sql2 = "SELECT h.* FROM herramientas AS h WHERE '$departamento' = h.id_departamento";
                    $resulatdo2 = mysqli_query($conexionDB, $sql2);
                    $sql3 = "SELECT hr.id_herramienta FROM herramienta_relacion AS hr, herramientas AS h WHERE h.id_herramienta = hr.id_herramienta AND '$departamento' = h.id_departamento";
                    $resulatdo3 = mysqli_query($conexionDB, $sql3);
                    $arreglo1 = array();
                    while ($consulta3 = mysqli_fetch_assoc($resulatdo3)) {
                        $arreglo1[] = $consulta3["id_herramienta"];
                    }
                    while ($consulta2 = mysqli_fetch_assoc($resulatdo2)) {
                
                        if (in_array($consulta2["id_herramienta"], $arreglo1)) {
                            continue;
                        }
                        ?>
                        <option value="<?= $consulta2["id_herramienta"] ?>">
                            <?php echo "Herramienta:" . $consulta2["nombre_herramienta"] . ", Numero de serie:" . $consulta2["no_serie"] . ",  Tipo:" . $consulta2["tipo"] ?>
                        </option>
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

