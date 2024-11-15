<?php
    require '../../../DB/conexionbd.php';
    
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID =  $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){

    $empresa = $_SESSION['Empresa'];

    
    if(isset($_POST["ID"])){
        $_SESSION['Empleado'] = $_POST["ID"];
        $id_empleado = $_SESSION['Empleado'];
        $sql = "SELECT Nombre, Apellido_paterno, Apellido_materno  FROM empleados WHERE id_Empleado = '$id_empleado'";
        $resultado = mysqli_query($conexionDB, $sql);
        }else if(isset($_SESSION['Empleado'])){
            $id_empleado = $_SESSION['Empleado'];
            $sql = "SELECT Nombre, Apellido_paterno, Apellido_materno  FROM empleados WHERE id_Empleado = '$id_empleado'";
            $resultado = mysqli_query($conexionDB, $sql);
        }

    
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
        <?php
        if(isset($_SESSION['mensajeERR'])){
            if($_SESSION['mensajeERR'] == "Las credenciales no coinciden"){
        ?>
        <div class="mensaje">
                <p>
                <?php echo $_SESSION['mensajeERR'];?>
                </p>
            
            </div>
        <?php
         } 
        }
        ?>
        <h2 class="Encabezado">Nuevos Usuarios</h2>
        <div class="conteiner1">
        <form action="../../Controllers/controladorNuevosUsuarios.php" method="POST">
        <div class="nuevoUsuarioformulario">
            <div class="col-1">
                
                <input name="idEmpleado" hidden type="text" value="<?= $id_empleado ?>">    

                <label style="padding-right: 430px" for="nombre">Nombre:</label>
                <input name="nombre"  readonly type="text" value="<?=$consulta["Nombre"]." ".$consulta["Apellido_paterno"]." ".$consulta["Apellido_materno"]?>" type="text" id="nombre" required >
                    
                <label style="padding-right: 344px;" for="Usuario">Nombre de Usuario:</label>
                <input style="background: rgb(255, 255, 255);" name="Usuario" type="text" id="Usuario">

            </div>
            

           
           

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