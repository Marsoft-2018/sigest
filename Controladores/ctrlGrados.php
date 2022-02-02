<?php
    require("../Modelo/Conect.php");
    require("../Modelo/nivel.php");
    require("../Modelo/grado.php");
    $accion = "";
    if(isset($_REQUEST['accion'])){ $accion = $_REQUEST['accion']; }
    
    switch ($accion) {
        case 'nuevo': case 'editar':
            include_once("../vistas/ajustes/grados/formulario.php");            
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