<?php
    //TODO: Este Controlador sube el archivo del Aspirante

    //Llamamos la conexion a la BD
    require '../../DB/conexionbd.php';


    //Declaracion de las variables
    $id_Aspirante = $_POST["id_Aspirante"];
    $id_Documento = $_POST["TipoDocumento"];
    $presento = $_POST["DocumentosPresento"];
    //Esta es la variable que obtendra el contenido del archivo
    $ARCHIVO = file_get_contents( $_FILES["Archivo"]['tmp_name']);

    $fecha = date('Y-m-d H:i:s');

    $stmt =$conexionDB -> prepare("INSERT INTO documentos_aspirantes (id_Aspirante, id_documento, presento, Archivo, Fecha_carga) VALUES (?, ?, ?, ?, ?)");
    $stmt -> bind_param("iiiss", $id_Aspirante, $id_Documento, $presento, $ARCHIVO, $fecha);
    $stmt -> execute();

    header("Location: ../views/aspirantes.php");