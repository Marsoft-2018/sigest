<?php 
    session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/Institucion.php");    
    require("../Modelo/anhoLectivo.php");
    require("../Modelo/sede.php");
    require("../Modelo/nivel.php");
    require("../Modelo/grado.php");
    require("../Modelo/curso.php");
    require("../Modelo/periodos.php");
    require("../Modelo/Estudiante.php");
    require("../Modelo/areas.php");
    require("../Modelo/asignatura.php");
    require("../Modelo/Calificacion.php");
    require("../Modelo/desempenhos.php");
    require("../Modelo/tipoPlanilla.php");
    require("../Modelo/logros.php");
    require("../Modelo/direccionDeCursos.php");
    require("../Modelo/puesto.php");
    require("../Modelo/observacionBoletin.php");
    require("../Modelo/criterios.php");


    // $sede       = $_POST['sedeBol']; 213244000880
    // $curso      = $_POST['cursoBol'];
    // $anho       = $_POST['anho'];
    // $periodoBol = $_POST['periodoBol'];
    // $centro     = $_POST['centro'];
    // $topeMinDeAreasEnBoletin = $_POST['topeMinDeAreasEnBoletin'];
    
    $sede   = $_POST['sede'];
    $curso  = $_POST['curso'];
    $anho   = $_POST['anho'];
    $grado  = "";

    if (isset($_POST['periodo'])) {       
        $periodoBol = $_POST['periodo'];
    }else{
        $periodoBol = "Final";
    }

    $tipoBoletin = $_POST['tipoB'];
    $centro     = $_SESSION['institucion'];
    $topeMinDeAreasEnBoletin = 0;
    $directorGrupo = "";
    $idMatricula = 0;
    $noLista = 0;
    $modelo = "";
    $nombreGrado = "";
    $areasPerder = 0;
    $tipoLogros = "";

    if(isset($_POST['Pg'])){
        $pagina=$_POST['Pg'];
        $registros=$_POST['Cant'];
    }else{
        $pagina=1;
        $registros=10;
    }
    $Rinicio;


    if(is_numeric($pagina)){
        $Rinicio=(($pagina-1)*$registros);
    }else{
        $Rinicio=0;
    }

    $objInst = new Institucion();
    $objSede = new Sede();
    $objModelo = new Anho();
    $objNivel = new Nivel();
    $objCurso = new Curso();
    $objDirGrupo = new DireccionCurso();
    $objEstudiantes = new Estudiante();
    $objPensum = new Area(); 
    $objPeriodo = new Periodo();
    $objCalificacion = new Calificacion();
    $objTipoLogros = new tipoPlanilla();


    
    $objInst->id = $centro;
    $objModelo->anho = $anho;
    $objSede->curso = $curso;
    $objNivel->curso = $curso; 
    $objPensum->codSede = $sede;
    $objPensum->anho = $anho;
    $objCurso->curso = $curso;
    $objDirGrupo->anho = $anho;
    $objDirGrupo->codCurso = $curso;
    $objCalificacion->curso = $curso;
    $objCalificacion->Anho = $anho;
    $objTipoLogros->anho = $anho;
    $sqlCurso = $objCurso->consultarGrado();
    
    
    
    if(isset($_POST['Estudiante'])){
        $objEst = new Estudiante();
        $objEst->sede= $sede;
        $objEst->curso= $curso;
        $objEst->anho= $anho;
        $objEst->Rinicio= $Rinicio;
        $objEst->registros= $registros;
        if (!isset($_POST['boletinEstudiante'])) { 
            $sqltodos = $objEst->ConsultaEstudiantesEspecificos($_POST['Estudiante'], $Rinicio, $registros);
            //var_dump($sqltodos);
        }else{
            $sqltodos = $objEst->cargarEstudiante($_POST['Estudiante'], 1, 1);
        }
        
        foreach ($sqltodos as $campo) {
            echo "<title>".$campo['PrimerNombre']." ".$campo['SegundoNombre']." ".$campo['PrimerApellido']." ".$campo['SegundoApellido']." Boletin Periodo_$periodoBol</title>";
            foreach ($sqlCurso as $cur) {
                $objPensum->idGrado = $cur['CODGRADO'];
                $grado = $cur['CODGRADO'];
                $nombreGrado = $cur['NOMGRADO'];
            }
        } 
    }else{
        foreach ($sqlCurso as $campo) {
            echo "<title>".$campo['CODGRADO']."°".$campo['grupo']." Boletin Periodo: $periodoBol(Part$pagina)</title>";
            $objPensum->idGrado = $campo['CODGRADO'];
            $grado = $campo['CODGRADO'];
            $nombreGrado = $campo['NOMGRADO'];
        }
    }
    
    
    foreach ($objModelo->modeloInforme() as $value) {
        $modelo = $value['modeloBoletin'];
        $areasPerder = $value['areasReprobadas'];
    }

    foreach ($objTipoLogros->cargar() as $value) {
        $tipoLogros = $value['tipo_logro'];
    }

    switch ($tipoBoletin) {
        case 'Periodos':
            foreach ($objDirGrupo->cargar() as $key => $direc) {
                $directorGrupo = $direc['nombre'];
            }
            
            if($modelo == "M1"){
                include("../vistas/boletines/Modelo1.php");
            }elseif($modelo == "M2"){            
                include("../vistas/boletines/modeloSrf.php");
            }
            break;
        case 'Final':
            if($modelo == "M1"){
                include("../vistas/boletines/finales/boletinFinal-M1.php");
            }elseif($modelo == "M2"){            
                include("../vistas/boletines/finales/boletinFinal-M2.php");
            }
            break;
        case 'paraEstudiante':
            foreach ($objDirGrupo->cargar() as $key => $direc) {
                $directorGrupo = $direc['nombre'];
            }
            
            if($modelo == "M1"){
                include("../vistas/boletines/Modelo1.php");
            }elseif($modelo == "M2"){            
                include("../vistas/boletines/modeloSrf.php");
            }
            break;
        case 'Certificado':
            include("../vistas/reportes/certificaciones/certificado.php");
            
            break;
    }

