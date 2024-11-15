<?php

    require '../../DB/conexionbd.php';
    
    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['Identificador'];

    if(isset($_SESSION['Identificador'])){

        $empresa = $_SESSION['Empresa'];
    

    $sql = "SELECT p.Puesto, p.id_Puesto, p.no_vacante FROM  departamentos as dep, puestos as p, vacantes as v, empresas as em WHERE v.id_Puestos = p.id_Puesto AND v.Status = 1  AND p.id_Departamento = dep.id_Departamento AND dep.id_empresa = em.id_Empresa AND '$empresa' = em.id_Empresa"; // consulta a la tabla de puesto de la base de datos
    $resultado = mysqli_query($conexionDB, $sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de nuevos Aspirantes</title>
    <link rel="stylesheet" href="../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../Styles/EstilosGlobales.css">
</head>
<body>
<div class="navbar">
            <img src="../img/ortus_c.png" alt="" class="logo_imagen">
            <ul>
                    <li><a href="indexEmpleado.php">Inicio</a></li>
                    <li><a href="aspirantes.php">Aspirante</a></li>

                    <li class="dropdown">
                        <a>Empleados</a>
                        <div class="dropdown_Conetenido">
                            <a href="empleados.php">Activos</a>
                            <a href="empleadosInactivos.php">Inactivos</a>
                        </div>
                    </li>

                    <li><a href="SolicitarVacante.php">Solicitar Vacantes</a></li> 

                    <li class="Salir"><a class="Salir" href="../../DB/CerrarSesion.php">Salir</a></li>
            </ul>
        </div>
    <h2 id="Titulo" >Registro de nuevos Aspirantes:</h2>
    <div class="conteiner1">
        <div style="width: 700px" id="registraraspirantes">
        <!-- inicio del formulario  -->
        <form action="../Controllers/controladorAltaAspirantes.php" method="POST">
        <!-- contenedor de divicion de los iputs y los labels -->
        <div class="col-1">
        <label style="padding-right: 433px" for="vacantes">Vacante:</label> 
            <select style="background: rgb(255, 255, 255);" name="vacantes"  id="vacantes" required>
            <option  value=""></option>
            <?php
            //validamos nuestras vacantes 
                while($consulta = mysqli_fetch_assoc($resultado)){
                    if(($consulta["no_vacante"] <= 0) || (!empty($consulta["id_vacante"]))){
                        continue;
                    }

            ?>
            <!-- Mostramos el puesto que esta vinculada a una vacante y obtenemos su id del puesto -->
                <option id="vacantes" value="<?=$consulta["id_Puesto"]?>"><?php echo $consulta["Puesto"];?></option>
            <?php
                }
            ?>
            </select>
            
            <label style="padding-right: 430px" for="nombre">Nombre:</label>
            <input name="Nombre" placeholder="Ingrese el Nombre" required  type="text" id="nombre" required>
            
            <label style="padding-right: 344px" for="apeliidop">Apellido Paterno:</label>
            <input name="apellidoPaterno" placeholder="Ingrese el Apellido Paterno" type="text" id="apeliidop" required >
         
            <label style="padding-right: 344px" for="apeliidom">Apellido Materno:</label>
            <input name="apellidoMaterno" placeholder="Ingrese el Apellido Materno" type="text" id="apeliidom">

            <!-- <label style="padding-right: 344px" for="CRP">CURP: </label>
            <input name="CURP" placeholder="Ingrese la CURP" type="text" id="CURP"> -->
            
            <!-- <label  for="EstadoCivil">Estado Civil:</label>
            <select style="background: rgb(255, 255, 255);" name="EstadoCivil"  required>
                <option></option>
                <option value="1">Soltero</option>
                <option value="0">Casado</option>
            </select> -->
            
        </div>
        
           <div class="col-2">
                
            <label  for="fechaNacimiento">Fecha de Nacimiento:</label>
            <input name="fechaNacimiento" type="date" id="fechaNacimiento" required >
       
            <label  for="numeroCelular">Numero de Celular:</label>
            <input name="numeroCelular" placeholder="Ingrese el Numero de Celular" type="number" id="numeroCelular" required>
    
            <!-- <label  for="numeroDeSeguroSocial">Numero de Seguro Social:</label>
            <input name="numeroDeSeguroSocial" placeholder="Ingrese el Numero de Seguro Social" type="number" id="numeroDeSeguroSocial" required> -->
            
            <!-- <label  for="status">Status:</label>
            <select style="background: rgb(255, 255, 255);" name="status"  required>
                <option></option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select> -->
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
    header('Location: ../../index.php');
}