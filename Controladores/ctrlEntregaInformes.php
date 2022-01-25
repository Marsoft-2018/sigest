<?php
    session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/entregaDeInformesPeriodo.php");
    $accion;
    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
    }elseif(isset($_GET['accion'])){
        $accion = $_GET['accion'];
    }

    switch ($accion) {
        case 'Agregar':
            $obj = new entregaDeInformesPeriodo();
            $obj->periodo = $_POST['periodo'];
            $obj->curso = $_POST['curso'];
            $obj->fecha = $_POST['fecha'];
            $obj->anho =  $_POST['anho'];
            $obj->Guardar();            
            break;
        case 'modificar':
            $obj = new entregaDeInformesPeriodo();
            $obj->periodo = $_POST['periodo'];
            $obj->curso = $_POST['curso'];
            $obj->fecha = $_POST['fecha'];
            $obj->anho =  $_POST['anho'];
            $obj->Modificar(); 
            break; 
        case 'eliminar':
            $obj = new entregaDeInformesPeriodo();
            $obj->periodo = $_POST['periodo'];
            $obj->curso = $_POST['curso'];
            $obj->anho =  $_POST['anho'];
            $obj->Eliminar();             
            break; 
        case 'activarEstudiantes':
            $obj = new entregaDeInformesPeriodo();
            $obj->id = $_POST['idEntrega'];
            $obj->idMatricula = $_POST['estudiante'];
            $obj->estado = $_POST['estado'];
            $obj->habilitarEstudiante();             
            break;
        case 'FechaTodos':
            require("../Modelo/curso.php");
            $objCurso = new Curso();
            $objCurso->codSede = $_POST['sede'];
            foreach ($objCurso->listaXsedes() as $value) {
                $obj = new entregaDeInformesPeriodo();
                $obj->periodo = $_POST['periodo'];
                $obj->curso = $value['codCurso'];
                $obj->fecha = $_POST['fecha'];
                $obj->anho =  $_POST['anho'];
                $obj->Guardar(); 
            }           
            break;
        default:
            # code...
            break;
    }    
?>