<?php
    require '../../DB/conexionbd.php';
    $id_tipo_herramienta = $_POST["idTipoHerramienta"];
    $idHerramienta = $_POST["ID"];
    $horaActual = $fechaExamen = date('Y-m-d');
    $update = "UPDATE herramientas SET fecha_devolucion = '$horaActual' WHERE id_herramienta = '$idHerramienta'";
    $actualizarFecha = mysqli_query($conexionDB, $update);
    
    $update = "UPDATE tipo_herramienta SET Cantidad = Cantidad + 1 WHERE id_tipo_herramienta = '$id_tipo_herramienta'"; 
    $actualizarCantidad = mysqli_query($conexionDB, $update);
    header('Location: ../views/tabla_herramientas.php');




?>