<?php
 require '../../DB/conexionbd.php';

 $idEmpleado = $_POST["idEmpleado"];
 $nuevoUsuario = $_POST["Usuario"];
 $password = $_POST["password"];
 $conpassword = $_POST["conpassword"];
 if($password == $conpassword){
    $sql = "UPDATE empleados SET Usuario = '$nuevoUsuario', contraseña = '$password' WHERE id_Empleado = '$idEmpleado'";
    $resultado = mysqli_query($conexionDB, $sql);
    session_start();
    $_SESSION['mensajeERR'] = "";
    header ("Location: ../views/Tics/asignarUsuarios.php");
 }else{
   session_start();
   $_SESSION['mensajeERR'] = "Las credenciales no coinciden";
   $_SESSION['Empleado'] = $idEmpleado;
    header ("Location: ../views/Tics/nuevosUsuarios.php");
    
 }
 



?>