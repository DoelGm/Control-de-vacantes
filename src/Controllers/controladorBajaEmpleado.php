<?php  
    require '../../DB/conexionbd.php';
    $idEmpleado = $_POST["idEmpleado"];
    $Nombre = $_POST["nombre"];
    $FechaContratacion = $_POST["FechaDeContratacion"];
    $FechaDeBaja = $_POST["FechaDeBaja"];
    $Causa = $_POST["Causa"];
    $Comentario = $_POST["comentario"];
    $reingreso = $_POST["reingreso"];

    $sql = "INSERT INTO baja_empleados (id_empleado, fecha_contratacion, fecha_baja, Comentario, reingreso) VALUE ('$idEmpleado', '$FechaContratacion', '$FechaDeBaja', '$Comentario', '$reingreso')";
    $insert1 = mysqli_query($conexionDB, $sql);


    $sql1 = "SELECT id_baja_empleado FROM baja_empleados WHERE id_empleado = '$idEmpleado'";
    $resultado = $conexionDB -> query($sql1);

    $dato = $resultado -> fetch_assoc()["id_baja_empleado"];


    $sql2 = "INSERT INTO causa_baja_empleados (causa, id_baja_empleado) VALUE ('$Causa', '$dato')";
    $insert2 = $conexionDB -> query($sql2);

    $sql3 = "UPDATE empleados AS em JOIN baja_empleados AS ba  ON em.id_Empleado = ba.id_empleado SET em.Status = 0 WHERE em.id_Empleado = '$idEmpleado' AND  em.id_Empleado = ba.id_empleado";

    $update = $conexionDB -> query($sql3);

    header("Location: ../views/empleados.php")




















    // $sql1 = "SELECT * FROM baja_empleados WHERE id_empleado = '$idEmpleado'";
    // $consulta = mysqli_query($conexionDB, $sql1);

    // $resultado = mysqli_fetch_assoc($consulta);

    // $id_baja = $resultado['id_causa_baja'];

    // echo $id_baja;

    // $sql2 = "INSERT INTO causa_baja_empleados (causa, id_baja_empleado) VALUE ('$Causa', '$id_baja')";
    // $insert2 = mysqli_query($conexionDB, $sql2);


?>