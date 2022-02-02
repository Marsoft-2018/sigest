<?php
    require("../Modelo/Conect.php");
    require("../Modelo/nivel.php");
    $accion = "";
    if(isset($_REQUEST['accion'])){ $accion = $_REQUEST['accion']; }
    
    switch ($accion) {
        case 'nuevo':
            include_once("../vistas/ajustes/niveles/formulario.php");            
            break;

        case 'agregar':
            
            break;

        case 'cargar':
            
            break;

        case 'editar':
            
            break;

        case 'modificar':
                
            break;


        case 'listar':
            
            break;

        case 'eliminar':
            
            break;

        default:
            # code...
            break;
    }

?>