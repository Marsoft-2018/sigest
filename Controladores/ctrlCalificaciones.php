<?php
    session_start();
    require("../Modelo/Conect.php");  
    require("../Modelo/Calificacion.php");
    require("../Modelo/desempenhos.php");  
    require("../Modelo/periodos.php");
    require("../Modelo/areas.php");
    require("../Modelo/logros.php");
    require("../Modelo/Estudiante.php");
    require("../Modelo/criterios.php");
    require("../Modelo/curso.php");

    $accion = "";

    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
    }elseif(isset($_GET['accion'])){
        $accion = $_GET['accion'];
    }

    switch ($accion) {
        case 'Desempeno':
            $des=new Desempenos();
            $des->nota = $_POST['nota'];
            $des = $des->cargar();   
            $grado = $_POST['grado']; 
            ?>
            <div class="marcoDesempeno <?php echo $des; ?>" <?php if($grado <= 0){echo "style='font-size:0.8em;'"; } ?>
                class="form form-control" >
                <?php echo $des; ?>
            </div>
            <div <?php if($grado >0){echo "style='display:none;'"; } ?>>
                <?php if($des != ""){ ?>
                <img src="vistas/img/desempenos/<?php echo $des.".png";?>" alt="<?php echo $des.".png";?>" style="width: 30px;">
                <?php }?>
            </div>
            <?php         
            break;

        case 'lista':
             $curso=$_POST['curso'];
             $area=$_POST['codArea'];
             $periodo=$_POST['periodo'];
             $anho=$_POST['anho'];
             $inst=$_POST['inst'];
             $tipoUsuario=$_POST['tipoUsuario'];
             $planilla=new Planilla();
             $planilla->cargar($curso,$area,$periodo,$anho,$inst,$tipoUsuario);                   
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
        case 'CargarTodasLasAreas':
            $curso=$_POST['curso'];
            $planilla=new Planilla();
            $planilla->cargarTodasLasAreas($curso);            
            break;
        case 'cargarAreasCursoProfesor':
            $curso = $_POST['curso'];
            $profesor = $_POST['profesor'];
            $planilla = new Planilla();
            $planilla->cargarAreasCursoProfesor($curso,$profesor);             
            break;
        case 'listaCertificado':
            $curso  =   $_POST['curso'];
            $sede   =   $_POST['sede'];
            $anho   =   $_POST['anho'];
            $inst   =   $_POST['inst'];
            $planilla = new Constancia();
            $planilla->cargarLista($curso,$anho,$inst,$sede);             
            break;
        case 'ValidarPeriodo':
            $verificacion = new Periodo();
            $verificacion->periodo =  $_POST['periodo'];
            $verificacion->anho = $_POST['anho'];       
            echo json_encode( $verificacion->ValidarPeriodo());            
            break;
        case 'agregarNota':
            $planilla = new Calificacion();
            $planilla->Anho = $_POST['anho'];
            $planilla->periodo = $_POST['periodo'];
            $planilla->idMatricula = $_POST['idMatricula'];
            $planilla->codArea = $_POST['area'];
            $planilla->curso = $_POST['curso'];
            $planilla->nota = $_POST['nota'];
            $planilla->desempeno = "-";
            $planilla->faltas = $_POST['faltas'];
            $planilla -> agregar();            
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

        case 'modificarNotaCriterio':            
            $objCalificacion = new Calificacion();
            $objCalificacion->idMatricula = $_POST['idMatricula'];
            $objCalificacion->Anho = $_POST['anho'];
            $objCalificacion->periodo = $_POST['periodo'];
            $objCalificacion->curso = $_POST['curso'];
            $objCalificacion->nota = $_POST['nota'];
            $objCalificacion->codArea = $_POST['area'];
            $objCalificacion->idCriterio = $_POST['criterio'];
            $objCalificacion->tabla = $_POST['tabla'];
            $objCalificacion->modificarNotaCriterio();
        break;
           //Pendiente de poner en funcionamiento 
        case 'agregarObservacion':
            $estudiante=$_POST['estudiante']; 
            $curso=$_POST['curso'];
            $periodo=$_POST['periodo'];
            $anho=$_POST['anho'];
            $observacion=$_POST['observacion'];
            $inst=$_POST['inst'];
            
            $planilla=new Observaciones();
            $planilla->agregar($estudiante,$curso,$periodo,$anho,$observacion,$inst);            
            break;
        case 'modificarObservacion':
            $estudiante=$_POST['estudiante']; 
            $curso=$_POST['curso'];
            $periodo=$_POST['periodo'];
            $anho=$_POST['anho'];
            $observacion=$_POST['observacion'];
            $inst=$_POST['inst'];
            
            $planilla=new Observaciones();
            $planilla->modificar($estudiante,$curso,$periodo,$anho,$observacion,$inst);            
            break;
        case 'eliminarObservacion':
            $estudiante=$_POST['estudiante'];
            $idObservacion=$_POST['idObservacion'];        
            $planilla=new Observaciones();
            $planilla->eliminar($estudiante,$idObservacion);            
            break;
        case 'agregarNotaAsignatura':
            $estudiante=$_POST['estudiante']; 
            $curso=$_POST['curso'];
            $area=$_POST['area'];
            $periodo=$_POST['periodo'];
            $anho=$_POST['anho'];
            $nota=$_POST['nota'];
            $inasistencia = $_POST['faltas'];
            $inst=$_POST['inst'];
            
            $planilla=new calificar();
            $planilla->agregarNotaAsignatura($estudiante,$curso,$area,$periodo,$anho,$nota,$inst,$inasistencia);            
            break;
        case 'modificarNotaAsignatura':
            $estudiante=$_POST['estudiante']; 
            $curso=$_POST['curso'];
            $area=$_POST['area'];
            $periodo=$_POST['periodo'];
            $anho=$_POST['anho'];
            $nota=$_POST['nota'];
            $inst=$_POST['inst'];
            
            $planilla=new calificar();
            $planilla->modificarNotaAsignatura($estudiante,$curso,$area,$periodo,$anho,$nota,$inst);          
            break;
        case 'modificarFaltaAsignatura':
            $estudiante=$_POST['estudiante']; 
            $curso=$_POST['curso'];
            $area=$_POST['area'];
            $periodo=$_POST['periodo'];
            $anho=$_POST['anho'];
            $falta=$_POST['falta'];
            $inst=$_POST['inst'];
            
            $planilla=new calificar();
            $planilla->modificarFaltaAsignatura($estudiante,$curso,$area,$periodo,$anho,$falta,$inst);        
            break;
        case 'modificarObservacionAsignatura':
            $estudiante=$_POST['estudiante']; 
            $curso=$_POST['curso'];
            $area=$_POST['area'];
            $periodo=$_POST['periodo'];
            $anho=$_POST['anho'];
            $observacion=$_POST['observacion'];
            $inst=$_POST['inst'];
            
            $planilla=new calificar();
            $planilla->modificarObservacionAsignatura($estudiante,$curso,$area,$periodo,$anho,$observacion,$inst);            
            break;
        case 'cargarLogro':
            $objLogros = new Logro();
            $objLogros->periodo = $_POST['periodo'];
            $objLogros->codCurso = $_POST['curso'];
            $objLogros->codArea = $_POST['area'];
            $objLogros->calificacion = $_POST['nota'];
            $objLogros->cargar();            
            break;
        case 'cargarListadoLogro':
            $curso        = $_POST['curso'];
            $area         = $_POST['area'];
            $periodo      = $_POST['periodo'];
            $objIndicador = new Logro();
            $objIndicador->cargarLista($periodo,$area,$inst,$curso);            
            break;
        case 'cargarNuevo':
            $indicador=new Logro();
            $tabla=$_POST['tabla'];
            $inst=$_POST['inst'];
            $indicador->nuevo($inst,$tabla);            
            break;
        case 'cargarEdicionLogro':
            $indicador=new Logro();
            $indicador->CODIND = $_POST['id'];
            echo json_encode($indicador->cargarIndicador());            
            break;
        case 'cambiarEstadoLogro':
            $objindicador = new Logro();
            $objindicador->estado = $_POST['estado'];
            $objindicador->CODIND = $_POST['id'];        
            $objindicador->cambiarEstado();             
            break;
        case 'guardarLogro':
            $objIndicador = new Logro();
            $objIndicador->codCurso     = $_POST['curso'];
            $objIndicador->codArea  = $_POST['area'];
            $objIndicador->periodo  = $_POST['periodo'];
            $objIndicador->INDICADOR    = $_POST['indicador'];
            $objIndicador->codCriterio  = $_POST['codCriterio']; 
            $objIndicador->agregar();            
            break;
        case 'eliminarIndicador':
            $objindicador = new Logro();
            $objindicador->CODIND = $_POST['id'];
            $objindicador->eliminar();            
            break;
        case 'modificarLogro':
            $objindicador = new Logro();
            $objindicador->CODIND = $_POST['id'];
            $objindicador->INDICADOR = $_POST['indicador'];
            $objindicador->codCriterio = $_POST['codCriterio'];
            $objindicador->modificar();            
            break;
        case 'listaFaltas':
            $curso=$_POST['curso'];
            $area=$_POST['codArea'];
            $periodo=$_POST['periodo'];
            $mes=$_POST['mes'];
            $anho=$_POST['anho'];
            $inst=$_POST['inst'];
            $planilla=new planillaDeFaltas();
            $planilla->cargar($curso,$area,$periodo,$mes,$anho,$inst);            
            break;
        case 'ponerFalta':
            $estudiante=$_POST['estudiante'];
            $mes=$_POST['mes'];
            $anho=$_POST['anho'];
            $dia=$_POST['dia'];
            $area=$_POST['codArea'];
            $periodo=$_POST['periodo'];
            $planilla=new planillaDeFaltas();
            $planilla->ponerFalta($estudiante,$dia,$mes,$anho,$periodo,$area);            
            break;
        case 'quitarFalta':
            $estudiante=$_POST['estudiante'];
            $mes=$_POST['mes'];
            $anho=$_POST['anho'];
            $dia=$_POST['dia'];
            $area=$_POST['codArea'];
            $periodo=$_POST['periodo'];
            $planilla= new planillaDeFaltas();
            $planilla->quitarFalta($estudiante,$dia,$mes,$anho,$periodo,$area);            
            break;
        case 'verPlanillaIndividual':
            include_once("../vistas/calificar/planilla_individual/index.php");
            break;
        default:
            
            break;
    } 