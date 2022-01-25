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
  
  if (isset($_POST['sede'])) {
     $sede  = $_POST['sede'];
  }else{
    $sede  = $objSede->sedeCurso($curso);
  }


  foreach ($objCurso->consultarGrado() as $campo) {
      $grado = $campo['CODGRADO']."°";
      $grupo = $campo['grupo'];
  }

  foreach ($objInst->cargar() as $key => $value) {
     $nombreInstitucion = $value['nombre'];
     $ciudad = $value['ciudad'];
     $aprobacion = $value['membrete'];
     $escudo = $value['logo'];
  }

  $html = ' 
  <!Doctype html>
  <html>
    <head>
        <title>Reporte '.$tipoB.' '.$anho.'</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="plantilla/css/estilo.css">
        <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" type="text/css">
        <link href="../css/bootstraps3.1.css" rel="stylesheet">
        <style>
            a {
              color: #5D6975;
              text-decoration: underline;
            }

            body {
              font-family: Arial, sans-serif;
              position: relative;
              margin: 0 auto; 
              color: #001028;
              background: #FFFFFF; 
              font-size: 12px; 
              font-family: Arial;
              margin: 15mm 5mm 10mm 5mm;
            }

            header {
              padding: 0px 0;
              margin-bottom: 0px;
            }

            #logo {
              text-align: center;
              margin-bottom: 2px;
            }

            #logo img {
              width: 50px;
            }

            .banda {
              margin-top: 10px;
              margin-bottom: 5px;
              display: block;
              border-top: 1px solid  #5D6975;
              border-bottom: 1px solid  #5D6975;
              color: #5D6975;
              font-size: 1.4em;
              line-height: 1.4em;
              font-weight: normal;
              text-align: center;
              background: url("vistas/img/cinta.png");
            }

            .banda h3{
              margin: 0px;
              padding: 0px;
            }

            p{
              line-height: 2em;
              font-size: 14px;
              text-align: justify;
            }

            #project {
              float: left;
            }

            #project span {
              color: #5D6975;
              text-align: right;
              width: 52px;
              margin-right: 10px;
              display: inline-block;
              font-size: 0.8em;
            }



            .table {
              width: 100%;
              border-collapse: collapse;
              border-spacing: 0;
              border: 1px solid #000;
            }

            .table tr:nth-child(2n-1) td {
              background: #F5F5F5;
            }

            .table th, .table td {
              border: 1px solid #000; 
              font-family: Arial, sans-serif; 
            }

            .table th {
              text-align: center;
              padding: 1px 20px;
              color: #000;
              border-bottom: 1px solid #000;
              font-weight: normal;
              white-space: nowrap;      
            }

            .table td{
              border-collapse: collapse;
              font-size: 9pt;
              padding: 1px 2px;
            }


            #notices .notice {
              color: #5D6975;
              font-size: 1.2em;
            }

            footer {
              color: #5D6975;
              width: 100%;
              height: 30px;
              position: absolute;
              bottom: 0;
              border-top: 1px solid #C1CED9;
              padding: 8px 0;
              text-align: center;
            }
        </style>
    </head>
    <body>';
    if(isset($_POST['encabezado'])){
      switch ($_POST['encabezado']) {
        case 1:          
          if (isset($_POST['ubicacionEncabezado'])) {
            switch ($_POST['ubicacionEncabezado']) {
              case 1:
                include("membrete/t1_izq.php");
              break;
              case 2:
                include("membrete/t1_cen.php");  
              break;
              case 3:
                include("membrete/t1_der.php"); 
              break;
              default:
                include("membrete/t1_cen.php"); 
                break;
            }
          }
          break;
        case 2:
          if (isset($_POST['ubicacionEncabezado'])) {
            switch ($_POST['ubicacionEncabezado']) {
              case 1:
                include("membrete/t2_izq.php");
              break;
              case 2:
                include("membrete/t2_cen.php");  
              break;
              case 3:
                include("membrete/t2_der.php"); 
              break;
              default:
                include("membrete/t2_cen.php"); 
                break;
            }
          }
        break;
        case 3:
          if (isset($_POST['ubicacionEncabezado'])) {
            switch ($_POST['ubicacionEncabezado']) {
              case 1:
                $encabezado = "";
              break;
              case 2:
                $encabezado = "";  
              break;
              case 3:
                $encabezado = "";  
              break;
              default:
                $encabezado = "";
                break;
            }
          }
        break;        
        default:
          include("membrete/t1_cen.php"); 
          break;
      }      
    }else{
      include("membrete/t2_izq.php");
    }
 include("cuerpo.php");
    
$html .= "</body>";
  $codigoHTML = $html;
  //Para php 5.6
  require("../../../complementos/dompdf/dompdf_config.inc.php");
  // $dompdf=new DOMPDF();
  //Para php 7.0
  // require("../../../complementos/dompdf/autoload.inc.php");
  // use Dompdf\Dompdf;
  $dompdf = new Dompdf();
  $dompdf->load_html($codigoHTML);
  if($accion== 5){
    $dompdf->set_paper("letter", "landscape");
  }
  //ini_set("memory_limit","128M");
  $dompdf->render();

  $accion = 1;
  if ($accion == 1) {//Abrir el archivo
    $dompdf->stream("archivo.pdf", array("Attachment" => false));  
  }else{//Descargar
    $dompdf->stream("archivo.pdf");
  }


  function file_get_contents_curl($url){
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $url);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);
    $ret = curl_exec($crl);
    curl_close($crl);
    return $ret;
  }

?>  

