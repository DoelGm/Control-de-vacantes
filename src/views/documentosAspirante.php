<?php
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../Styles/EstilosGlobales.css">
    <link rel="shortcut icon" href="../img/ortusLogo.png">
    <title>Documentos</title>
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
    <h2 class="Encabezado" >Documentos de Aspirante</h2>
    <br>
    <br>
    <div class="informacion">
        <label for="nombre">Nombre</label>
        <input type="text" value="Nombre del Empleados"  readonly id="nombre">
        <label for="vacante">Vacante</label>
        <input type="text" value="vacante"  readonly id="vacante">
    </div>
    
    <div class="documentos"></div>
    
</body>
</html>
<?php

    }
    else{
        header('Location: ../../index.php');
    }