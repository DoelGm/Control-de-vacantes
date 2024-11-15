
<?php
require '../../DB/conexionbd.php';
session_start();
$nombre = $_SESSION['Nombre'];
// $ID_Empleado = $_POST["ID_Empleado"];
if(isset($_POST["ID_Empleado"])){
    $_SESSION["id_E"] = $_POST["ID_Empleado"];
    $ID_Empleado = $_SESSION["id_E"];
}else{
    $ID_Empleado = $_SESSION["id_E"];
}
$empresa = $_SESSION['Empresa'];
$ID = $_SESSION['Identificador'];

    if (isset($_SESSION['Identificador'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST["opciones"])){
                    $opcionSeleccionada = $_POST["opciones"];
                } 
                // echo $opcionSeleccionada;       
        }
    if(isset($_POST["enviar"])){
            $vacantes = $_POST["vacantes"];
            $sql = "SELECT v.id_Puestos, p.id_Departamento FROM vacantes as v, puestos as p WHERE v.id_Puestos = p.id_Puesto AND v.id_vacante = '$vacantes' ";
            $resultadov = mysqli_query($conexionDB, $sql);
            $consultav = mysqli_fetch_assoc($resultadov); 
            
            $puesto = $consultav["id_Puestos"];
            $departamento = $consultav["id_Departamento"];

            $sqlActualizar = "UPDATE empleados SET id_Vacante = '$vacantes', id_Puesto = '$puesto', id_Departamento = '$departamento' WHERE id_Empleado = '$ID_Empleado'";
            $update = mysqli_query($conexionDB, $sqlActualizar);
            // echo $ID_Empleado;

            $actualizacionDePuestos = "UPDATE puestos SET no_vacante = no_vacante - 1 WHERE id_Puesto  = '$puesto' ";
            $actualizacion = mysqli_query($conexionDB, $actualizacionDePuestos);


    }    
    $sql = "SELECT DISTINCT em.Empresa, dep.id_empresa FROM empresas as em, departamentos as dep WHERE dep.id_empresa = em.id_Empresa";
    $resultado = mysqli_query($conexionDB, $sql);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emigrar de empresa</title>
    <link rel="shortcut icon" href="../img/ortusLogo.png">
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
        <div class="Encabezado">
            <h1>Emigrar de empresa</h1>
        </div>
        <div style="width: 700px" id="registraraspirantes">
        <form action="" method="POST">
            <div class="col-1">

                    <label for="Empresa">Empresa: </label>
                    <select style="background: rgb(255, 255, 255);" name="opciones" onchange="submitForm2()" id="Empresa" required>
                        <option></option>
                        <?php 
                        while($consulta = mysqli_fetch_assoc($resultado)){
                            echo '<option' . (($opcionSeleccionada == $consulta['id_empresa']) ? ' selected' : '') . ' value="'.$consulta['id_empresa'].'">'. $consulta['Empresa'].'</option>';
                        }
                        ?>
                        
                    </select>
                    <noscript><input type="submit" value="Enviar"></noscript>
                    <script>
                        function submitForm2() {
                            // Envía el formulario automáticamente cuando se selecciona una opción
                            document.querySelector('form').submit();
                        }
                    </script>
                    <?php
                        if(isset($opcionSeleccionada)){
                            $sql3 = "SELECT v.id_vacante, p.Puesto, p.no_vacante FROM vacantes as v, departamentos as dep, puestos as p, empresas as em WHERE v.id_Puestos = p.id_Puesto AND v.Status = 1 AND  dep.id_Departamento = p.id_Departamento AND dep.id_empresa = em.id_Empresa AND em.id_Empresa = '$opcionSeleccionada'"; // consulta a la tabla de puesto de la base de datos
                            $resultado3 = mysqli_query($conexionDB, $sql3);
                            // $consulta3 = mysqli_fetch_assoc($resultado3);
                        }
                    ?>
                    <label for="vacantes">Vacantes: </label>
                    <select style="background: rgb(255, 255, 255);" name="vacantes" id="vacantes" required>
                        <option></option>
                        <?php 
                        while($consulta3 = mysqli_fetch_assoc($resultado3)){
                            if($consulta3["no_vacante"] == 0){
                                continue;
                            }
                        ?>
                        <option value="<?=$consulta3['id_vacante']?>"><?php echo $consulta3['Puesto']?> </option>    
                        <?php
                        }
                        ?>                    
                    </select>
                       
            
                
<!-- 
            <label style="padding-right: 433px" for="vacantes">Vacante:</label> 
            <select style="background: rgb(255, 255, 255);" name="vacantes"  id="vacantes" required>
            <option  value=""></option>
            <?php
            // if(isset($opcionSeleccionada)){
            //     $sql3 = "SELECT v.id_vacante, p.Puesto FROM vacantes as v, departamentos as dep, puestos as p WHERE v.id_Puestos = p.id_Puesto AND v.Status = 1 AND  dep.id_Departamento = p.id_Departamento AND dep.id_empresa = em.id_Empresa AND em.id_Empresa = '$opcionSeleccionada'"; // consulta a la tabla de puesto de la base de datos
            //     $resultado3 = mysqli_query($conexionDB, $sql3);
            //     $consulta3 = mysqli_fetch_assoc($resultado3);
            //    }
             //validamos nuestras vacantes 
                // while($consulta3 = mysqli_fetch_assoc($resultado3)){
                //     echo '<option' . (($opcionSeleccionada == $consulta['id_empresa']) ? ' selected' : '') . ' value="'.$consulta3['id_vacante'].'">'. $consulta3['Puesto'].'</option>';
                // }
            ?>
            </select>
             -->
            </div>
            </div>
            <input class="BTN_MigrarEmpresa" type="submit" name="enviar" value="Cambiar de empresa">
    </form>
    

</body>
</html>

<?php
}
?>