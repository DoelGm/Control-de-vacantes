<?php
    require '../../DB/conexionbd.php';

    $id_DocumentoExamen = $_POST['id_examen_DOC'];

    $extencion = array("aplicacion/pdf" => "pdf");

    $sql = "SELECT ema.Archivo, tem.examen, a.Nombre FROM examen_medico_aspirante AS ema, examen_servicio_medico_vacante AS esmv, tipos_examen_medico AS tem, vacantes AS va, aspirantes AS a WHERE ema.id_examen_aspirante = '$id_DocumentoExamen' AND ema.id_examen = esmv.id_examen AND esmv.id_tipo = tem.id_tipo_examen AND esmv.id_vacante = va.id_vacante AND ema.id_aspirante = a.id_Aspirante";

    $resulta = mysqli_query($conexionDB, $sql);

    $row = mysqli_fetch_assoc($resulta);

    if($row){
        $archivoBIN = $row['Archivo'];
        $temFilePath = '../Temp/Archivo.pdf';

        file_put_contents($temFilePath, $archivoBIN);

        $contenido = file_get_contents($temFilePath);
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Examen '.$row['examen'].$row['Nombre'].'.pdf"');

        echo $contenido;

        unlink($temFilePath);
    }else{
        echo "El archivo no existe <br> O hay un error";
    }