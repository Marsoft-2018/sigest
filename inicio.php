<?php 
  session_start();

  if (!isset($_SESSION['idUsuario'])) {
    header("Location: /sigest/index.php");
  }else{
    switch ($_SESSION['rol']) {
      case 'Administrador':
        include("Administrar.php");
        break;
      case 'Coordinador':
        include("mnuCoordinador.php");
        break;
      case 'Profesor':
        include("mnuProfesores.php");
        //include("vistas/paginaMantenimiento.php");
        break;
      case 'Estudiante':
        include("mnuEstudiantes.php");
        break;
      default:
        # code...
        break;
    }
  }
 ?>