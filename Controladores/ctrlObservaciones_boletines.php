<?php 
    session_start();
	require("../Modelo/Conect.php");
    require("../Modelo/direccionDeCursos.php");
    require("../Modelo/Estudiante.php");
    require("../Modelo/periodos.php");
    require("../Modelo/observacionBoletin.php");

    //$_POST = json_decode(file_get_contents("php://input"), true);
    $accion = "";
    if(isset($_REQUEST['accion'])) {
    	$accion=$_REQUEST['accion'];
    }

    //echo "Accion: ".$accion;
    //var_dump($_REQUEST);
    switch ($accion) {
        case "Activar":
            if($_SESSION['rol'] == "Administrador"){
                $respuesta = array();
                $respuesta['estado'] = [true];
            }else{
                $objDireccionCurso = new DireccionCurso();
                $objDireccionCurso->codCurso=$_POST['curso'];
                //$objDireccionCurso->codProfesor = $_POST['codProfesor'];
                $objDireccionCurso->codProfesor = $_SESSION['idUsuario'];
                $objDireccionCurso->anho=$_POST['anho'];            
                $respuesta = $objDireccionCurso->verificar();
            }
            echo json_encode($respuesta);
            break;
        case 'Listar':          
            include("../vistas/observaciones/boletines/index.php");
            break;
            
          //Pendiente de poner en funcionamiento 
        case 'agregar':           
            $objObservacion = new observacionBoletin();
            $objObservacion->idMatricula=$_POST['idMatricula']; 
            $objObservacion->curso=$_POST['curso'];
            $objObservacion->periodo=$_POST['periodo'];
            $objObservacion->anho=$_POST['anho'];
            $objObservacion->observacion=$_POST['observacion'];
            $objObservacion->agregar();            
        break;
        case 'modificar':
            $objObservacion = new observacionBoletin();
            $objObservacion->id          = $_POST['id']; 
            $objObservacion->observacion = $_POST['observacion'];
            $objObservacion->modificar();            
            break;
        case 'eliminar':
            $objObservacion = new observacionBoletin();
            $objObservacion->id          = $_POST['id']; 
            $objObservacion->eliminar();             
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
    }
?>