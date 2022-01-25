<?php
    session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/excepcionesPeriodos.php");
    $accion;
    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
    }elseif(isset($_GET['accion'])){
        $accion = $_GET['accion'];
    }

    switch ($accion) {
        case 'guardar':
            $obj = new excepcionPeriodo();
            $obj->periodo = $_POST['periodo'];
            $obj->idUsuario = $_POST['idUsuario'];
            $obj->fechaInicio = $_POST['fechaInicio'];
            $obj->fechaCierre = $_POST['fechaCierre']; 
            $obj->anho =  $_POST['anho'];
            $obj->Guardar();            
            break;
        case 'modificar':
            $obj = new excepcionPeriodo();
            $obj->periodo = $_POST['periodo'];
            $obj->idUsuario = $_POST['idUsuario'];
            $obj->fechaInicio = $_POST['fechaInicio'];
            $obj->fechaCierre = $_POST['fechaCierre']; 
            $obj->anho =  $_POST['anho'];
            $obj->Modificar(); 
            break; 
        case 'eliminar':
            $obj = new excepcionPeriodo();
            $obj->periodo = $_POST['periodo'];
            $obj->idUsuario = $_POST['idUsuario'];
            $obj->anho =  $_POST['anho'];
            $obj->Eliminar();             
            break;
        default:
            # code...
            break;
    }    
?>