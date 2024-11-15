<?php
require '../../DB/conexionbd.php';
session_start();

$id_aspirante = $_POST["ID_Aspirante"];

$nombre = $_SESSION['Nombre'];

$ID = $_SESSION['Identificador'];

if (isset($_SESSION['Identificador'])) {




?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../img/ortusLogo.png">
        <title>Cargar Documentos Aspirantes</title>
        <link rel="stylesheet" href="../../Styles/estilo2.css">
        <link rel="stylesheet" href="../../Styles/EstilosGlobales.css">
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

        <div class="Encabezado">
            <h1>Cargar documentos aspirantes</h1>
        </div>

        <div class="contenedor1">
            <div class="formularioSubirDocs">
                <form action="../Controllers/ControladorSubirArchivo.php" method="POST" enctype="multipart/form-data">
                    <div class="SubirArchi">

                        <?php

                        $query = "SELECT a.Nombre, a.Apellido_paterno, a.Apellido_materno, p.Puesto FROM aspirantes AS a, vacantes AS va, puestos AS p WHERE a.id_Aspirante = '$id_aspirante' AND a.id_vacante = va.id_vacante AND va.id_Puestos = p.id_Puesto";

                        $resultado = mysqli_query($conexionDB, $query);

                        $consulta = mysqli_fetch_assoc($resultado);
                        ?>

                        <input type="hidden" name="id_Aspirante" value="<?php echo $id_aspirante ?>">
                        <label class="" for="nombre">Nombre: </label>
                        <input class="SubirArchiText" id="nombre" name="nombre" type="text" disabled readonly value="<?php echo $consulta["Nombre"] . " " . $consulta["Apellido_paterno"] . " " . $consulta["Apellido_materno"] ?>">


                        <label for="Puesto">Puesto: </label>
                        <input class="SubirArchiText" id="Puesto" name="Puesto" disabled type="text" readonly value="<?php echo $consulta["Puesto"] ?> ">

                        <?php
                        $QueryDocumentos = "SELECT doc.* FROM documentos AS doc, vacantes AS va, aspirantes AS a WHERE a.id_Aspirante = '$id_aspirante' AND a.id_Vacante = va.id_vacante AND doc.id_vacante = va.id_vacante";

                        $resultado2 = $conexionDB->query($QueryDocumentos);

                        $QueryArchivo = "SELECT da.* FROM documentos_aspirantes AS da, documentos AS d, vacantes AS va, aspirantes AS a WHERE da.id_Aspirante = '$id_aspirante' AND da.id_documento = d.id_documento";
                        $resultado3 = $conexionDB -> query($QueryArchivo);

                        ?>
                        <label for="TipoDocumento">Tipo de documentos:</label>
                        <select name="TipoDocumento" id="SubirArchiText" required>
                            <option value=""></option>
                            <?php
                            while ($row = $resultado2->fetch_assoc() && $row2 = $resultado3->fetch_assoc()) {
                                if(isset($row2['Archivo'])){
                                    echo "El archivo existe";
                                }

                            ?>
                                <option value="<?php echo $row['id_documento'] ?>"><?php echo $row['Nombre_Documento'] ?></option>
                            <?php
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
} else {
    header('Location: ../../index.php');
}
