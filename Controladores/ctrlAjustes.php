<?php
    session_start();
    $idInst = $_SESSION['institucion'];
    require("../Modelo/Conect.php");
    require("../Modelo/Institucion.php");
    require("../Modelo/anhoLectivo.php");
    require("../Modelo/periodos.php");
    require("../Modelo/desempenhos.php");
    require("../Modelo/criterios.php");
    $accion;
    $modulo;
    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
        $modulo = $_POST['modulo'];
    }elseif(isset($_GET['accion'])){
        $accion = $_GET['accion'];
        $modulo = $_GET['modulo'];
    }

    // echo "Esta en ajustar.php Modulo: $modulo, Accion: $accion";
    //         include('../vistas/periodos.php');

    if($modulo == 'annoLectivo'){
       if($accion == 'guardarAnno'){
            $objAnno = new Anho();
            $objAnno->anho = $_POST['anno'];
            $objAnno->Guardar($inst,$anno);
        }         
    }elseif($modulo=='periodos'){
       if($accion=='agregarPeriodo'){
            $objPeriodo = new Periodo();
            $objPeriodo->periodo = $_POST['per'];
            $objPeriodo->valorPeriodo = $_POST['porce'];
            $objPeriodo->fechaInicio = $_POST['fechaInicio'];
            $objPeriodo->fechaCierre = $_POST['fechaCierre'];  
            $objPeriodo->Guardar();
            require('../vistas/ajustes/periodos.php');
        }
        
        if($accion=='Modificar'){         
            $objPeriodo = new Periodo();
            $objPeriodo->Modificar($_POST['campo'],$_POST['clave'],$_POST['valor']);
        }
            
        if($accion == 'Eliminar'){
            $objPeriodo = new Periodo();
            $objPeriodo->periodo = $_POST['per'];
            $objPeriodo->Eliminar();
            require('../vistas/ajustes/periodos.php');
        }
    }elseif($modulo=='Desempenos'){
       if($accion == 'agregarDesempeno'){            
            $objDesemp = new Desempenos();
            $objDesemp->limiteInf = $_POST['desempInf'];
            $objDesemp->limiteSup = $_POST['desempSup'];
            $objDesemp->CONCEPT = $_POST['Desempeno'];
            $objDesemp->Guardar();
            require("../vistas/ajustes/desempenos.php");
        }  
        if($accion == 'modificar'){           
            $campo = $_POST['campo'];
            $clave = $_POST['clave'];
            $valor = $_POST['valor'];           
           
            $objDesemp = new Desempenos();
            $objDesemp->Modificar($campo,$clave,$valor);
        } 
        if($accion == 'eliminar'){ 
            $objDesemp = new Desempenos();
            $objDesemp->idDes = $_POST['id']; 
            $objDesemp->Eliminar();
            require("../vistas/ajustes/desempenos.php");
        } 
    }elseif($modulo=='Criterios'){
       if($accion=='agregarCriterio'){ 
            $objCriterio = new Criterio();
            $objCriterio->nombre     = $_POST['criterio'];
            $objCriterio->porcentaje = $_POST['pCriterio'];
            $objCriterio->Agregar();
            include("../vistas/ajustes/criterios.php");
        }  
        if($accion=='modificarCriterio'){   
            $objCriterio = new Criterio();
            $objCriterio->id = $_POST['id'];
            $objCriterio->nombre = $_POST['nombre'];
            $objCriterio->porcentaje = $_POST['porcentaje'];
            $objCriterio->Modificar();
        } 
        if($accion=='eliminarCriterio'){ 
            $objCriterio = new Criterio();
            $objCriterio->id = $_POST['id']; 
            $objCriterio->Eliminar();
            include("../vistas/ajustes/criterios.php");
        } 
    }elseif($modulo == 'modelos'){
       if($accion == 'guardarModeloInforme'){
            $objAnno = new Anho();
            $objAnno->modelo = $_POST['modelo'];
            $objAnno->areasReprobadas = $_POST['areasReprobar'];
            $objAnno->guardarModelo();
        }       
    }

    
?>