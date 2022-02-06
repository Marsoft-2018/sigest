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
            //echo var_dump($_REQUEST);
            $objGrado = new Grado();
            $objGrado->CODNIVEL = $_POST['CODNIVEL'];
            $objGrado->CODGRADO = $_POST['CODGRADO'];
            $objGrado->NOMGRADO = $_POST["NOMGRADO"];
            $objGrado->nomCampo = $_POST["nomCampo"];
            $objGrado->estiloDesempeno = $_POST["estiloDesempeno"];
            $objGrado->agregar();
            break;

        case 'cargar':
            $objGrado = new Grado();
            $objGrado->CODGRADO = $_POST['CODGRADO'];
            echo json_encode($objGrado->cargar());            
            break;
        case 'mostrar':
            include_once("../vistas/ajustes/grados/listado.php");            
            break;
        case 'modificar':
            //echo var_dump($_REQUEST);
            $objGrado = new Grado();
            $objCodigoAnterior = $_POST['id'];
            $objGrado->CODNIVEL = $_POST['CODNIVEL'];
            $objGrado->CODGRADO = $_POST['CODGRADO'];
            $objGrado->NOMGRADO = $_POST["NOMGRADO"];
            $objGrado->nomCampo = $_POST["nomCampo"];
            $objGrado->estiloDesempeno = $_POST["estiloDesempeno"];
            $objGrado->modificar();    
            break;

        case 'listar':
            $objGrado = new Grado();
            echo json_encode($objGrado->listar());
            break;

        case 'listarPorNivel':
            $objGrado = new Grado();
            $objGrado->CODNIVEL = $_POST['CODNIVEL'];
            echo json_encode($objGrado->listarPorNivel());
            break;
    
        case 'eliminar':
            $objGrado = new Grado();
            $objGrado->CODGRADO = $_POST['CODGRADO'];
            $objGrado->eliminar();
            break;

        default:
            # code...
            break;
    }

?>