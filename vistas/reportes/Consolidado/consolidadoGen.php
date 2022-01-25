 <?php
    //session_start();
    require("../../../Modelo/Conect.php");
    require("../../../Modelo/Institucion.php");
    require("../../../Modelo/sede.php");
    require("../../../Modelo/curso.php");
    require("../../../Modelo/periodos.php");
    require("../../../Modelo/anhoLectivo.php");
    require("../../../Modelo/areas.php");
    require("../../../Modelo/Estudiante.php");
    require("../../../Modelo/Calificacion.php");
    require("../../../Modelo/desempenhos.php");
    require("../../../Modelo/puesto.php");
    //require("../../Controladores/ctrlBloqueArea.php");
?>
<!Doctype html>
<html>
<head>
   <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte Consolidado</title>
    <link rel="icon" href="../../img/Iconos/Icono.ico" />   
    <link rel='stylesheet' href='../../../estilosCSS/estiloCSS3.css' type='text/css' />
    <style>
        .ove{
            over-flow:hide;
        }
    </style>
</head>

<body>

<div align=center >
<?php

    $curso   = $_POST['curso'];
    $anho    = $_POST['anho'];
    $periodo = $_POST['periodo'];
    $grado;
    $grupo;
    $usuario = "Todos";
    $tipoDatos      = $_POST['tipoDatos'];
    $totalAreas = 0;
    $numAsig    = 0;
    $areasParaPerder = 0;
    $promedios = array();
    $promedioCurso = 0;
    $logo = "";
    $objInstitucion = new Institucion();
    $objAnho = new Anho();
    $objSede = new Sede();
    $objCurso = new Curso();
    $objArea = new Area();
    $objEstudiante = new Estudiante();

    $objSede->CODSEDE = $_POST['sede'];
    $objCurso->curso = $curso;
    $objEstudiante->curso = $curso;
    $objEstudiante->sede  = $_POST['sede'];
    $objEstudiante->anho  = $_POST['anho'];

    foreach ($objInstitucion->cargar() as $dato) {
        $institucion = $dato['nombre'];
        $logo = $dato['logo'];
    }

    foreach ($objSede->cargar() as $sede) {
        $nombreSede = $sede['NOMSEDE'];
    }

    foreach ($objCurso->consultarGrado() as $curso) {
        $grado = $curso['CODGRADO'];
        $grupo = $curso['grupo'];
    }

    $objArea->idGrado = $grado;
    $objArea->anho = $anho;
    $objArea->codSede = $_POST['sede'];
    $objAnho->anho = $_POST['anho'];

    
    foreach ($objAnho->modeloInforme() as $value) {
        $areasParaPerder = $value['areasReprobadas'];
    }

    // SE VERIFICA SI EL CONSOLIDADO SERÁ PARA TODOS LOS CURSOS O PARA UN CURSO EN ESPECIFICO
    if($curso == "Todos"){
         //------------- Inicio del encabezado del consolidado -------------------------//
        include("encabezado.php");
        // ------------------ Fin del encabezado ------------------------//

        include("cuerpo.php");
         
        include("pie.php");
        
            echo "</table>";
        echo "<div style='page-break-after:always'>&nbsp;</div>"; 
    }else{ //Si es un curso especifico
         //------------- Inicio del encabezado del consolidado -------------------------//
        include("encabezado.php");
        // ------------------ Fin del encabezado ------------------------//

        include("cuerpo.php");
         
        include("pie.php");
        
            echo "</table>";
        echo "<div style='page-break-after:always'>&nbsp;</div>"; 
    }//Fin de la Impresion de un curso especifico    
?> 
</div>
</body>

</html>
