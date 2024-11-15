<?php
require '../../../DB/conexionbd.php';
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID =  $_SESSION['IDAdmin'];
    $empresa = $_SESSION['Empresa'];
    
    if(isset($_SESSION['IDAdmin'])){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST["opciones"])){
                $opcionSeleccionada = $_POST["opciones"];
            } 
        } 

        if(isset($_POST["enviar"])){
            $vacantes = $_POST["vacantes"];
            $sql = "SELECT v.id_Puestos, p.id_Departamento FROM vacantes as v, puestos as p WHERE v.id_Puestos = p.id_Puesto AND v.id_vacante = '$vacantes'";
            $resultadov = mysqli_query($conexionDB, $sql);
            $consultav = mysqli_fetch_assoc($resultadov); 
            $departamento = $consultav["id_Departamento"];

            $NombreH = $_POST["NombreH"];
            $NSerie = $_POST["NSerie"];
            $descripcion = $_POST["descripcion"];
            $TipoHerramienta = $_POST["TipoHerramienta"];
            

            $sqlH = "INSERT INTO herramientas (`id_herramienta`,`id_empresa`, `id_departamento`, `nombre_herramienta`, `no_serie`, `tipo`, `descripcion`, `estado`, `id_vacante`, `Status`) VALUES (12, '$opcionSeleccionada','$departamento','$NombreH','$NSerie','$TipoHerramienta','$descripcion','Funcional','$vacantes', 1)";
            $insert = mysqli_query($conexionDB, $sqlH);

    }    
?>
    
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../img/ortusLogo.png">
        <title>Catalogo de Nuevas Herramientas</title>
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


    <div class="Encabezado">
            <h1>Nuevas Herramientas</h1>
        </div>

        <div class="conteiner1">
            <div class="formularioNuevaHerramienta">
                <form action="" method="POST" >
                
                    <div class="col-1">

                    <!-- input de empresa -->
                    <?php
                            $sql2 = "SELECT DISTINCT em.Empresa, dep.id_empresa FROM empresas as em, departamentos as dep WHERE dep.id_empresa = em.id_Empresa";
                            $resultado2 = mysqli_query($conexionDB, $sql2);
                        ?>
                        <label for="Empresa">Empresa: </label>
                        <select style="background: rgb(255, 255, 255);" name="opciones" onchange="submitForm2()" id="Empresa" required>
                        <option></option>
                        <?php 
                        while($consulta = mysqli_fetch_assoc($resultado2)){
                            echo '<option' . (($opcionSeleccionada == $consulta['id_empresa']) ? ' selected' : '') . ' value="'.$consulta['id_empresa'].'">'. $consulta['Empresa'].'</option>';
                        }
                        ?>
                        
                        </select>

                        <noscript><input type="submit" value="Enviar"></noscript>
                        <script>
                            function submitForm2() {
                                // Envía el formulario automáticamente cuando se selecciona una opción
                                document.querySelector('form').submit();
                            }
                        </script>

                        <!-- input de vacantes -->

                    <?php
                        if(isset($opcionSeleccionada)){
                            $sql4 = "SELECT v.id_vacante, p.Puesto, p.no_vacante, dep.Departamento FROM vacantes as v, departamentos as dep, puestos as p, empresas as em WHERE v.id_Puestos = p.id_Puesto AND v.Status = 1 AND  dep.id_Departamento = p.id_Departamento AND dep.id_empresa = em.id_Empresa AND em.id_Empresa = '$opcionSeleccionada'"; // consulta a la tabla de puesto de la base de datos
                            $resultado4 = mysqli_query($conexionDB, $sql4);
                            // $consulta3 = mysqli_fetch_assoc($resultado3);
                        }
                    ?>
                    <label for="vacantes">Vacantes: </label>
                    <select style="background: rgb(255, 255, 255);" name="vacantes" id="vacantes" required>
                        <option></option>
                        <?php 
                        while($consulta4 = mysqli_fetch_assoc($resultado4)){
                            if($consulta4["no_vacante"] == 0){
                                continue;
                            }
                        ?>
                        <option value="<?=$consulta4['id_vacante']?>"><?php echo "Departamento: ".$consulta4['Departamento'].", Vacante: ".$consulta4['Puesto']?> </option>    
                        <?php
                        }
                        ?>                    
                    </select>

                    <label for="NombreH">Nombre: </label>
                        <input type="text" id="NombreH" name="NombreH" placeholder="Ingrese el Nombre de la Herramienta:" required >

                        
                        
                    </div>

                    <div class="col-2">

                        <label for="NSerie">Numero de serie:</label>
                        <input style="background: rgb(255, 255, 255);" placeholder="Ingrese el numero de serie de la herramienta: " type="text" name="NSerie" id="NSerie" required>

                        <label for="descripcion">Descripcion:</label>
                        <textarea style="background: rgb(255, 255, 255);" placeholder="Ingrese una descripcion:" name="descripcion" id="descripcion" cols="72" rows="7.5"  required></textarea>

                        <label for="TipoHerramienta">Tipo: </label>
                        <input style="background: rgb(255, 255, 255);" type="text" name="TipoHerramienta" id="TipoHerramienta"  required>
                        
                    </div> 
            

                </div>
                <input class="BTN_Solicitar" type="submit" name="enviar" value="Nueva Herramienta">     
            </form>
            </div>
            
    </body>
    </html>
    <?php

        }
        else{
            header('Location: ../../../index.php');
        }

    ?>