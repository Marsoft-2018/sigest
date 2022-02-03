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
            echo var_dump($_REQUEST);
            $objGrado = new Grado();
            $objGrado->CODNIVEL = $_POST['CODNIVEL'];
            $objGrado->CODGRADO = $_POST['CODGRADO'];
            $objGrado->NOMGRADO = $_POST["NOMGRADO"];
            $objGrado->nomCampo = $_POST["nomCampo"];
            $objGrado->estiloDesempeno = $_POST["estiloDesempeno"];
            $objGrado->agregar();
            break;

        case 'cargar':
            
            break;

        case 'modificar':
            $objGrado = new Grado();
            $objGrado->CODNIVEL = $_POST['CODNIVEL'];
            $objGrado->CODGRADO = $_POST['CODGRADO'];
            $objGrado->NOMGRADO = $_POST["NOMGRADO"];
            $objGrado->nomCampo = $_POST["nomCampo"];
            $objGrado->estiloDesempeno = $_POST["estiloDesempeno"];
            $objGrado->modificar();    
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