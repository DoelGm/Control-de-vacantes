<?php
    require '../../DB/conexionbd.php';
    session_start();
    $departamento = $_SESSION['Departamento'];
    $empresa = $_SESSION['Empresa'];

    $id_tipo_herramienta = $_POST["herramienta"];
    $id_empleado = $_POST["ID"];
    $fecha_asignacion = $_POST["fechaasiganacion"];

    $sql2 = "INSERT INTO herramientas_empleado  (`fecha_asignacion`, `Status`) VALUES ('$fecha_asignacion', 1)"; 
    $resultado2 = mysqli_query($conexionDB, $sql2);
    
    $lastInsertedId = mysqli_insert_id($conexionDB);

    $sql = "INSERT INTO herramienta_relacion (`id_empleado`, `id_herramienta`, `id_herramienta_asignada`) VALUES ('$id_empleado', '$id_tipo_herramienta', '$lastInsertedId')";
    $resultado = mysqli_query($conexionDB, $sql);
    


    $sql3 = "SELECT Departamento FROM departamentos WHERE id_empresa = '$empresa' AND '$departamento' = id_Departamento";
    $resultado3 = mysqli_query($conexionDB, $sql3);

    while($consulta = mysqli_fetch_assoc($resultado3)){
        if('Sistemas' == $consulta["Departamento"]){
            header("location: ../../src/views/Tics/almacenSistemas.php");
        }elseif('Taller' == $consulta["Departamento"]){
            header("location: ../../src/views/Taller/almacenTaller.php");
        } 
    }
   
    
    
?>