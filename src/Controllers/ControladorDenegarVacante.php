<?php
require '../../DB/conexionbd.php';

$idVacante = $_POST["IdVacante"];

$sqlValidacion = "SELECT v.Vacante_autorizada FROM vacantes as v, vacantes_por_autorizar as vpa WHERE '$idVacante' = v.id_vacante AND vpa.id_vacante = v.Vacante_autorizada ";
$resultadoValidacion = mysqli_query($conexionDB, $sqlValidacion);
$validacion = mysqli_fetch_assoc($resultadoValidacion);

if(isset($validacion["Vacante_autorizada"])){

    $sql = "UPDATE vacantes SET Vacante_autorizada = null WHERE id_vacante = '$idVacante'";
    $actualizarVacanteAutorizar = mysqli_query($conexionDB, $sql);

    $sql2 = "DELETE FROM vacantes_por_autorizar WHERE id_vacante = '$idVacante'";
    $borrarVacante = mysqli_query($conexionDB, $sql2);

}else{
    $sql = "UPDATE vacantes SET Vacante_autorizada = null WHERE id_vacante = '$idVacante'";
    $actualizarVacanteAutorizar = mysqli_query($conexionDB, $sql);
    
    $sql = "DELETE FROM vacantes WHERE id_vacante = '$idVacante' AND Status = 0";
    $borrarVacante = mysqli_query($conexionDB, $sql);
}

header ('Location: ../views/Administrador/Vacantes.php');
?>