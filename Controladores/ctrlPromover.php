<?php 
    session_start();
	require("../Modelo/Conect.php");
    require("../Modelo/anhoLectivo.php");
    require("../Modelo/Estudiante.php");
    require("../Modelo/areas.php");
    require("../Modelo/periodos.php");
    require("../Modelo/Calificacion.php");
    require("../Modelo/desempenhos.php");
	require("../Modelo/promover.php");
    if(isset($_POST['accion'])){
        $accion=$_POST['accion']; 
    }else{
        echo "No se recibe una accion para ejecutar";
        $accion='nada';
    }
    
    switch ($accion) {
        case 'cargarMatrizEstudiantes':
            $sede = $_POST['sede'];
            $anho = $_POST['anho'];
            include("../vistas/promocion/listado.php");
            break;
        case 'PromoverEstudiantes':
            $estudiante=$_POST['estudiante'];
            $grado=$_POST['grado'];
            $grupo=$_POST['grupo'];
            $objCarga = new Promover();
            $objCarga->Avanzar($estudiante,$grado,$grupo);
        break;
        case 'cerrarAnho':
            $objAnho = new Anho();
            $anhoActual = $objAnho->cargar();
            $anhoSiguiente = $anhoActual + 1;
            $objArea = new Area();
            $objArea->anho = $anhoActual;
            $objArea->copiarAreas($anhoSiguiente);
            $objAnho->cierre();
        break;        
        default:
            # code...
            break;
    }
	
?>