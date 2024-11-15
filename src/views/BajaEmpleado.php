<?php

    session_start();

    require '../../DB/conexionbd.php';
    $ID = $_POST['ID'];
    $sql = "SELECT * FROM empleados WHERE id_Empleado = '$ID'";
    $resulatdo = mysqli_query($conexionDB, $sql);
    $consulta = mysqli_fetch_assoc($resulatdo);

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/ortusLogo.png">
    <title>Baja empleado</title>
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
        <h1>Baja empleado</h1>
    </div>

    <div class="contenedor1">
        <div class="formularioBaja">
            <form action="../Controllers/controladorBajaEmpleado.php" method="POST">
                <div class="datosDeBaja">

                    <input type="number" name="idEmpleado" hidden value="<?=$consulta["id_Empleado"]?>">

                    <label for="nombre">Nombre: </label>
                    <input id="nombre" name="nombre" value="<?=$consulta["Nombre"].' '.$consulta["Apellido_paterno"].' '.$consulta["Apellido_materno"]?>"type="text"  readonly>

                    <label for="FechaDeContratacion">Fecha de contratación</label>
                    <input type="date" value="<?=$consulta["Fecha_contratacion"]?>" name="FechaDeContratacion" readonly id="FechaDeContratacion">

                    <label for="FechaDeBaja">Fecha de baja</label>
                    <input type="date" name="FechaDeBaja" id="FechaDeBaja">

                    <label for="Causa">Causa </label>
                    <textarea name="Causa" id="Causa" cols="67" rows="5"></textarea>

                    <label for="Comentario">Comentarios</label>
                    <textarea name="comentario" id="Comentario" cols="67" rows="10"></textarea>
                </div>
                <div class="radioInputsE">
                    <label for="reingreso">Reingreso:</label>
                    <br>
                    <label for="reingreso"><input type="radio" name="reingreso" value="1"> Permitido</label>
                    <label for="reingreso"><input type="radio" name="reingreso" value="0"> No permitido</label>
                    <br>
                </div>
                    <br>
                <input name="" class="BTN_ContinuarBaja" type="submit" value="Continuar">
                <button class="BTN_cancelarBaja">Cancelar</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php
}
else{
    header('Location: ../../index.php');
}