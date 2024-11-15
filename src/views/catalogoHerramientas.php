<?php
require '../../DB/conexionbd.php';
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID =  $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){

        $sql = "SELECT p.Puesto, v.id_vacante FROM departamentos as dep, puestos as p, vacantes as v WHERE v.id_Puestos = p.id_Puesto AND p.id_Departamento = dep.id_Departamento "; // consulta a la tabla de puesto de la base de datos
        $resultado = mysqli_query($conexionDB, $sql);
?>
    
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../img/ortusLogo.png">
        <title>Catalogo de Nuevas Herramientas</title>
        <link rel="stylesheet" href="../../Styles/estilo2.css">
        <link rel="stylesheet" href="../../Styles/EstilosGlobales.css">
    </head>
    <body>
    <div class="navbar">
            <img src="../img/ortus_c.png" alt="" class="logo_imagen">
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
                    
                    <li><a href="SolicitarVacante.php">Solicitar Vacantes</a></li> 

                    <li><a href="../../DB/CerrarSesion.php">Salir</a></li>
            </ul>
                </div>


    <div class="Encabezado">
            <h1>Herramientas para la vacante</h1>
        </div>

        <div class="conteiner1">
            <div class="formularioNuevaHerramienta">
                <form action="../Controllers/controladorNuevoTipoHerramienta.php" method="POST" >
                
                    <div class="col-1">

                        <label for="NombreH">Nombre: </label>
                        <input type="text" id="NombreH" name="NombreH" placeholder="Ingrese el Nombre de la Herramienta:" required >

                        <label for="NSerie">Numero de serie:</label>
                        <input style="background: rgb(255, 255, 255);" placeholder="Ingrese el numero de serie de la herramienta: " type="text" name="NSerie" id="NSerie" required>


                        <label style="padding-right: 433px" for="vacantes">Vacante:</label> 
                        <select style="background: rgb(255, 255, 255);" name="vacantes"  id="vacantes" required>
                        <option></option>
                        <?php
                        //validamos nuestras vacantes 
                            while($consulta = mysqli_fetch_assoc($resultado)){
                        ?>
                        <!-- Mostramos el puesto que esta vinculada a una vacante y obtenemos su id del puesto -->
                            <option id="vacantes" value="<?=$consulta["id_vacante"]?>"><?php echo $consulta["Puesto"]?></option>
                        <?php
                            }
                        ?>
                        </select>

                       
                        
                    </div>

                    <div class="col-2">
                        
                        <label for="cantidad">Cantidad: </label>
                        <input style="background: rgb(255, 255, 255);" placeholder="Ingrese la cantidad de herramientas:" id="cantidad" name="cantidad" type="number" min="1"  required step>

                        <label for="descripcion">Descripcion:</label>
                        <textarea style="background: rgb(255, 255, 255);" placeholder="Ingrese una descripcion:" name="descripcion" id="descripcion" cols="72" rows="7.5"  required></textarea>

                        <label for="TipoHerramienta">Tipo: </label>
                        <input style="background: rgb(255, 255, 255);" type="text" name="TipoHerramienta" id="TipoHerramienta"  required>
                        
                    </div> 
            

                </div>
                <input class="BTN_Solicitar" type="submit" value="Nueva Herramienta">     
            </form>
            </div>
            
    </body>
    </html>
    <?php

        }
        else{
            header('Location: ../../index.php');
        }

    ?>