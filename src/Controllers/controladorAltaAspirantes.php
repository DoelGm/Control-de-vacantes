<?php
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){

?>
       
<?php
                // inputs del registro de nuevos aspirantes 
                require '../../DB/conexionbd.php';
                $vacantes = $_POST["vacantes"]; 
                $nombre = $_POST["Nombre"]; 
                $apeliidop = $_POST["apellidoPaterno"];
                $apeliidom = $_POST["apellidoMaterno"];
                $fechaNacimiento = $_POST["fechaNacimiento"];
                $numeroCelular = $_POST["numeroCelular"];
                // $status = $_POST["status"];
                
                //consulta para obtener el id de puestos cuando sea igual a el id que llamamos de nuestro input
                $sql = "SELECT id_Puesto FROM puestos WHERE id_Puesto = '$vacantes'";
                $resultado = mysqli_query($conexionDB, $sql);
                $consulta =  mysqli_fetch_assoc($resultado);
                $x = $consulta["id_Puesto"];
                // hacemos una validacion de nuestros campos con un if
                if ($vacantes == $x){   
                    // consulta de el id_vacantes 
                    $vacante = "SELECT id_vacante FROM vacantes WHERE id_Puestos = '$vacantes'";
                    $r = mysqli_query($conexionDB, $vacante);
                    $consulta3 = mysqli_fetch_assoc($r);
                    $variable = $consulta3["id_vacante"];
                    // hacemos una inserciona a la tabla de aspirantes con el id obtenido de la consulta anterior
                    $insert = "INSERT INTO aspirantes (`id_vacante`, `Nombre` , `Apellido_materno` , `Apellido_paterno`, `Fecha_nacimiento`, `No_celular`, `Status` ) VALUES ('$variable', '$nombre','$apeliidom', '$apeliidop', '$fechaNacimiento', '$numeroCelular', 1)";
                    $registro = mysqli_query($conexionDB, $insert);
                    // redirigir a aspirantes.php
                    header ('Location: ../views/aspirantes.php');
                }

               
               
?> 
<?php

}
else{
    header('Location: ../../index.php');
}