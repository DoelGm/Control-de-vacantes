<?php
        session_start();

        $nombre = $_SESSION['Nombre'];

        $ID =  $_SESSION['IDAdmin'];

        if(isset($_SESSION['IDAdmin'])){

        $empresa = $_SESSION['Empresa'];

            
            require '../../../DB/conexionbd.php';
            $sql = "SELECT v.id_vacante, p.Puesto, p.id_Departamento, em.Empresa, dep.Departamento FROM departamentos as dep, puestos as p, vacantes as v, empresas as em WHERE v.id_Puestos = p.id_Puesto AND p.id_Departamento = dep.id_Departamento AND dep.id_empresa = em.id_Empresa AND '$empresa' = em.id_Empresa"; // consulta a la tabla de puesto de la base de datos
            $resultado = mysqli_query($conexionDB, $sql);
        
        
        
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../img/ortusLogo.png">
        <title>Catalogo de nuevos documentos</title>
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
                    <h1>Nuevos documentos</h1>
                </div>

                <div class="contenedor1">
                    <div class="formularioSubirDocs">
                        <form action="../../Controllers/controladorNuevoDocumento.php" method="POST">
                            <div class="SubirArchi">
                                <label for="vacante">Vacante</label>
                                <select name="vacante" id="vacante">
                                    <option></option>
                                    <?php
                                    while($consulta = mysqli_fetch_assoc($resultado)){
                                    ?>
                                    <option value="<?= $consulta["id_vacante"]?>"><?php echo "Empresa: ".$consulta["Empresa"].", Departamento: ".$consulta["Departamento"].", Vacante: ".$consulta["Puesto"]?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <br>
                                <div class="radioInputsAr">
                                    <label>Necesario:</label>
                                    <label for="forzoso"><input type="radio" name="forzoso" value="1"> Si</label>
                                    <label for="forzoso"><input type="radio" name="forzoso" value="0"> No</label>
                                    <br>

                                    <label  for="documento">Nuevo Documento</label>
                                    <input class="SubirArchiText" name="documento" type="text" id="documento" required> 
                                </div>  
                            </div>
                            <br>
                            <input class="BTN_Enviar" type="submit" value="Guardar">
                        </form>
                    </div>
                </div>

    </body>
    </html>
    <?php
   }else{
       header('Location: ../../../index.php');
   }
    ?>