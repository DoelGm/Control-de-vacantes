<?php
require '../../DB/conexionbd.php';
session_start();

$ID =  $_SESSION['IDAdmin'];

$idVacante = $_POST["IdVacante"];

// Consulta para validar si es actualizacion o es creacion de las vacantes
$sqlValidacion = "SELECT v.Vacante_autorizada, vpa.id_vacante FROM vacantes as v, vacantes_por_autorizar as vpa WHERE '$idVacante' = v.id_vacante AND vpa.id_vacante = v.Vacante_autorizada ";
$resultadoValidacion = mysqli_query($conexionDB, $sqlValidacion);
$validacion = mysqli_fetch_assoc($resultadoValidacion);
$idVacanteAutorizar=$validacion["id_vacante"];

// Actualizacion de una vacante ya existente
if(isset($validacion["Vacante_autorizada"])){
        $idActualizarVacante = $validacion["Vacante_autorizada"];
        $sqlActualizacion = "SELECT * FROM vacantes_por_autorizar WHERE '$idActualizarVacante' = id_vacante";
        $resultadoActualizacion = mysqli_query($conexionDB, $sqlActualizacion);
        $Actualizar = mysqli_fetch_assoc($resultadoActualizacion);

        // inicializamos las variables con la consulta
        $empleadoSolicita = $Actualizar["id_empleado_solicitud"];
        $fechaSolicitud = $Actualizar["Fecha_Solicitud"];
        $fechaCubrir = $Actualizar["Fecha_cubrir"];
        $comentarios = $Actualizar["Comentarios"];
        $Status = $Actualizar["Status"];


        $sqlupdate = "UPDATE vacantes SET id_empleado_autoriza = '$ID', id_empleado_solicitud = '$empleadoSolicita', 
        Fecha_Solicitud = '$fechaSolicitud', Fecha_cubrir = '$fechaCubrir', 
        Comentarios = $comentarios, Status = '$Status' WHERE = Vacante_autorizada = '$idVacanteAutorizar' ";
        $update = mysqli_query($conexionDB, $sqlupdate);


        $sql2 = "SELECT noVacantes_Aceptar, id_Puestos FROM vacantes WHERE '$idVacante' = id_vacante";
        $resultado = mysqli_query($conexionDB, $sql2);
        $consulta = mysqli_fetch_assoc($resultado);
        $no_vacantes = $consulta["noVacantes_Aceptar"];
        $idPuestos = $consulta["id_Puestos"];

        $sql3 = "UPDATE puestos SET no_vacante = '$no_vacantes' WHERE '$idPuestos' = id_Puesto";
        $actualizarPuestos = mysqli_query($conexionDB, $sql3);

        
        $sql4 = "UPDATE vacantes SET Vacante_autorizada = null, noVacantes_Aceptar = null WHERE id_vacante = '$idVacante'";
        $actualizarVacanteAutorizar = mysqli_query($conexionDB, $sql4);

        $sqlborrar = "DELETE FROM vacantes_por_autorizar WHERE id_vacante = '$idVacante'";
        $borrarVacante = mysqli_query($conexionDB, $sqlborrar);

// creacion de una nueva vacante ya aceptada
}else{
    $sql = "UPDATE vacantes SET id_empleado_autoriza = $ID, Status = 1 WHERE id_vacante = $idVacante";
    $aceptar = mysqli_query($conexionDB, $sql);
    $sql2 = "SELECT noVacantes_Aceptar, id_Puestos FROM vacantes WHERE '$idVacante' = id_vacante";
    $resultado = mysqli_query($conexionDB, $sql2);
    $consulta = mysqli_fetch_assoc($resultado);
    $no_vacantes = $consulta["noVacantes_Aceptar"];
    $idPuestos = $consulta["id_Puestos"];
    
    $sql3 = "UPDATE puestos SET no_vacante = no_vacante + '$no_vacantes' WHERE '$idPuestos' = id_Puesto";
    $actualizarPuestos = mysqli_query($conexionDB, $sql3);

    $sql4 = "UPDATE vacantes SET noVacantes_Aceptar = null WHERE id_vacante = '$idVacante'";
    $actualizarVacantePorAceptar = mysqli_query($conexionDB, $sql4);

}
header ('Location: ../views/Administrador/Vacantes.php');



?>