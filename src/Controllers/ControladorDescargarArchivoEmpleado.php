<?php
    require'../../DB/conexionbd.php';

    $id_documento = $_POST["id_Documento"];

    $id_empleado = $_POST['id_Empleado'];

    
    $extenciones = array("aplicacion/pdf" => "pdf");

    $sql = "SELECT de.Archivo, doc.Nombre_Documento, em.Nombre FROM documentos_empleados AS de, documentos AS doc, empleados AS em, vacantes AS va WHERE de.id_documento_empleado = '$id_documento' AND de.id_empleado = em.id_Empleado AND de.id_documento = doc.id_documento";

    $resultado = mysqli_query($conexionDB, $sql);

    $fila = mysqli_fetch_assoc($resultado);


    if($fila){
        $archivoBin = $fila['Archivo'];
        $temFilePath = '../Temp/Archivo.pdf';

        file_put_contents($temFilePath, $archivoBin);

        $contenido = file_get_contents($temFilePath);

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$fila['Nombre_Documento'].$fila['Nombre'].'.pdf"');

        echo $contenido;

        unlink($temFilePath);

    }else{
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../../Styles/Sin_Archivo.css">
            <title>Archivo no encontrado</title>
        </head>
        <body>
            <div class="contenedor1">
                <div class="contenedor2">
                    <img class="logo" src="../img/404.png" alt="">

                    <h2> Archivo no encontrado </h2>


                    <form action="../views/historialAspirante.php" method="POST">
                        <button class="BTN_Regresar" type="submit" name="ID" value="<?php echo $id_empleado ?>">Regresar</button>
                    </form>
                </div>
            </div>
        </body>
        </html>

    <?php
    }
