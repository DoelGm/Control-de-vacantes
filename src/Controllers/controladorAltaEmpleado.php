<?php
   // conexion a la base de datos 
      require '../../DB/conexionbd.php';
      // inicializamos los valores de nuestros inputs en variables 
      $idAspirante = $_POST["ID"];
      $idVacante = $_POST["idVacante"];
      $nombre = $_POST["nombre"]; 
      $apeliidop = $_POST["apeliidop"];
      $apeliidom = $_POST["apeliidom"];
      $fechaNacimiento = $_POST["fechaDeNacimiento"];
      $fechaContratacion = $_POST["fechaContratacion"];
      $numeroDeNomina = $_POST["noNomina"];
      $departamento = $_POST["idepartamento"];
      $idPuesto = $_POST["idPuesto"];

      // insertamos nuestros valores obtenidos a la base de datos 
      $sql = "INSERT INTO empleados (`id_Departamento`, `id_Aspirante`, `id_Vacante`, `id_Puesto`, `Nombre`, `Apellido_paterno`,`Apellido_materno`, `Fecha_nacimiento` , `Numero_nomina`, `Status`) VALUE ('$departamento', '$idAspirante', '$idVacante', '$idPuesto', '$nombre', '$apeliidop', '$apeliidom', '$fechaNacimiento', '$numeroDeNomina', '1' )";
      $insert = mysqli_query($conexionDB, $sql);
      // hacemos una consulta para obtener el id del empleado y del aspirante estos tienen que coinsidir 
      $sql2 = "SELECT a.id_Aspirante, empl.id_Empleado FROM aspirantes as a, empleados as empl WHERE a.id_Aspirante = empl.id_Aspirante AND a.id_Aspirante =  $idAspirante";
      $resultado = mysqli_query($conexionDB, $sql2);
      // insertamos el id_empleado a la tabla de empleado contratado, la id de la vacante y la fecha de contratacion 
      $consultaID = mysqli_fetch_assoc($resultado);
      $IdEmpleado = $consultaID["id_Empleado"];
      $sql3 = "INSERT INTO empleadocontratado (id_Empleado, id_Vacante, Fecha_Contratado) VALUE ('$IdEmpleado',  '$idVacante', '$fechaContratacion')";
      $insetar_Id_Empleado_Contratado = mysqli_query($conexionDB, $sql3); 
  
     // actualizacion del numero de vacantes disponibles se resta al agregar un nuevo Empleado  
     $actualizacionDePuestos = "UPDATE puestos SET no_vacante = no_vacante - 1 WHERE id_Puesto  = '$idPuesto' ";
     $actualizacion = mysqli_query($conexionDB, $actualizacionDePuestos);
     // Cambio de status para el aspirante al pasar como empleado
        $cambioDeStatus = "UPDATE aspirantes SET Status = 0 WHERE id_Aspirante = '$idAspirante'";
        $actualizacion = mysqli_query($conexionDB, $cambioDeStatus);

     
     header ('Location: ../views/empleados.php');
     
  ?>