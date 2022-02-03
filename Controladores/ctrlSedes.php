<?php 
	session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/sede.php");
    require("../Modelo/nivel.php");
    require("../Modelo/grado.php");
    require("../Modelo/curso.php");
    require("../Modelo/Estudiante.php");
    $accion;

    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
        $objGrado = new Grado();
    }elseif(isset($_GET['accion'])){
        $accion = $_GET['accion'];
        $objGrado = new Grado();
    }

    switch ($accion) {
        case 'agregarSede':
            $objsede = new Sede();
            $objsede->CODSEDE = $_POST['codigo'];
            $objsede->NOMSEDE = $_POST['nombre'];
            $objsede->agregar();
            break;
        case 'eliminarSede':
            $objsede = new Sede();
            $objsede->CODSEDE = $_POST['codigo'];
            $objsede->eliminar();
            break;
    	case 'cargarCursos':
    		$objGrado->sede = $_POST['sede'];
    		echo json_encode($objGrado->cargarCursos());
    		break;
        case 'agregarCurso':
            $objCurso = new Curso();
            $objCurso->codSede  = $_POST['sede'];
            $objCurso->grado    = $_POST['grado'];
            $objCurso->grupo    = $_POST['grupo'];
            $objCurso->jornada  = $_POST['jornada'];
            $objCurso->agregar();
            break;
        case 'eliminarCurso':
            $objCurso = new Curso();
            $objCurso->curso  = $_POST['curso'];
            $objCurso->eliminar();
            break;
        case 'cambiarJornada':
            $objCurso = new Curso();
            $objCurso->curso  = $_POST['curso'];
            $objCurso->jornada  = $_POST['jornada'];
            $objCurso->cambiarJornada();
            break;
    	default:
    		# code...
    		break;
    }

   

?>