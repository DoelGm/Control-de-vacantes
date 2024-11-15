<?php

    require '../../DB/conexionbd.php';

    session_start();

    $nombre = $_SESSION['Nombre'];
    $fechaActual = date('Y-m-d');
    $ID = $_SESSION['Identificador'];

    $idPuesto = $_POST["puesto"];
    // $fechaSolicitud = $_POST["FechaDeSolicitud"];
    $fechaCubrir = $_POST["FechaACubrir"];
    $comentarios = $_POST["comentario"];
    $noVacantes = $_POST["No_Vacantes"];
    $herramientas = $_POST["herramientas"];
    // $status = $_POST["Status"];
    $sql = "INSERT INTO vacantes (`id_Puestos`, `id_empleado_solicitud`, `Fecha_Solicitud`, `Fecha_cubrir`, `Comentarios`, `Herramientas`,  `noVacantes_Aceptar`, `Status`) VALUE ('$idPuesto', '$ID', '$fechaActual' , '$fechaCubrir',  '$comentarios', '$herramientas', '$noVacantes', 0)";
    $insert = mysqli_query($conexionDB, $sql);
    $ultimoInsertedId = mysqli_insert_id($conexionDB);
    
    $_SESSION['idVacante'] = $ultimoInsertedId; 

    header ("Location: ../views/SolicitarVacante.php");

?>

