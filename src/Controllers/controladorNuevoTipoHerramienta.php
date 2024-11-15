
<?php
    // inputs del registro de nuevas tipos de herramientas  
    require '../../DB/conexionbd.php';
    $NombreH = $_POST["NombreH"]; 
    $NSerie = $_POST["NSerie"];
    $TipoHerramienta = $_POST["TipoHerramienta"]; 
    $cantidad = $_POST["cantidad"];
    $descripcion = $_POST["descripcion"];
    $vacantes = $_POST["vacantes"];
    $sql = "INSERT INTO tipo_herramienta (`Nombre`, `No_Serie`, `Tipo`, `Descripcion`, `Cantidad`, `id_vacante`) VALUES ('$NombreH','$NSerie','$TipoHerramienta','$descripcion','$cantidad', '$vacantes')";
    $insert = mysqli_query($conexionDB, $sql);
    header ("Location: ../views/administrador/catalogoHerramientas.php");
?>