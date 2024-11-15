<?php
    //TODO: Este controlado sube el archivo del Empleado

    
    //Llamamos la conexion a la BD
    require '../../DB/conexionbd.php';


    //Declaracion de las variables
    $id_Empleado = $_POST["id_Empleado"];
    $id_Documento = $_POST["TipoDocumento"];
    // $presento = $_POST["DocumentosPresento"];
    //Esta es la variable que obtendra el contenido del archivo
    $ARCHIVO = file_get_contents( $_FILES["Archivo"]["tmp_name"]);

    $fecha = date('Y-m-d H:i:s');

    $stmt= $conexionDB -> prepare("INSERT INTO documentos_empleados (id_documento, id_empleado, Archivo, fecha_carga) VALUES (?, ?, ?, ?)");

    $stmt -> bind_param("iiss", $id_Documento, $id_Empleado, $ARCHIVO, $fecha);
    $stmt -> execute();

    header("Location: ../views/empleados.php");