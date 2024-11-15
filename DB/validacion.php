<?php
    // El include nos ayuda a traer la conexion a la base de datos, a esta pagina
    include ('conexionbd.php');

    session_start();

    $usuario = $_POST['Usuario'];
    $contraseña = $_POST['Contraseña'];

    $query1 = "SELECT * FROM empleados WHERE Usuario = '$usuario' AND contraseña = '$contraseña'";

    $resultado = $conexionDB -> query($query1);

    $row = $resultado -> fetch_assoc();


    if($row['Usuario'] === $usuario  &&  $row['contraseña'] === $contraseña){

    $Identificador = $_SESSION['Identificador'] = $row['id_Empleado'];

        $query2 = " SELECT em.id_Empleado, em.id_Puesto, p.id_Puesto, p.Puesto FROM empleados AS em, puestos AS p WHERE em.id_Empleado = '$Identificador' AND em.id_Puesto = p.id_Puesto AND p.Puesto = 'Gerente'";
        
        $ResPuesto = $conexionDB -> query($query2);

        $row2 = $ResPuesto -> fetch_assoc();

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


        $queryEmpresa = " SELECT emp.id_Empresa, emp.Empresa FROM empresas AS emp, Empleados AS em, puestos AS pue, departamentos AS dep WHERE em.id_Puesto = pue.id_Puesto and pue.id_Departamento = dep.id_Departamento and dep.id_empresa = emp.id_Empresa and em.id_Empleado = '$Identificador'";
        
        $ResEmp = $conexionDB -> query($queryEmpresa);

        $row3 = $ResEmp -> fetch_assoc();

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        $querydepartamentos = "SELECT em.id_Empleado, dep.id_Departamento, dep.Departamento FROM departamentos AS dep, empleados AS em WHERE dep.id_Departamento = em.id_Departamento AND em.id_Empleado = '$Identificador' AND (dep.departamento = 'Sector Salud' OR dep.departamento = 'Sistemas' OR dep.departamento = 'Taller')";
        
        $Resdep = $conexionDB -> query($querydepartamentos);

        $row4 = $Resdep -> fetch_assoc();
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        
        $_SESSION['Empresa'] = $row3['id_Empresa'];
        

        if($row['id_Puesto'] === $row2['id_Puesto']){
            $_SESSION['Nombre'] = $row['Nombre'];

            $_SESSION['IDAdmin'] = $row['id_Empleado'];

            header("location: ../src/views/administrador/indexAdmin.php");
            
        }elseif($row['id_Departamento'] == $row4['id_Departamento']){
            $_SESSION['Nombre'] = $row['Nombre'];
            $_SESSION['Identificador'] = $row['id_Empleado'];
        
            if($row4['Departamento'] == 'Sector Salud'){
                $_SESSION['Departamento'] = $row['id_Departamento'];
                header("location: ../src/views/Medico/aspirantesMedico.php");
            }elseif($row4['Departamento'] == 'Taller'){
                $_SESSION['Departamento'] = $row['id_Departamento'];
                header("location: ../src/views/Taller/almacenTaller.php");
            }elseif($row4['Departamento'] == 'Sistemas'){
                $_SESSION['Departamento'] = $row['id_Departamento'];
                header("location: ../src/views/Tics/almacenSistemas.php");
            }
        }else{
            $_SESSION['Nombre'] = $row['Nombre'];
            $_SESSION['Identificador'] = $row['id_Empleado'];
            
            header("location: ../src/views/indexEmpleado.php");
        }

    }
    else {
        header("location: ../index.php");
    }
    //Esta seria la consulta que necesito para sacar la validacion de la empreza:  SELECT e.Usuario, em.Empresa FROM empleados as e, departamentos as d, empresas as em WHERE e.id_Departamento = d.id_Departamento and d.id_empresa = em.id_Empresa and e.id_Empleado = '2'; 
?>


