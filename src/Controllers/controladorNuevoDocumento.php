<?php
  require '../../DB/conexionbd.php';

    $vacante = $_POST["vacante"];
  
    $forzoso = $_POST["forzoso"];
    $documento = $_POST["documento"];


    $sqld = "INSERT INTO documentos (`id_vacante`, `Nombre_Documento`, `Forzoso`, `Status`) VALUES ('$vacante','$documento','$forzoso', 1)";
    $insert = mysqli_query($conexionDB, $sqld);
    header ('Location: ../views/Administrador/catalogoDocumento.php');

?>
