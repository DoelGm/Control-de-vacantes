<?php
  require '../../../DB/conexionbd.php';
  
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['IDAdmin'];

    if(isset($_SESSION['IDAdmin'])){


  $id_Aspirante = $_POST["ID"];
  // consulta de aspirantes 
  $sql = "SELECT * FROM aspirantes WHERE id_Aspirante = '$id_Aspirante'";
  $resultado = mysqli_query($conexionDB, $sql);
  $consulta = mysqli_fetch_assoc($resultado);
  $idvacante = $consulta["id_Vacante"];
  $fecha = $consulta["Fecha_nacimiento"];
  // consulta de departamentos
  $sql2 = "SELECT dep.id_Departamento, dep.Departamento FROM departamentos as dep, aspirantes as a, vacantes as v, puestos as p WHERE a.id_Aspirante = '$id_Aspirante' AND a.id_Vacante = v.id_vacante AND  v.id_Puestos = p.id_Puesto AND p.id_Departamento = dep.id_Departamento";
  $resulatdo2 = mysqli_query($conexionDB, $sql2);
  $consulta2 = mysqli_fetch_assoc($resulatdo2);
  // consulta de Puestos
  $sql4 = "SELECT id_Puestos FROM vacantes WHERE id_vacante = '$idvacante'";
  $resulatdo4 = mysqli_query($conexionDB, $sql4);
  $consulta3 = mysqli_fetch_assoc($resulatdo4);

  $sql3 = "SELECT p.id_Puesto FROM puestos as p, vacantes as v WHERE v.id_Puestos = p.id_Puesto ";
  $resulatdo3 = mysqli_query($conexionDB, $sql3);
  $listado = array();
  while($filas = mysqli_fetch_assoc($resulatdo3)){
    $listado[] = $resulatdo3;
    $actual = $filas['id_Puesto'];
    // echo $actual;
    if($actual === $consulta3["id_Puestos"]){
        $sql5 = "SELECT Puesto, id_Puesto FROM puestos WHERE id_Puesto = '$actual'";
        $resultado5 = mysqli_query($conexionDB, $sql5);
        $consulta4 = mysqli_fetch_assoc($resultado5);
        $puesto = $consulta4["Puesto"];
        $idPuesto = $consulta4["id_Puesto"];
        // echo $puesto;
    }

    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../img/ortusLogo.png">
    <title>Alta de Empleados</title>
    <link rel="stylesheet" href="../../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../../Styles/EstilosGlobales.css">
</head>
<body>
<div class="navbar">
        <img src="../../img/ortus_c.png" alt="" class="logo_imagen">
            <ul>
                    <li><a href="indexAdmin.php">Inicio</a></li>
                    <li><a href="aspirantesadmin.php">Aspirante</a></li>

                    <li class="dropdown">
                        <a>Empleados</a>
                        <div class="dropdown_Conetenido">
                            <a href="empleadosadmin.php">Activos</a>
                            <hr> 
                            <a href="empleadosInactivosAdmin.php">Inactivos</a>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a>Opciones de Administrador</a>
                        <div class="dropdown_Conetenido">
                            <a href="catalogoDocumento.php">Nuevos Documentos</a>
                            <hr>
                            <a href="Vacantes.php">Control de Nuevas Vacantes </a>
                            <hr> 
                            <a href="catalogoHerramientas.php">Nuevas Herramentas</a> 
                            <hr>
                            <a href="CrearVacante.php">Crear Vacante</a>
                        </div>
                    </li>

                    <li><a href="../../../DB/CerrarSesion.php">Salir</a></li>
            </ul>
</div>


    <h2 class="Encabezado" >Alta de Empleados</h2>
    <div class="conteiner1">
        <div style="width: 700px" id="registraraspirantes">
        
    <form action="../Controllers/controladorAltaEmpleado.php" method="POST">
        <div class="col-1">
            
        <input name="ID" type="number" hidden value="<?=$consulta["id_Aspirante"]?>"> 
            <input name="fechaDeNacimiento" type="" hidden value="<?=$fecha ?>">
            <input name="idVacante" type="number" hidden value="<?=$idvacante?>">

            <label style="padding-right: 430px" for="nombre">Nombre:</label>
            <input name="nombre"  readonly type="text" value="<?=$consulta["Nombre"]?>" type="text" id="nombre" >
            
            <label style="padding-right: 344px" for="apeliidop">Apellido Paterno:</label>
            <input name="apeliidop"  readonly  value="<?=$consulta["Apellido_paterno"]?>" type="text" id="apeliidop">
         
            <label style="padding-right: 344px" for="apeliidom">Apellido Materno:</label>
            <input name="apeliidom"  readonly  value="<?=$consulta["Apellido_materno"]?>" type="text" id="apeliidom">
            
            
            <label style="padding-right: 344px;" for="fechaContratacion">Fecha de contratacion:</label>
            <input style="background: rgb(255, 255, 255);" name="fechaContratacion" type="date" id="fechaContratacion" required>
        </div>
        
           <div class="col-2">
                
           <label for="Departamento">Departamento:</label>
            <input name="departamento" readonly  value="<?=$consulta2["Departamento"]?>" type="text" id="Departamento"> 
            <input name="idepartamento" type="number" hidden value="<?=$consulta2["id_Departamento"]?>">
       
            <label for="puesto">Puesto:</label>
            <input name="puesto" value="<?= $puesto?>" type="text" id="puesto" readonly>
            <input name="idPuesto" type="number" hidden value="<?=$idPuesto?>">
      
            <label for="noNomina">Numero de Nomina:</label>
            <input style="background: rgb(255, 255, 255); border: solid 1px black;" type="text" placeholder="Ingrese el Numero de Nomina"  name="noNomina" id="noNomina" required>
           </div>
        
            <input style="width: 80px; text-align: center; margin-top: 10px; margin-right: 420px; background-color: #1a2740; " class="BTNguardar" type="submit" value="Guardar">
        </form>
        </div>
    </div>
   
</body>
</html>
<?php

    }
    else{
        header('Location: ../../../index.php');
    }