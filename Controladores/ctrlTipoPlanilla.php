<?php
    session_start();
    require("../Modelo/Conect.php");  
    require("../Modelo/tipoPlanilla.php");
    require("../Modelo/anhoLectivo.php");

    $accion = "";
    $objAnho = new Anho();
    $anho = $objAnho->cargar();

    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
    }elseif(isset($_GET['accion'])){
        $accion = $_GET['accion'];
    }

    switch ($accion) {
        case 'cargar':
            $objP = new tipoPlanilla();
            $objP->anho = $anho;  
            $objP->cargar();            
        break;
        case 'guardar':
            $opcion = "";
            $objP = new tipoPlanilla();
            $objP->anho = $anho;
            $objP->tipo = $_POST['tipoPlanilla'];
            $objP->cantidad_notas = $_POST['cantidad_notas'];
            $objP->tipo_promedio = $_POST['tipo_promedio'];  
            $objP->tipo_logros = $_POST['tipo_logros'];  
            foreach ($objP->cargar() as $value) {
                $opcion = "Modificar";
            }
            
            if ($opcion == "Modificar") {
                $objP->Modificar();
            }else{
                $objP->Agregar();         
            }
            
        break;
        
        case 'Modificar':        
            $objP = new tipoPlanilla();
            $objP->Modificar($_POST['campo'],$_POST['clave'],$_POST['valor']);
        break;
            
        case 'Eliminar':
            $objP = new tipoPlanilla();
            $objP->anho = $anho;
            $objP->Eliminar();
        break;        
        default:    
        break;
    } 