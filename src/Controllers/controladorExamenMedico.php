<?php
    require '../../DB/conexionbd.php';

    session_start();
    $ID = $_SESSION['Identificador'];
    // Inicializamos las variables que contrendran el valor de nuestros inputs
    $tipoExamen = $_POST["TipoExamen"];
    $idAspirante = $_POST["idAspirante"];
    $fechaExamen = date('Y-m-d');
    $comentarios = $_POST["comentario"];
    $status = $_POST["examenAprobo"];


     //Varaible para obtener el contenido del archivo
    if(isset($archivoExamen)){
        $archivoExamen = file_get_contents($_FILES["examen"]["tmp_name"]);
    
        $stmt = $conexionDB -> prepare("INSERT INTO examen_medico_aspirante (id_examen, id_aspirante, status, Comentarios, Archivo, id_empleados_aplico, fecha) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
        $stmt->bind_param("iiissss", $tipoExamen, $idAspirante, $status, $comentarios, $archivoExamen, $ID, $fechaExamen);
        $stmt->execute();
        
    }else{
        $stmt = $conexionDB -> prepare("INSERT INTO examen_medico_aspirante (id_examen, id_aspirante, status, Comentarios, id_empleados_aplico, fecha) VALUES (?, ?, ?, ?, ?, ?)");
    
        $stmt->bind_param("iiisss", $tipoExamen, $idAspirante, $status, $comentarios, $ID, $fechaExamen);
        $stmt->execute();
    }
    
    
    // hacemos  una una consulta para obtener datos para poder hacer validaciones 
    $sql = "SELECT ema.status, a.Status, esmv.filtro, a.id_Aspirante FROM examen_servicio_medico_vacante as esmv, examen_medico_aspirante as ema, aspirantes as a  WHERE esmv.id_examen = ema.id_examen AND a.id_Aspirante = ema.id_aspirante AND ema.status =0";
    $resultado = mysqli_query($conexionDB, $sql);

    // hacemos un blucle en donde podamos validar todos los resultados
    while($consulta = mysqli_fetch_assoc($resultado)){

        $listado[] = $resultado;
        $actual = $consulta['status'];
        $id = $consulta["id_Aspirante"];
        $filtro = $consulta["filtro"];

        // filtro viene de la tabla examen_servicio_medico_vacante en donde verificamos si fitro es igual a 0 hace el update de status a 0 de los aspirantes 
        if($filtro == 0){
            if($actual == 0){
                $actualizacionDePuestos = "UPDATE aspirantes SET Status = 0 WHERE id_Aspirante = '$id'";
                $actualizacion = mysqli_query($mysqli, $actualizacionDePuestos);
                }    
        }
            
    }


    header ("Location: ../views/Medico/aspirantesMedico.php");

    
?>

