<?php 
  $html = ' 
    <!Doctype html>
    <html>
    <head>
        <title>Reporte '.$tipoB.' '.$anho.'</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="plantilla/css/estilo.css">
        <link rel="stylesheet" href="../../../font-awesome/css/font-awesome.min.css" type="text/css">
        <link href="../../../css/bootstraps3.1.css" rel="stylesheet">
        <link href="../../../css/listas.css" rel="stylesheet">
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
            $encabezado = "";              
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

  // //dompdf Para php 5.6
  // require("../../../complementos/dompdf/dompdf_config.inc.php");
  // // $dompdf=new DOMPDF();
  // //Para php 7.0
  // // require("../../../complementos/dompdf/autoload.inc.php");
  // // use Dompdf\Dompdf;
  // $dompdf = new Dompdf();
  // $dompdf->load_html($codigoHTML);
  // if($accion== 5){
  //   $dompdf->set_paper("letter", "landscape");
  // }
  // //ini_set("memory_limit","128M");
  // $dompdf->render();

  // $accion = 1;
  // if ($accion == 1) {//Abrir el archivo
  //   $dompdf->stream("archivo.pdf", array("Attachment" => false));  
  // }else{//Descargar
  //   $dompdf->stream("archivo.pdf");
  // }

//  con la libreria MPDF

  /*
  $enc = include("membrete/t1_cen.php");
  require_once("../../../complementos/mpdf/mpdf.php");
  
  if($accion== 5){
    $pdf = new mPDF('c','',0,0,10,10);
    $pdf->AddPage("LETTER");
  }else{
    $pdf = new mPDF('c');
  }

  $pdf->WriteHtml($codigoHTML);
  $pdf->Output();
  exit;*/
echo $codigoHTML;


?>