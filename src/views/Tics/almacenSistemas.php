<?php
    require '../../../DB/conexionbd.php';
    session_start();

     $nombre = $_SESSION['Nombre'];

     $ID = $_SESSION['Identificador'];
     $departamento = $_SESSION['Departamento'];
     if(isset($_SESSION['Identificador'])){
    
        $empresa = $_SESSION['Empresa'];
      

        if (isset($_GET['buscar'])) {
            $buscar = $_GET['buscar'];
            
            // Dividir los términos de búsqueda en un array
            $terminos = explode(" ", $buscar);
            
            // Crear un array para almacenar las condiciones de búsqueda
            $condiciones = array();
            
            // Construir las condiciones de búsqueda
            foreach ($terminos as $termino) {
                $condiciones[] = "(he.nombre_herramienta LIKE '%$termino%' OR he.no_serie LIKE '%$termino%' OR he.tipo LIKE '%$termino%' OR he.estado LIKE '%$termino%')";
               }
            $condiciones_str = implode(" AND ", $condiciones);

            $sql = "SELECT he.* FROM herramientas as he, departamentos as dep WHERE '$empresa' = he.id_empresa AND dep.id_Departamento = he.id_departamento AND '$departamento' AND ($condiciones_str) ";
            
        }else{
            $sql = "SELECT he.* FROM herramientas as he, departamentos as dep WHERE '$empresa' = he.id_empresa AND dep.id_Departamento = he.id_departamento AND he.id_departamento = '$departamento'";
        }
           
           
            $resultado = mysqli_query($conexionDB, $sql); 


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Index</title>
    <link rel="stylesheet" href="../../../Styles/estilo2.css">
    <link rel="stylesheet" href="../../../Styles/EstilosGlobales.css">
    <link rel="shortcut icon" href="../../img/ortusLogo.png">
</head>
<body>   
    <div class="navbar">
            <img src="../../img/ortus_c.png" alt="" class="logo_imagen">
            <ul>
                    
                    <li><a href="almacenSistemas.php">Almacen de herramietas</a></li>

                    <li><a href="herramientaAsignada.php">Equipo prestado</a></li>

                    <li class="dropdown">
                        <a>Asignacion de equipo</a>
                        <div class="dropdown_Conetenido">
                            <a href="asignarUsuarios.php">Empleados</a>
                        </div>
                    </li>
                    <li class="Salir"><a class="Salir" href="../../../DB/CerrarSesion.php">Salir</a></li>
            </ul>
        </div> 
<br>
        <div class="buscar">
            <form action="" method="GET">
                <input name="buscar" id="Buscar" type="search" placeholder="buscar" >
            </form>
        </div>
       
        
        <table id="tablaVacantes">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Herramienta</th>
                <th scope="col">Numero de serie</th>
                <th scope="col">Tipo</th>
                <th  scope="col">Descripción</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($filas = mysqli_fetch_Assoc($resultado)){

                ?>
              <tr>
              <td><?php echo $filas["id_herramienta"]; ?></td>
              <td><?php echo $filas["nombre_herramienta"]; ?></td>
              <td><?php echo $filas["no_serie"]; ?></td>
              <td><?php echo $filas["tipo"]; ?></td>
              <td><?php echo $filas["descripcion"]; ?></td>
              <td><?php echo $filas["estado"]; ?></td>
              <td>

              <li class="dropdown1">
                <a id="acciones">Acciones<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="2 0 8 16">
                <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z"/>
                </svg></a>
                    <div class="dropdown_opcionesEstadoAlmacenes">
                          <a id="Estado">Cambiar estado</a>
                          <div class="dropdown_opcionesEstadoOpcionesAlmacenes">
                            <form action="../../Controllers/controladorEstadoHerramienta.php" method="post">

                                <input type="text" name="id_herramienta" value="<?=$filas["id_herramienta"]?>" hidden>

                                <button type="submit" id="btn" value="Robo" name="Estado">Robo</button>
                                <button type="submit" id="btn" value="Extravio" name="Estado">Extravio</button>
                                <button type="submit" id="btn" value="Roto" name="Estado">Roto</button>
                                <button type="submit" id="btn" value="Funcional" name="Estado">Funcional</button>
                            </form>  
                          </div>
                    </div>
              </li>

              </td>
              </tr>
              <?php
                }
              ?>
            </tbody>
        </table>
       
</body>
</html>
<?php


 }
     else{
         header('Location: ../../../index.php');
     }