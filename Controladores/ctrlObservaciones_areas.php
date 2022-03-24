<?php 
session_start();
	require("../modelo/Conect.php");
    require("../modelo/observacionArea.php");
    //$_POST = json_decode(file_get_contents("php://input"), true);
    $accion = "";
    if(isset($_POST['accion'])) {
    	$accion=$_POST['accion'];
    }

    //echo "Accion: ".$accion;
    
    switch ($accion) {
          //Pendiente de poner en funcionamiento 
          case 'agregar':
            $estudiante=$_POST['estudiante']; 
            $curso=$_POST['curso'];
            $periodo=$_POST['periodo'];
            $anho=$_POST['anho'];
            $observacion=$_POST['observacion'];
            $inst=$_POST['inst'];
            
            $planilla=new observacionArea();
            $planilla->agregar();            
            break;
        case 'modificar':
            $estudiante=$_POST['estudiante']; 
            $curso=$_POST['curso'];
            $periodo=$_POST['periodo'];
            $anho=$_POST['anho'];
            $observacion=$_POST['observacion'];
            $inst=$_POST['inst'];
            
            $planilla=new Observaciones();
            $planilla->modificar($estudiante,$curso,$periodo,$anho,$observacion,$inst);            
            break;
        case 'eliminar':
            $estudiante=$_POST['estudiante'];
            $idObservacion=$_POST['idObservacion'];        
            $planilla=new Observaciones();
            $planilla->eliminar($estudiante,$idObservacion);            
            break;

    	case 'cargarObservacionArea':    		
	        $objObservacion = new observacionArea();
	        $objObservacion->curso = $_POST['curso'];
	        $objObservacion->anho = $_POST['anho'];
            $objObservacion->periodo = $_POST['periodo'];
            $objObservacion->idMatricula = $_POST['idMatricula'];
            $objObservacion->idArea = $_POST['idArea'];
            $data = $objObservacion->cargar();
    		break;
    	case "agregarObservacionArea":
			$objObservacion = new observacionArea();
            $objObservacion->curso = $_POST['curso'];
            $objObservacion->anho = $_POST['anho'];
            $objObservacion->periodo = $_POST['periodo'];
            $objObservacion->idMatricula = $_POST['idMatricula'];
            $objObservacion->idArea = $_POST['idArea'];
            $objObservacion->asistencia = $_POST['asistencia'];
            $objObservacion->cumplimiento = $_POST['cumplimiento'];
            $objObservacion->observacion = $_POST['observacion'];
            $data = $objObservacion->agregar();
    		break;
        case 'modificarObservacionArea':
            $objObservacion = new observacionArea();
            $objObservacion->id = $_POST['id'];
            $objObservacion->asistencia = $_POST['asistencia'];
            $objObservacion->cumplimiento = $_POST['cumplimiento'];
            $objObservacion->observacion = $_POST['observacion'];
            $data = $objObservacion->modificar();
            break;
        case 'eliminarObservacionArea':
            $objObservacion = new observacionArea();
            $objObservacion->id = $_POST['id'];
            $data = $objObservacion->eliminar();
            break;
    	case 'listarObservacionArea':          
            $objObservacion = new observacionArea();
            $objObservacion->curso = $_POST['curso'];
            $objObservacion->anho = $_POST['anho'];
            $objObservacion->periodo = $_POST['periodo'];
            $objObservacion->idArea = $_POST['idArea'];
            $data = $objObservacion->cargar();
            break;
    	default:
    		# code...
    		break;
    }
?>