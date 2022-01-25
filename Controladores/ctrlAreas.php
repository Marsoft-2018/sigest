<?php 
    session_start();
	require("../Modelo/Conect.php");
    require("../Modelo/areas.php");
    require("../Modelo/asignatura.php");
    //$_POST = json_decode(file_get_contents("php://input"), true);
    $accion = "";
    if(isset($_POST['accion'])) {
    	$accion=$_POST['accion'];
    }

    //echo "Accion: ".$accion;
    
    switch ($accion) {
    	case 'CargarTodasLasAreas':    		
	        $objArea = new Area();
	        $objArea->curso = $_POST['curso'];
	        $objArea->anho = $_POST['anho'];
	        $data = $objArea->cargarTodasLasAreas();
	        echo json_encode($data, true);
	        //echo $data;
	        

    	break;
		case "cargarAreasCursoProfesor":
			$curso = $_POST['curso'];
	        $profesor = $_POST['profesor'];
	        $planilla = new Planilla();
	        $planilla->cargarAreasCursoProfesor($curso,$profesor);
		break;
        case 'agregarArea':
            $objAxS = new Area();        
            $objAxS->codSede   = $_POST['sede'];
            $objAxS->abreviatura = $_POST['abreviatura'];
            $objAxS->nombre  = $_POST['nombre'];
            $objAxS->anho = $_POST['anho'];
            $objAxS->formaDePromediar = "IH";
            $objAxS->agregar();
        break;
        case 'modificaArea': 
            $grado=$_POST['campo']; 
            $clave=$_POST['clave'];
            $ih=$_POST['valor'];
            $objAxS=new areasSedes();
            $objAxS->modificarArea($clave,$ih,$grado); 
            break;
        case 'eliminarAreaAsignatura':        
            $tabla=$_POST['tabla'];
            $objA = new Area();
            if ($tabla != 1) {
                $objA = new Asignatura();
            }
            $objA->id = $_POST['idArea'];
            $objA->anho = $_POST['anho'];
            $objA->eliminar();
        break;
        
        case 'CargarAsignaturas':         
            $objA = new Asignatura();
            $objA->idArea = $_POST['idArea'];
            $data = $objA->listar();
            echo json_encode($data, true);
        break;
        
        case 'agregarAsignatura':
            $objA = new Asignatura();        
            $objA->idArea   = $_POST['idArea'];
            $objA->abreviatura = $_POST['abreviatura'];
            $objA->nombre  = $_POST['nombre'];
            $objA->porcentaje = 0;
            $objA->agregar();
        break;
        case 'modificaAsignatura': 
            $objA   = new Asignatura();
            $objA->id  = $_POST['id'];
            $objA->nombre  = $_POST['nombre']; 
            $objA->abreviatura  = $_POST['abreviatura'];
            $objA->porcentaje  = $_POST['porcentaje'];
            $objA->modificar();
        break;
        case 'eliminarAsignatura':        
            $sede=$_POST['sede'];
            $idAsig=$_POST['idAsignatura']; 
            $idArea=$_POST['idArea'];
            $objAxS=new areasSedes();
            $objAxS->EliminarAsignatura($idAsig,$idArea);      
            $objAxS->cargar($sede);
        break;
        case 'agregarIntensidad':
            $tabla=$_POST['tabla'];

            if ($tabla == 1) {
                $objA = new Area();                
            }elseif($tabla == 2){
                $objA = new Asignatura();
            }

            $objA->id = $_POST['idArea'];
            $objA->idGrado = $_POST['grado'];
            $objA->intensidad = $_POST['horas'];
            $objA->addIntensidad();
            break;
        case 'modificarIntensidad':        
            $tabla=$_POST['tabla'];

            if ($tabla == 1) {
                $objA = new Area();                
            }elseif($tabla == 2){
                $objA = new Asignatura();
            }

            $objA->id = $_POST['idArea'];
            $objA->idGrado = $_POST['grado'];
            $objA->intensidad = $_POST['horas'];
            $objA->setIntensidad();
        break;
        case 'modificarTipoPromedio': 
            $objA = new Area();
            $objA->id = $_POST['idArea'];
            $objA->formadepromediar = $_POST['tipo'];
            $objA->setTipoPromedio();
        break;
    	
    	default:
    		# code...
    		break;
    }
?>