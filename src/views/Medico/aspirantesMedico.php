<?php

     session_start();

     $nombre = $_SESSION['Nombre'];

     $ID = $_SESSION['Identificador'];

    // if(isset($_SESSION['Identificador'])){

     $empresa = $_SESSION['Empresa'];
        
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../../Styles/EstilosGlobales.css">
    <link rel="shortcut icon" href="../../img/ortusLogo.png">
    <title>Aspirantes</title>
</head>

<body>
<div class="navbar">
            <img src="../../img/ortus_c.png" alt="" class="logo_imagen">
            <ul>
                    <li><a href="aspirantesMedico.php">Aspirante</a></li>

                    <!-- <li class="dropdown">
                        <a>Empleados</a>
                        <div class="dropdown_Conetenido">
                            <a href="empleados.php">Empleados</a>
                           
                        </div>
                    </li> -->

                

                    <li class="Salir"><a class="Salir" href="../../../DB/CerrarSesion.php">Salir</a></li>
            </ul>
        </div>
    <div class="Encabezado">
        <h1>Aspirantes área medica</h1>
    </div>
    <div class="buscar">
    <form action="" method="GET">
        <input name="buscar" id="Buscar" type="search" placeholder="buscar" >
    </form>
    </div>
    <?php
        
        require '../../../DB/conexionbd.php';
        if (isset($_GET['buscar'])) {
            $buscar = $_GET['buscar'];
            
            // Dividir los términos de búsqueda en un array
            $terminos = explode(" ", $buscar);
            
            // Crear un array para almacenar las condiciones de búsqueda
            $condiciones = array();
            
            // Construir las condiciones de búsqueda
            foreach ($terminos as $termino) {
                $condiciones[] = "(a.id_Aspirante LIKE '%$termino%' OR a.Nombre LIKE '%$termino%' OR a.Apellido_paterno LIKE '%$termino%' OR a.Apellido_materno LIKE '%$termino%')";
            }
            
            // Unir las condiciones con el operador lógico AND
            $condiciones_str = implode(" AND ", $condiciones);
            
            // Construir la consulta SQL con las condiciones de búsqueda
            $sql = "SELECT a.*, v.id_vacante, p.Puesto FROM  aspirantes as a, vacantes as v, puestos as p, departamentos as dep, empresas as em WHERE  v.id_vacante = a.id_Vacante AND p.id_Puesto = v.id_Puestos AND p.id_Departamento = dep.id_Departamento AND dep.id_empresa = em.id_Empresa AND em.id_Empresa = $empresa
            AND ($condiciones_str)";
        } else {
            $sql = "SELECT a.*, v.id_vacante, p.Puesto FROM  aspirantes as a, vacantes as v, puestos as p, departamentos as dep, empresas as em WHERE  v.id_vacante = a.id_Vacante AND p.id_Puesto = v.id_Puestos AND p.id_Departamento = dep.id_Departamento AND dep.id_empresa = em.id_Empresa AND em.id_Empresa = $empresa";
        }

        $resultado = mysqli_query($conexionDB, $sql);
    ?>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Vacante</th>
                <!-- <th>No. telefono</th> -->
                <!-- <th>Status</th> -->
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php
            while ($filas = mysqli_fetch_assoc($resultado)) {
                if ($filas["Status"] == 0) {
                    continue;
                }
            ?>
                <tr>
                    <td> <?php echo $filas["id_Aspirante"]; ?></td>
                    <td> <?php echo $filas["Nombre"]; ?></td>
                    <td> <?php echo $filas["Apellido_paterno"]; ?></td>
                    <td> <?php echo $filas["Apellido_materno"]; ?></td>
                    <td> <?php echo $filas["Puesto"]; ?> </td>
                    <!-- <td> <?php
                                    // echo $filas["No_celular"]; 
                               ?>
                          </td> -->
                    <!-- <td> -->
                        <?php
                        // if ($filas["Status"] == 1) {
                        //     echo "Activo";
                        // } else {
                        //     echo "Inactivo";
                        // }


                        ?>
                    <!-- </td> -->

                    <td>
                        <li class="dropdown1">
                            <a id="acciones">Acciones<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="2 0 8 16">
                            <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z"/>
                            </svg></a>
                            <div class="dropdown_opcionesAspirantesM">
                                <form action="ExamenMedico.php" method="post"> <button type="submit"  id="btn" value="<?= $filas["id_Aspirante"] ?>" name="ID">Examen Medico</button></form>
                                <form action="historialAspirante.php" method="post"> <button type="submit"  id="btn" value="<?= $filas["id_Aspirante"] ?>" name="ID">Historial</button></form>
                            </div>
                            
                           
                                
                          
                        </li>
                        
                    </td>

                </tr>
        </tbody>
    <?php

            }

    ?>

    </table>
</body>

</html>
<?php
// }
// else{
//     header('Location: ../../index.php');
// }