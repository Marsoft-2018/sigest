<?php
    require("../Modelo/Conect.php");    
    require("../Modelo/curso.php");
    require("../Modelo/areas.php");
    require("../Modelo/asignatura.php");
    require("../Modelo/profesores.php");
    require("../Modelo/cargaAcademica.php");
    // require("../Modelo/directorCursos.php");
    // require('../Modelo/planillaYnotasClass.php');
    // require("../Modelo/notaFinal.php");
    // require("../Modelo/Boletin.php");


    if(isset($_POST['accion'])){
        $accion=$_POST['accion']; 
    }else{
        echo "No se recibe una accion para ejecutar";
        $accion='nada';
    }

    //--- Eventos relacionados con la matriz nueva ---//
    
	switch ($accion) {
		case 'cargarMatriz':
			$sede = $_POST['sede'];
            $anho = $_POST['anho'];
            include("../vistas/datosSedes/cargaAcademica.php");
			break;
		case 'asignar':
            $objCA = new cargaAcademica();
            $objCA->codProfesor = $_POST['profe'];
            $objCA->codCurso = $_POST['idCurso'];
            if ($_POST['idArea'] != 0) {
                $objCA->codArea = $_POST['idArea'];
            }
    
            if ($_POST['idAsignatura'] != 0) {            
                $objCA->codAsignatura = $_POST['idAsignatura'];
            }
    
            $objCA->anho = $_POST['anho'];
            $objCA -> guardar();			
			break;
		case 'quitar':
            $objCA = new cargaAcademica();
            $objCA->codProfesor = $_POST['profe'];
            $objCA->codCurso = $_POST['idCurso'];
            $objCA->codArea = $_POST['idArea'];
            $objCA->codAsignatura = $_POST['idAsignatura'];        
    
            $objCA->anho = $_POST['anho'];
            $objCA -> eliminar();			
			break;
		case 'agregarDirCurso':
            $profesor = $_POST['idProfesor'];
            $idCurso = $_POST['idCurso'];
            $objDir = new DireccionCurso();
            $objDir -> guardar($profesor,$idCurso);			
			break;
		case 'eliminarDirCurso':
            $profesor = $_POST['idProfesor'];
            $idCurso = $_POST['idCurso'];
            $objDir = new DireccionCurso();
            $objDir -> quitar($profesor,$idCurso);			
			break;
		case 'verCargaAcademicaProfesor':
		    include("../vistas/reportes/cargaAcademicaProfesor.php");
				
			break;
		default:
			// code...
			break;
	}
