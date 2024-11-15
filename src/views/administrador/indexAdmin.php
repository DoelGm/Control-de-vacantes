<?php
        session_start();

        $nombre = $_SESSION['Nombre'];

        $ID =  $_SESSION['IDAdmin'];

        if(isset($_SESSION['IDAdmin'])){

        $empresa = $_SESSION['Empresa'];

    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../img/ortusLogo.png">
        <title>Index</title>
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
            <br>
            
            <?php
                echo 'Bienvenid@ ' . $nombre;
            ?>
            <div class="Encabezado">
                <h1>Bienvenido Administrador</h1>
            </div>
    </body>
    </html>
    <?php

        }else{
            header('Location: ../../../index.php');
        }