<?php
    session_start();

    $ID =  $_SESSION['IDAdmin'];

    if(isset($_SESSION['IDAdmin'])){

        $empresa = $_SESSION['Empresa'];

        require '../../../DB/conexionbd.php';
        $sql = "SELECT v.*, p.Puesto, empl.Nombre, empl.Apellido_paterno, empl.Apellido_materno 
        FROM vacantes AS v, puestos AS p, empleados AS empl, departamentos as dep, empresas as em  
        WHERE v.id_Puestos = p.id_Puesto AND 
        v.id_empleado_solicitud = empl.id_Empleado AND p.id_Departamento = dep.id_Departamento 
        AND dep.id_empresa AND em.id_Empresa AND em.id_Empresa = '$empresa'";
        $resultado = mysqli_query($conexionDB, $sql);


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
        <title>Vacantes</title>
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
        <div class="Encabezado">
            <h1 style="margin-top: 40px; margin-left: 26.5px; margin-bottom: 20px;" >Control de vacantes</h1>
        </div>

        <div class="contenedorTablaVacantes">
        <table id="tablaVacantes">
            <thead>
                <tr>
                <th scope="col">No.</th>
                <th scope="col">Solicita</th>
                <th scope="col">Vacante</th>
                <th scope="col">Fecha de solicitud</th>
                <th scope="col">Fecha a cubrir</th>
                <th  scope="col">Comentarios</th>
                <th  scope="col">Herramientas</th>
                <th scope="col">No. vacantes Solicitadas</th>
                <th scope="col">Tipo de vacante</th>
                <th scope="col">Status</th>
                <th scope="col">Aprobacion</th>
                </tr>
            </thead>
            <tbody>
            <?php
                while($filas = mysqli_fetch_assoc($resultado)){
                    if($filas["Fecha_cubrir"]==null){
                        continue;
                    }
                     if(($filas["Status"] == 1 && !empty($filas["Vacante_autorizada"])) || ($filas["Status"] == 0)){
                         
                   
                ?>
                <tr>
                <th scope="row"><?php echo $filas["id_vacante"]; ?></th>
                <th scope="row"><?php echo $filas["Nombre"]." ".$filas["Apellido_paterno"]." ".$filas["Apellido_materno"]?></th>
                <th><?php echo $filas["Puesto"]; ?></th>
                <th><?php echo $filas["Fecha_Solicitud"]; ?></th>
                <th><?php echo $filas["Fecha_cubrir"]; ?></th>
                <td id="tdComentarios"><?php echo $filas["Comentarios"];?></td>
                <td id="tdComentarios"><?php echo $filas["Herramientas"];?></td>
                <th><?php echo $filas["noVacantes_Aceptar"];?></th>
                <th><?php if(isset($filas["Vacante_autorizada"])){
                            echo "Solicita actualizar la vacante";
                          }else{
                            echo "Solicita una nueva vacante";
                          }   
                    ?>      
                </th>
                <th><?php 
                        if($filas["Status"] == 0){
                            echo "Por autorizar";
                        }
                    ?>
                </th>
                <th> 
                    <li class="dropdown1">
                        <a id="acciones">Acciones<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="2 0 8 16">
                        <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z"/>
                        </svg></a>
                            <div class="dropdown_opcionesVacantes">
                                <form action="../../Controllers/ControladorAceptarVacante.php" method="post"> <button type="submit" id="btn" value="<?= $filas["id_vacante"] ?>" name="IdVacante">Aceptar</button></form>
                                <form action="../../Controllers/ControladorDenegarVacante.php" method="post"> <button type="submit" id="btn" value="<?= $filas["id_vacante"] ?>" name="IdVacante">Denegar</button></form>
                            </div>
                    </li>
            </th>
                </tr>
            <?php 
              }
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
            header('Location: login.php');
        }

    ?>