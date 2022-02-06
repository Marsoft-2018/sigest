<?php
    require("../Modelo/Conect.php");
    require("../Modelo/nivel.php");
    $accion = "";
    if(isset($_REQUEST['accion'])){ $accion = $_REQUEST['accion']; }
    
    switch ($accion) {
        case 'nuevo': case 'editar':
            include_once("../vistas/ajustes/niveles/formulario.php");            
            break;
        
        case 'agregar':
            //echo var_dump($_REQUEST);
            $objNivel = new Nivel();
            $objNivel->CODNIVEL = $_POST['CODNIVEL'];
            $objNivel->NOMBRE_NIVEL = $_POST['NOMBRE_NIVEL'];
            $objNivel->orden = $_POST["orden"];
            $objNivel->agregar();
            break;

        case 'cargar':
            $objNivel = new Nivel();
            $objNivel->CODNIVEL = $_POST['CODNIVEL'];
            echo json_encode($objNivel->cargar());            
            break;
        case 'mostrar':
            include_once("../vistas/ajustes/niveles/listado.php");            
            break;
        case 'modificar':
            //echo var_dump($_REQUEST);
            $objNivel = new Nivel();
            $objCodigoAnterior = $_POST['id'];
            $objNivel->CODNIVEL = $_POST['CODNIVEL'];
            $objNivel->NOMBRE_NIVEL = $_POST['NOMBRE_NIVEL'];
            $objNivel->orden = $_POST["orden"];
            $objNivel->modificar();    
            break;

        case 'listar':
            $objNivel = new Nivel();
            echo json_encode($objNivel->listar());
            break;
                
        case 'eliminar':
            $objNivel = new Nivel();
            $objNivel->CODNIVEL = $_POST['CODNIVEL'];
            $objNivel->eliminar();
            break;
    }

?>