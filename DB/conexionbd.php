<?php
    $host = "127.0.0.1";
    $user = "root";
    $password = "";
    $db = "ortus_vacantes_prueba";


    $conexionDB = new mysqli($host, $user, $password, $db);

    if ($conexionDB -> connect_error){
        die ("Fallo con la conexion a la base de datos: " . $conexionDB -> connect_error);
    }
    
?>