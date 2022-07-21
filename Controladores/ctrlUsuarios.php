<?php 
	session_start();
    
	include ("encript.php");
	require_once ("../Modelo/Conect.php");
	require_once '../Modelo/usuario.php';
    
    $accion = "";
    if(isset($_REQUEST['accion'])){ $accion = $_REQUEST['accion']; }
    
    switch ($accion) {
        case 'nuevo': case 'editar':
            include_once("../vistas/ajustes/Usuarios/formulario.php");            
            break;
        
        case 'agregar':
            //echo var_dump($_REQUEST);
            $objUsuario = new Usuario();
            $objUsuario->CODNIVEL = $_POST['CODNIVEL'];
            $objUsuario->CODUsuario = $_POST['CODUsuario'];
            $objUsuario->NOMUsuario = $_POST["NOMUsuario"];
            $objUsuario->nomCampo = $_POST["nomCampo"];
            $objUsuario->estiloDesempeno = $_POST["estiloDesempeno"];
            $objUsuario->agregar();
            break;

        case 'cargar':            
            $objUsuario = new Usuario();
            $objUsuario->CODUsuario = $_POST['IDUsuario'];
            echo json_encode($objUsuario->cargar());            
            break;
        case 'mostrar':
            include_once("../vistas/ajustes/Usuarios/listado.php");            
            break;
        case 'modificar':
            //echo var_dump($_REQUEST);
            $objUsuario = new Usuario();
            $objCodigoAnterior = $_POST['id'];
            $objUsuario->CODNIVEL = $_POST['CODNIVEL'];
            $objUsuario->CODUsuario = $_POST['CODUsuario'];
            $objUsuario->NOMUsuario = $_POST["NOMUsuario"];
            $objUsuario->nomCampo = $_POST["nomCampo"];
            $objUsuario->estiloDesempeno = $_POST["estiloDesempeno"];
            $objUsuario->modificar();    
            break;

        case 'listar':
            $objUsuario = new Usuario();
            echo json_encode($objUsuario->listar());
            break;

        case 'encriptacionMasiva':
            $objUsuario = new Usuario();
            $objUsuario->encriptacionMasiva($_REQUEST['tabla']);
            break;
    
        case 'eliminar':
            $objUsuario = new Usuario();
            $objUsuario->IDUsuario = $_POST['IDUsuario'];
            $objUsuario->eliminar();
            break;

        default:
            # code...
            break;
    }

?>