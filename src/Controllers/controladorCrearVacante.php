<?php

    require '../../DB/conexionbd.php';

    session_start();

    $nombre = $_SESSION['Nombre'];
    $ID =  $_SESSION['IDAdmin'];
    $idPuesto = $_POST["puesto"];
    $fechaSolicitud = $_POST["FechaDeSolicitud"];
    $fechaCubrir = $_POST["FechaACubrir"];
    $comentarios = $_POST["comentario"];
    $noVacantes = $_POST["No_Vacantes"];
    // $status = $_POST["Status"];
    $sql = "INSERT INTO vacantes (`id_Puestos`, `id_empleado_solicitud`,`id_empleado_autoriza`,`Fecha_Solicitud`, `Fecha_cubrir`, `Comentarios`,`Status`) VALUE ('$idPuesto', '$ID','$ID','$fechaSolicitud', '$fechaCubrir',  '$comentarios', 1)";
    $insert = mysqli_query($conexionDB, $sql);
    
    $sql2 = "UPDATE puestos SET no_vacante = no_vacante + '$noVacantes' WHERE '$idPuesto' = id_Puesto";
    $updatePuestos = mysqli_query($conexionDB, $sql2);
    
    header ("Location: ../views/administrador/CrearVacante.php");

?>

