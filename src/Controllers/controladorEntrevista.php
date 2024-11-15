<?php

include '../../DB/conexionbd.php';
$comentarios = $_POST["comentario"];
$Id_aspirante = $_POST["ID"];
$fecha = date('Y-m-d H:i:s');

$Archivo = file_get_contents($_FILES["Archivo"]["tmp_name"]);

$stmt = $conexionDB -> prepare("INSERT INTO entrevista (id_Aspirante, fecha, comentario, Archivo) VALUES (?, ?, ?, ?)");

$stmt -> bind_param("isss", $Id_aspirante, $fecha, $comentarios, $Archivo);

$stmt -> execute();

header("Location: ../views/aspirantes.php");



?>