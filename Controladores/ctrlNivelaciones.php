<?php
    session_start();
    require("../Modelo/Conect.php");  
    require("../Modelo/nivelacion.php");

    $accion = "";

    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
    }elseif(isset($_GET['accion'])){
        $accion = $_GET['accion'];
    }

    switch ($accion) {
        case 'cargar':
            $des=new Desempenos();
            $des->nota = $_POST['nota'];
            echo $des->cargar();             
            break;

        case 'listaEstudiantes':
             $obj = new Nivelacion();
             $obj->curso = $_POST['curso'];
             $obj->Anho = $_POST['anho'];
             $obj->codArea = $_POST['codArea'];
             include("../vistas/calificar/planillaNivelacion.php");
            break;
            
        case 'listaObservaciones':
             $curso=$_POST['curso'];
             $periodo=$_POST['periodo'];
             $anho=$_POST['anho'];
             $inst=$_POST['inst'];
             $usuario=$_POST['usuario'];
             $planilla=new Observaciones();
             $planilla->cargar($curso,$periodo,$anho,$inst,$usuario);              
            break;
        case 'agregar':
            $obj = new Nivelacion();
            $obj->Anho = $_POST['anho'];
            $obj->idMatricula = $_POST['idMatricula'];
            $obj->codArea = $_POST['codArea'];
            $obj->curso = $_POST['curso'];
            $obj->NOTA = $_POST['nota'];
            $obj->numActa = $_POST['numActa'];
            $obj->mesActa = $_POST['mesActa'];
            $obj->diaActa = $_POST['diaActa'];
            $obj->observacion = $_POST['observacion'];
            echo $obj->agregar();            
            break;
        case 'modificarNota':
            $planilla = new Calificacion();
            $planilla->Anho = $_POST['anho'];
            $planilla->periodo = $_POST['periodo'];
            $planilla->idMatricula = $_POST['idMatricula'];
            $planilla->codArea = $_POST['area'];
            $planilla->curso = $_POST['curso'];
            $planilla->nota = $_POST['nota'];
            $planilla->modificar();            
            break;
        case 'eliminarNota':
            $planilla = new Calificacion();
            $planilla->Anho = $_POST['anho'];
            $planilla->periodo = $_POST['periodo'];
            $planilla->idMatricula = $_POST['idMatricula'];
            $planilla->codArea = $_POST['area'];
            $planilla->curso = $_POST['curso'];     
            echo $planilla->eliminar();           
            break;
        case 'modificarFalta':
            $objPlanilla = new Calificacion();
            $objPlanilla->Anho = $_POST['anho'];
            $objPlanilla->periodo = $_POST['periodo'];
            $objPlanilla->idMatricula = $_POST['idMatricula'];
            $objPlanilla->codArea = $_POST['area'];
            $objPlanilla->curso = $_POST['curso'];
            $objPlanilla->faltas = $_POST['falta'];
            $objPlanilla->modificarInasistencias();            
            break;

        case 'agregarNotaCriterio':
            $planilla = new Calificacion();
            $planilla->Anho = $_POST['anho'];
            $planilla->periodo = $_POST['periodo'];
            $planilla->idMatricula = $_POST['idMatricula'];
            $planilla->codArea = $_POST['area'];
            $planilla->curso = $_POST['curso'];
            $planilla->nota = $_POST['nota'];
            $planilla->idCriterio = $_POST['criterio'];
            $planilla->tabla = $_POST['tabla'];
            $planilla -> agregarNotaCriterio();            
            break;   


        case 'definitivaCriterios':
            $planilla = new Calificacion();
            $planilla->Anho = $_POST['anho'];
            $planilla->periodo = $_POST['periodo'];
            $planilla->idMatricula = $_POST['idMatricula'];
            $planilla->codArea = $_POST['area'];
            $planilla->curso = $_POST['curso'];
            $planilla->nota = $_POST['nota'];
            $planilla->idCriterio = $_POST['criterio'];
            $planilla->tabla = $_POST['tabla'];
            echo $planilla -> definitivaCriterios();            
            break;     
        case 'guardarDefinitiva':
            $tabla = $_POST['tabla'];
            $notaExiste = false;
            $objCalificacion = new Calificacion();
            $objCalificacion->idMatricula = $_POST['idMatricula'];
            $objCalificacion->Anho = $_POST['anho'];
            $objCalificacion->periodo = $_POST['periodo'];
            $objCalificacion->curso = $_POST['curso'];
            $objCalificacion->nota = $_POST['nota'];
            $objCalificacion->desempeno = "-";
            $objCalificacion->faltas = $_POST['faltas'];
            if ($tabla == "Area") {
                $objCalificacion->codArea = $_POST['area'];
                foreach ($objCalificacion->cargar() as $value) {
                    $notaExiste = true;
                }

                if(!$notaExiste){
                    $objCalificacion->agregar();
                }else{
                    $objCalificacion->modificar();
                }
            }elseif($tabla == "Asignatura"){
                $objCalificacion->idAsignatura = $_POST['area'];
                foreach ($objCalificacion->notaAsignatura() as $value) {
                    $notaExiste = true;
                }

                if(!$notaExiste){
                    $objCalificacion->agregarNotaAsignatura();
                }else{
                    $objCalificacion->modificarNotaAsignatura();
                }
            }
        break;
        
        default:
            
            break;
    } 