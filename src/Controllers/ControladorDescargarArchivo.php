<?php
    require '../../DB/conexionbd.php';
    $id_documento = $_POST['id_doc'];
    $id_aspirante = $_POST['id_Aspirante'];

    $extenciones = array("aplicacion/pdf" => "pdf");

    $sql = "SELECT da.Archivo, doc.Nombre_Documento, a.Nombre FROM documentos_aspirantes AS da, documentos AS doc, aspirantes AS a WHERE da.id_documento_aspirante = '$id_documento' AND da.id_Aspirante = a.id_Aspirante AND da.id_documento = doc.id_documento";

    $resultado = mysqli_query($conexionDB, $sql);

    $row = mysqli_fetch_assoc($resultado);

  

    if($row) {
        $archivoBin = $row['Archivo'];
        $temFilePath = '../Temp/Archivo.pdf';


        file_put_contents($temFilePath, $archivoBin);

        $contenido = file_get_contents($temFilePath);

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$row['Nombre_Documento']."_".$row['Nombre'].'.pdf"');

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
                            <button class="BTN_Regresar" type="submit" name="ID" value="<?php echo $id_aspirante ?>">Regresar</button>
                        </form>
                    </div>
                </div>
            </body>
            </html>

        <?php

    }

    // mysqli_close($conexionDB);
