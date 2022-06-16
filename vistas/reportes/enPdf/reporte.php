<?php
    
  session_start();  
  require('../../../Modelo/Conect.php');
  require("../../../Modelo/sede.php");
  require("../../../Modelo/anhoLectivo.php");
  require("../../../Modelo/Institucion.php");  
  require("../../../Modelo/nivel.php");
  require("../../../Modelo/curso.php");
  require("../../../Modelo/periodos.php");
  require("../../../Modelo/Estudiante.php");
  require("../../../Modelo/areas.php");
  require("../../../Modelo/Calificacion.php");
  require("../../../Modelo/criterios.php");
  require("../../../Modelo/desempenhos.php");
  require("../../../Modelo/logros.php");
  require("../../../Modelo/direccionDeCursos.php");
  require("../../../Modelo/puesto.php");



  $curso      = $_POST['curso'];
  $anho       = $_POST['anho'];
  $accion = "";
  $tipoB = "";
  $tipoReporte = "";
  $encabezado = "";
  $ubicacionEncabezado = "";
  if (isset($_GET['tipoReporte'])) {
    $accion = $_GET['tipoReporte'];

  }elseif(isset($_POST['tipoReporte'])) {
    $accion = $_POST['tipoReporte'];     
  }


  $objInst = New Institucion();
  $objSede = new Sede();
  // $objModelo = new Anho();
  // $objNivel = new Nivel();
  $objCurso = new Curso();
  $objEstudiantes = new Estudiante();
  // $objPensum = new Area(); 
  // $objPeriodo = new Periodo();
  // $objCalificacion = new Calificacion();


    
  // $objInst->id = $_SESSION['institucion'];
  // $objModelo->anho = $anho;
  // $objSede->curso = $curso;
  // $objNivel->curso = $curso; 
  // $objPensum->codSede = $sede;
  // $objPensum->anho = $anho;
  $objCurso->curso = $curso;
  // $objDirGrupo->anho = $anho;
  // $objDirGrupo->codCurso = $curso;
  // $objCalificacion->curso = $curso;
  // $objCalificacion->Anho = $anho;
  // $sqlCurso = $objCurso->consultarGrado();




  $nombreInstitucion = "";
  $ciudad = "";
  $aprobacion = "";
  $escudo = "";
  $grado = "";
  $grupo = "";
  $nombreGrado = "";
  
  if (isset($_POST['sede'])) {
     $sede  = $_POST['sede'];
  }else{
    $sede  = $objSede->sedeCurso($curso);
  }


  foreach ($objCurso->consultarGrado() as $campo) {
      if($campo['CODGRADO'] <= 0){
          $grado = $campo['NOMGRADO'];
      }else{
          $grado = $campo['CODGRADO']."°";
      }
      
      $grupo = $campo['grupo'];
      $nombreGrado = $campo['NOMGRADO'];
  }

  foreach ($objInst->cargar() as $key => $value) {
     $nombreInstitucion = $value['nombre'];
     $ciudad = $value['ciudad'];
     $aprobacion = $value['membrete'];
     $escudo = $value['logo'];
  }

if ($accion == 9) {
  require("../../../Modelo/cargaAcademica.php");
  include ("planillaSanrafael.php");
}elseif ($accion != 7) {
  include ("planillaListado.php");
}else{
  require("../../../Modelo/cargaAcademica.php");
  include ("planillaSanrafael.php");
}
  
?>  

