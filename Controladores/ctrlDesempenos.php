<?php
    session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/nivel.php");
    require("../Modelo/desempenhos.php");
    $accion = "";
    if(isset($_REQUEST['accion'])){ $accion = $_REQUEST['accion']; }
    
    switch ($accion) {
        case 'nuevo': case 'editar':
            include_once("../vistas/ajustes/desempenos/formulario.php");            
            break;
        
        case 'agregar':
            echo var_dump($_REQUEST);
            $objDesempeno = new Desempenos();
            $objDesempeno->emoticon = $_POST['emoticon'];
            $objDesempeno->CONCEPT = $_POST["CONCEPT"];
            $objDesempeno->limiteInf = $_POST["limiteInf"];
            $objDesempeno->limiteSup = $_POST["limiteSup"];
            //$objDesempeno->Guardar();
            break;

        case 'cargar':
            $objDesempeno = new Desempenos();
            $objDesempeno->idDes = $_POST['idDes'];
            echo json_encode($objDesempeno->cargar());            
            break;
        case 'mostrar':
            include_once("../vistas/ajustes/desempenos/listado.php");            
            break;
        case 'modificar':
            //echo var_dump($_REQUEST);
            $objDesempeno = new Desempenos();
            $objCodigoAnterior = $_POST['id'];
            $objDesempeno->emoticon = $_POST['emoticon'];
            $objDesempeno->idDes = $_POST['idDes'];
            $objDesempeno->CONCEPT = $_POST["CONCEPT"];
            $objDesempeno->limiteInf = $_POST["limiteInf"];
            $objDesempeno->limiteSup = $_POST["limiteSup"];
            //$objDesempeno->modificar();    
            break;

        case 'listar':
            $objDesempeno = new Desempenos();
            echo json_encode($objDesempeno->listar());
            break;

        case 'listarPorNivel':
            $objDesempeno = new Desempenos();
            $objDesempeno->emoticon = $_POST['emoticon'];
            //echo json_encode($objDesempeno->listarPorNivel());
            break;
    
        case 'eliminar':
            $objDesempeno = new Desempenos();
            $objDesempeno->idDes = $_POST['idDes'];
            $objDesempeno->eliminar();
            break;

        default:
            # code...
            break;
    }

?>