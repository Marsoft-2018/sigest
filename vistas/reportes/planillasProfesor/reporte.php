<?php
    
  //session_start();  
  require('../../../Modelo/Conect.php');
  require("../../../Modelo/sede.php");
  require("../../../Modelo/anhoLectivo.php");
  require("../../../Modelo/Institucion.php");  
  require("../../../Modelo/nivel.php");
  require("../../../Modelo/curso.php");
  require("../../../Modelo/periodos.php");
  require("../../../Modelo/profesores.php");
  require("../../../Modelo/cargaAcademica.php");
  require("../../../Modelo/Estudiante.php");
  require("../../../Modelo/areas.php");
  require("../../../Modelo/Calificacion.php");
  require("../../../Modelo/criterios.php");
  require("../../../Modelo/desempenhos.php");
  require("../../../Modelo/logros.php");
  require("../../../Modelo/direccionDeCursos.php");
  require("../../../Modelo/puesto.php");


  $anho   = date("Y");
  $accion = "";
  $tipoB = "";
  $tipoReporte = "";
  $encabezado = "";
  $ubicacionEncabezado = "";
  $nombreInstitucion = "";
  $ciudad = "";
  $aprobacion = "";
  $escudo = "";
  $grado = "";
  $grupo = "";
  $nombreGrado = "";
  $profesor = ""; 
  $idProfesor = "";
  
  if (isset($_GET['tipoReporte'])) {
    $accion = $_GET['tipoReporte'];

  }elseif(isset($_POST['tipoReporte'])) {
    $accion = $_POST['tipoReporte'];     
  }
  
  if (isset($_GET['anho'])) {
    $anho = $_GET['anho'];

  }elseif(isset($_POST['anho'])) {
    $anho = $_POST['anho'];     
  }

  if (isset($_GET['profesor'])) {
    $profesor = $_GET['profesor'];

  }elseif(isset($_POST['profesor'])) {
    $profesor = $_POST['profesor'];     
  }
  
  if (isset($_GET['idProfesor'])) {
    $idProfesor = $_GET['idProfesor'];

  }elseif(isset($_POST['idProfesor'])) {
    $idProfesor = $_POST['idProfesor'];     
  }

  $objInst = New Institucion();
  

  foreach ($objInst->cargar() as $key => $value) {
     $nombreInstitucion = $value['nombre'];
     $ciudad = $value['ciudad'];
     $aprobacion = $value['membrete'];
     $escudo = $value['logo'];
  }

    $objCargaAcademica = new cargaAcademica();
    $objCargaAcademica->codProfesor = $idProfesor;
    $objCargaAcademica->anho = $anho;
    
    foreach ($objCargaAcademica->verCarga() as $campo) {
        $curso = $campo['codCurso'];
        $objSede = new Sede();
        $sede  = $objSede->sedeCurso($curso);
        $grado = $campo['CODGRADO']."°";
        if($campo['CODGRADO']<=0){ $grado = $campo['NOMGRADO']; }
        $grupo = $campo['grupo'];
        $area = $campo['Nombre'];
        
        $objEstudiantes = new Estudiante();
        //echo "<br>--------- $area ---------------";   
        include ("planillaListado.php");
    }
?>  

