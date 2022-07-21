<?php
    session_start();
    require("../Modelo/Conect.php");  
    require("../Modelo/areas.php");
    require("../Modelo/logros.php");
    require("../Modelo/criterios.php");

    $accion = "";

    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
    }elseif(isset($_GET['accion'])){
        $accion = $_GET['accion'];
    }

    switch ($accion) {
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
            $objArea = new Area();
            $objArea->curso = $_POST['curso'];
            $objArea->anho = $_POST['anho'];
            $tabla = "Asignatura";
            /*    */
            foreach ($objArea->cargarTodasLasAreas() as $value) {
                if($value['id'] == $_POST['idArea']){
                    $tabla = $value['tipo'];
                }        
            }
            $objIndicador=new Logro();
            $objIndicador->CODIND = $_POST['id'];
            $objIndicador->tabla = $tabla;
            echo json_encode($objIndicador->cargarIndicador());            
            break;
        case 'cambiarEstadoLogro':
            $objArea = new Area();
            $objArea->curso = $_POST['curso'];
            $objArea->anho = $_POST['anho'];
            $tabla = "Asignatura";
            /*    */
            foreach ($objArea->cargarTodasLasAreas() as $value) {
                if($value['id'] == $_POST['idArea']){
                    $tabla = $value['tipo'];
                }        
            }
            $objIndicador = new Logro();
            $objIndicador->estado = $_POST['estado'];
            $objIndicador->CODIND = $_POST['id']; 
            $objIndicador->tabla = $tabla;       
            $objIndicador->cambiarEstado();             
            break;
        case 'guardarLogro':
            $objArea = new Area();
            $objArea->curso = $_POST['curso'];
            $objArea->anho = $_POST['anho'];
            $tabla = "Asignatura";
            /*    */
            foreach ($objArea->cargarTodasLasAreas() as $value) {
                if($value['id'] == $_POST['area']){
                    $tabla = $value['tipo'];
                }        
            }
            $objIndicador = new Logro();
            $objIndicador->codCurso     = $_POST['curso'];
            $objIndicador->codArea  = $_POST['area'];
            $objIndicador->periodo  = $_POST['periodo'];
            $objIndicador->INDICADOR    = $_POST['indicador'];
            $objIndicador->codCriterio  = $_POST['codCriterio']; 
            $objIndicador->tabla = $tabla;
            $objIndicador->agregar();  
            var_dump($objIndicador);
            break;
        case 'eliminarIndicador':
            $objArea = new Area();
            $objArea->curso = $_POST['curso'];
            $objArea->anho = $_POST['anho'];
            $tabla = "Asignatura";
            /*    */
            foreach ($objArea->cargarTodasLasAreas() as $value) {
                if($value['id'] == $_POST['idArea']){
                    $tabla = $value['tipo'];
                }        
            }
            $objIndicador = new Logro();
            $objIndicador->CODIND = $_POST['id'];
            $objIndicador->tabla = $tabla;
            $objIndicador->eliminar();            
            break;
        case 'modificarLogro':
            $objArea = new Area();
            $objArea->curso = $_POST['curso'];
            $objArea->anho = $_POST['anho'];
            $tabla = "Asignatura";
            /*    */
            foreach ($objArea->cargarTodasLasAreas() as $value) {
                if($value['id'] == $_POST['idArea']){
                    $tabla = $value['tipo'];
                }        
            }
            $objIndicador = new Logro();
            $objIndicador->CODIND = $_POST['id'];
            $objIndicador->INDICADOR = $_POST['indicador'];
            $objIndicador->codCriterio = $_POST['codCriterio'];
            $objIndicador->tabla = $tabla;
            $objIndicador->modificar();            
            break;
        default:
            
            break;
    } 
