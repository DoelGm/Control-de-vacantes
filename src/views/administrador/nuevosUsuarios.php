<?php
    require '../../../DB/conexionbd.php';
    
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID =  $_SESSION['IDAdmin'];

    if(isset($_SESSION['IDAdmin'])){

    $empresa = $_SESSION['Empresa'];

            
        $id_empleado = $_POST["ID"];
        $id_empleadoR = $_SESSION['Empleado'];

    $sql = "SELECT Nombre, Apellido_paterno, Apellido_materno  FROM empleados WHERE id_Empleado = '$id_empleado' or id_Empleado = '$id_empleadoR'";
    $resultado = mysqli_query($conexionDB, $sql);
    $consulta = mysqli_fetch_assoc($resultado);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../img/ortusLogo.png">
        <title>Nuevos Usuarios</title>
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


        <h2 class="Encabezado">Nuevos Usuarios</h2>
        <div class="conteiner1">
        <form action="../../Controllers/controladorNuevosUsuarios" method="POST">
        <div class="nuevoUsuarioformulario">
            <div class="col-1">
                
                <input name="idEmpleado" hidden type="text" value="<?= $id_empleado ?>">    

                <label style="padding-right: 430px" for="nombre">Nombre:</label>
                <input name="nombre"  readonly type="text" value="<?=$consulta["Nombre"]." ".$consulta["Apellido_paterno"]." ".$consulta["Apellido_materno"]?>" type="text" id="nombre" required >
                    
                <label style="padding-right: 344px;" for="Usuario">Nombre de Usuario:</label>
                <input style="background: rgb(255, 255, 255);" name="Usuario" type="text" id="Usuario">

            </div>
            <?php
                if(isset($_SESSION['mensajeERR'])){
                    echo $_SESSION['mensajeERR'];
                }
            ?>

            <div class="col-2">
        
                <label for="password">Contraseña:</label>
                <input style="background: rgb(255, 255, 255);" name="password" type="password" id="password" required>

                <label style="padding-right: 344px;" for="conpassword">Confirmar Contraseña:</label>
                <input style="background: rgb(255, 255, 255);" name="conpassword" type="password" id="conpassword" required >


                <input style="width: 80px; right: 750px; background-color: #1a2740; " class="BTNguardar" type="submit" value="Guardar">
            
            </div>
            
        
            </form>
            </div>
            </div>
            
    
    </body>
    </html>
    <?php

            }
            else{
                header('Location: ../../../index.php');
            }