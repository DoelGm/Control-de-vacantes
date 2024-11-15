<?php
require '../../../DB/conexionbd.php';
    session_start();

    $id_aspirante = $_POST["ID_Aspirante"];

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['IDAdmin'];

    if(isset($_SESSION['IDAdmin'])){

       

        
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="shortcut icon" href="../../img/ortusLogo.png">
            <title>Cargar Documentos Aspirantes</title>
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
                <h1>Cargar documentos aspirantes</h1>
            </div>

            <div class="contenedor1">
                <div class="formularioSubirDocs">
                    <form action="../../Controllers/ControladorSubirArchivo.php" method="POST" enctype="multipart/form-data">
                        <div class="SubirArchi">

                        <?php

                            $query ="SELECT a.Nombre, a.Apellido_paterno, a.Apellido_materno, p.Puesto FROM aspirantes AS a, vacantes AS va, puestos AS p WHERE a.id_Aspirante = '$id_aspirante' AND a.id_vacante = va.id_vacante AND va.id_Puestos = p.id_Puesto";

                            $resultado = mysqli_query($conexionDB, $query);

                            $consulta = mysqli_fetch_assoc($resultado);
                        ?>

                            <input type="hidden" name="id_Aspirante" value="<?php echo $id_aspirante ?>">
                            <label class="" for="nombre">Nombre: </label>
                            <input class="SubirArchiText" id="nombre" name="nombre" type="text" disabled readonly value="<?php echo $consulta["Nombre"]." ".$consulta["Apellido_paterno"]." ".$consulta["Apellido_materno"] ?>">


                            <label for="Puesto">Puesto: </label>
                            <input class="SubirArchiText" id="Puesto" name="Puesto" disabled type="text" readonly value="<?php echo $consulta["Puesto"] ?> ">

                            <?php
                                    $query2 = "SELECT doc.* FROM documentos AS doc, vacantes AS va, aspirantes AS a WHERE doc.id_vacante = va.id_vacante AND a.id_Vacante = va.id_vacante AND a.id_Aspirante = '$id_aspirante'";

                                    $resultado2 = mysqli_query($conexionDB, $query2);


                                    $SQLvalidacion = "SELECT da.Archivo, da.id_documento, da.id_documento_aspirante FROM aspirantes AS a, vacantes AS va, documentos AS doc, documentos_aspirantes AS da WHERE a.id_Aspirante = '$id_aspirante' AND a.id_Vacante = va.id_vacante AND doc.id_vacante = va.id_vacante AND da.id_documento = doc.id_documento AND da.id_Aspirante = '$id_aspirante'";
                                    
                                    $ValidacionResultado = mysqli_query($conexionDB, $SQLvalidacion);
    
                                ?>
                            <label for="TipoDocumento">Tipo de documentos:</label>
                            <select name="TipoDocumento" id="SubirArchiText" required>
                                <option value=""></option>
                                <?php
                                    while($consulta2 = mysqli_fetch_assoc($resultado2)){

                                        $fila = mysqli_fetch_assoc($ValidacionResultado);
                                        
                                        if(!isset($fila['Archivo'])){
                                            ?>
                                            <option value="<?= $consulta2['id_documento'] ?>">
                                                <?= $consulta2['Nombre_Documento'] ?>
                                            </option>

                                            <?php
                                        }
                                    
                                    }
                                ?>
                            </select>

                            <div class="input-fileSubir">
                                <label for="Archivo">Archivo</label>
                                <input type="file" name="Archivo" id="Archivo" accept=".pdf, .jpg, .png" multiple>
                            </div>

                            <div class="radioInputsAr">
                                <label>Presento:</label>
                                <label for="DocumentosPresento"><input type="radio" name="DocumentosPresento" value="1"> Presento</label>
                                <label for="DocumentosPresento"><input type="radio" name="DocumentosPresento" value="0"> No presento</label>
                                <br>
                            </div>  
                        </div>
                        <input class="BTN_Enviar" type="submit" value="Guardar">
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