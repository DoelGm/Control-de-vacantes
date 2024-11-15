<?php
require '../../DB/conexionbd.php';
session_start();
$departamento = $_SESSION['Departamento'];
$empresa = $_SESSION['Empresa'];

$sql = "SELECT Departamento FROM departamentos WHERE id_empresa = '$empresa' AND '$departamento' = id_Departamento";
$resultado = mysqli_query($conexionDB, $sql);

    
    $id_herramienta = $_POST["id_herramienta"];
    $Estado = $_POST["Estado"];
    $SqlUpdate = "UPDATE herramientas SET estado = '$Estado' WHERE id_herramienta = '$id_herramienta'";
    $update = mysqli_query($conexionDB, $SqlUpdate);
    
    while($consulta = mysqli_fetch_assoc($resultado)){
        if('Sistemas' == $consulta["Departamento"]){
            header("location: ../../src/views/Tics/almacenSistemas.php");
        }elseif('Taller' == $consulta["Departamento"]){
            header("location: ../../src/views/Taller/almacenTaller.php");
        } 
    }
    
   

?>