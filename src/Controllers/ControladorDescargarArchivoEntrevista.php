<?php
    require '../../DB/conexionbd.php';

    $id_archivo = $_POST["Archi_Entrevista"];

    $extenciones = array("aplicacion/pdf" => "pdf");

    $consulta = "SELECT en.Archivo, a.Nombre FROM entrevista AS en, aspirantes AS a WHERE en.id_entrevista = '$id_archivo' AND en.id_Aspirante = a.id_Aspirante";

    $resultado = mysqli_query($conexionDB, $consulta);

    $fila = mysqli_fetch_assoc($resultado);

    if($fila){
        $archivoEnBin = $fila['Archivo'];
        $temFilePath = '../Temp/Archivo.pdf';

        file_put_contents($temFilePath, $archivoEnBin);

        $contenido = file_get_contents($temFilePath);

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Entrevista '.$fila['Nombre'].'.pdf"');

        echo $contenido;

        unlink($temFilePath);

    }else{
        echo "El archivo no existe";
    }