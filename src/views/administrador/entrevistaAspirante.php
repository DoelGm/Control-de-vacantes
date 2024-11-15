<?php
require '../../../DB/conexionbd.php';

    session_start();

    $nombre = $_SESSION['Nombre'];

    $ID = $_SESSION['IDAdmin'];

    if(isset($_SESSION['IDAdmin'])){

        $ID_aspirante = $_POST["ID"];
        $sql = "SELECT a.* ,v.id_vacante, p.Puesto FROM aspirantes as a, vacantes as v, puestos as p WHERE  v.id_vacante = a.id_Vacante AND p.id_Puesto = v.id_Puestos AND a.id_Aspirante = '$ID_aspirante' "; 
        // consulta a la base de datos

          $resultado = mysqli_query($conexionDB, $sql);
          $consulta = mysqli_fetch_assoc($resultado);
      ?>
      
      <!DOCTYPE html>
      <html lang="es">
      <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Entrevista aspirante</title>
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

          <div class="Encabezado">
              <h1>Entrevistas aspirantes</h1>
          </div>
      
          <div class="contenedor1">
              <div class="formularioEntrevista">
                  <form action="../../Controllers/controladorEntrevista.php" method="POST" enctype="multipart/form-data">
                      <div class="datoDeEntrevista">
                          <label for="nombre">Nombre: </label>
                          <input id="nombre" name="nombre" value="<?= $consulta["Nombre"]." ".$consulta["Apellido_paterno"]." ".$consulta["Apellido_materno"]?>" type="text" readonly>
      
                          <label for="Vacante">Vacante: </label>
                          <input id="Vacante" name="Vacante" value="<?= $consulta["Puesto"]?>" type="text" readonly>
                        <!--                           
                          <label for="FechaDeEntrevista">Fecha de Entrevista:</label>
                          <input style="background: rgb(255, 255, 255);" type="date" required name="FechaDeEntrevista" id="FechaDeEntrevista">
                            -->
                          <label for="Comentarios">Comentarios:</label>
                          <textarea name="comentario" placeholder="Ingrese Comentarios" id="Comentario" cols="72" required rows="10"></textarea>
      
                          
                          <label for="Archivo">Archivos:</label>
                          <input style="background: rgb(255, 255, 255);" type="file" id="Archivo" name="Archivo" accept=".pdf, .jpg, .png" multiple>
                         
                          
                      </div>
                      <button class="BTN_Envia1" value="<?= $consulta["id_Aspirante"]?>" name="ID" type="submit">Guardar</button>
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