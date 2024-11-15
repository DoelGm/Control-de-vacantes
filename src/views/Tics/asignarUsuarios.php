<?php
        session_start();

        $nombre = $_SESSION['Nombre'];

        $ID = $_SESSION['Identificador'];

        if(isset($_SESSION['Identificador'])){

        $empresa = $_SESSION['Empresa'];
        $departamento = $_SESSION['Departamento'];
        
        unset($_SESSION['mensajeERR']);
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../../Styles/estilo2.css">
        <link rel="stylesheet" href="../../../Styles/EstilosGlobales.css">

        <link rel="shortcut icon" href="../../img/ortusLogo.png">
        <title>Empleados</title>
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

            <div class="Encabezado">
                <h1>Empleados</h1>
            </div>
        <div class="buscar">
            <form action="" method="GET">
            <input name="buscar" id="Buscar" type="search" placeholder="buscar" >
            </form>
            
        </div>
    
        <?php
            require '../../../DB/conexionbd.php';

            if (isset($_GET['buscar'])) {
                $buscar = $_GET['buscar'];
                
                // Dividir los términos de búsqueda en un array
                $terminos = explode(" ", $buscar);
                
                // Crear un array para almacenar las condiciones de búsqueda
                $condiciones = array();
                
                // Construir las condiciones de búsqueda
                foreach ($terminos as $termino) {
                    $condiciones[] = "(empl.id_Empleado LIKE '%$termino%' OR empl.Nombre LIKE '%$termino%' OR empl.Apellido_paterno LIKE '%$termino%' OR empl.Apellido_materno LIKE '%$termino%')";
                }
                
                // Unir las condiciones con el operador lógico AND
                $condiciones_str = implode(" AND ", $condiciones);
                
                // Construir la consulta SQL con las condiciones de búsqueda
                $sql = "SELECT a.No_celular, v.id_vacante, p.Puesto, 
                empl.*, dep.Departamento FROM vacantes as v, puestos as p, aspirantes as a, 
                departamentos as dep, empleados as empl, empresas as em
                WHERE a.id_Aspirante = empl.id_Aspirante AND empl.id_Departamento = dep.id_Departamento 
                AND v.id_vacante = a.id_Vacante AND p.id_Puesto = v.id_Puestos AND empl.Status = 1 AND  dep.id_empresa = em.id_Empresa AND '$empresa' = em.id_Empresa AND dep.Departamento NOT LIKE 'Taller'
                AND ($condiciones_str)";
            } else {
                $sql = "SELECT v.id_vacante, p.Puesto, empl.*, dep.Departamento 
                FROM vacantes as v, puestos as p, aspirantes as a, 
                departamentos as dep, empleados as empl, empresas as em
                WHERE a.id_Aspirante = empl.id_Aspirante AND empl.id_Departamento = dep.id_Departamento 
                AND v.id_vacante = empl.id_Vacante AND p.id_Puesto = v.id_Puestos 
                AND empl.Status = 1 AND dep.id_empresa = em.id_Empresa 
                AND '$empresa' = em.id_Empresa 
                AND dep.Departamento NOT LIKE 'Taller'";

// Ejecutar la consulta $sql aquí...

            }

            $resultado = mysqli_query($conexionDB, $sql);
        ?>


    <table>
        <thead>
            <tr>
                <!-- tabla de empleados Titulos  -->
                <th>No.</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Departamento</th>
                <th>Puesto</th>
                <th>Status</th>
                <th>Acciones</th>
            </tr>
        </thead>
        
        <tbody>
        <?php 
        while ($consulta = mysqli_fetch_assoc($resultado)) {
        ?>
            <!-- tabla de empleados informacion  -->
            <tr>
                <td><?php echo $consulta["id_Empleado"]; ?></td>
                <td><?php echo $consulta['Nombre']; ?></td>
                <td><?php echo $consulta["Apellido_paterno"]; ?></td>
                <td><?php echo $consulta["Apellido_materno"]; ?></td>
                <td><?php echo $consulta["Departamento"]; ?></td>
                <td><?php echo $consulta["Puesto"]; ?></td>
                <td><?php echo ($consulta["Status"] == 1) ? "Activo" : "Inactivo"; ?></td>
                <td>
                <li class="dropdown1">
                         <a id="acciones">Acciones<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="2 0 8 16">
                         <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z"/>
                         </svg></a>
                            <div class="dropdown_opcionesAsignarUsuario">
                                <form action="nuevosUsuarios.php" method="post">
                                    <button type="submit" id="btn" value="<?=$consulta["id_Empleado"]?>" name="ID">Nuevo Usuario</button>
                                </form>
                                <form action="asignarHerramientas.php" method="post">
                                    <button type="submit" id="btn" value="<?=$consulta["id_Empleado"]?>" name="ID">Asiganar Herramienta</button>
                                </form>
                            </div>
                    </li>
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

        }
        else{
            header('Location: ../../../index.php');
        }