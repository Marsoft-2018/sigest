<?php 
$objEstudiantes->sede = $sede;
$objEstudiantes->curso = $curso;
$objEstudiantes->anho = $anho;

$html = '

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Planilla por periodo</title>
        <link rel="stylesheet" href="plantilla/css/estilo.css">
        <link rel="stylesheet" href="../../../font-awesome/css/font-awesome.min.css" type="text/css">
        <link href="../../../css/bootstraps3.1.css" rel="stylesheet">
        <link href="../../../css/listas.css" rel="stylesheet">
	
</head>
<body>';
	$objAreas = new Area();
	$objAreas->curso = $_POST['curso'];
	$objAreas->anho = $_POST['anho'];

	foreach ($objAreas->cargarTodasLasAreas() as $campo) {
		$html .= '
	<table class="table table-striped">
		<thead>
			<tr>
				<th colspan="13">					
					<div id="logo">
						<img src="../../img/'.$escudo.'"  style="width:40px; height:40px; margin:0px;">
						<h1>COLEGIO SAN RAFAEL</h1>
					</div>
				</th>
			</tr>
			<tr>
				<th colspan="13">
					<h3>PLANILLA DE CALIFICACIONES</h3>
				</th>
			</tr>
			<tr>
				<th colspan="3">AREA/ASIGNATURA: <strong>'.strtoupper($campo['Nombre']).'</strong></th>
				<th>PERIODO: '.$_POST['periodo'].'</th>
				<th colspan="5">DOCENTE: JOSE TAPIA ARROYO</th>
				<th colspan="4">GRADO: <strong>'.strtoupper($nombreGrado).'</strong></th>
			</tr>
			<tr>
				<th colspan="4">ESTUDIANTES</th>
				<th colspan="3">80%</th>
				<th>20%</th>
				<th colspan="2">100%</th>
				<th colspan="3"></th>
			</tr>
			<tr>
				<th>No.</th>
				<th colspan="2">APELLIDOS</th>
				<th>NOMBRES</th>
				<th>C1</th>
				<th>C2</th>
				<th>C3</th>
				<th>EV. PER</th>
				<th>80%</th>
				<th>20%</th>
				<th>J. VAL</th>
				<th>INAS</th>
				<th>CALIF</th>
			</tr>
		</thead>
		<tbody>';
		$No = 1;
		foreach ($objEstudiantes->Listar() as $value) {
			$html .= '<tr>
		    <td style="width: 10px;">'.$No.'</td>
		    <td style="width: 130px;">'.$value['PrimerApellido'].'</td>
		    <td style="width: 130px;">'.$value['SegundoApellido'].'</td>
		    <td style="width: 250px;">'.$value['PrimerNombre'].' '.$value['SegundoNombre'].'</td>';
		    $objCriterios = new Criterio();
    		$numCriterios = $objCriterios->conteoCriterios();
    		$suma = 0;
		    foreach ($objCriterios->Listar() as $criterio) { 
                $html .= "<td style=' text-align: center; padding: 0px; width: 50px;'>";
                                $notaCriterio = "";
                                $objNotaCriterio = new Calificacion();
                                $objNotaCriterio->periodo = $_POST['periodo'];
                                $objNotaCriterio->idMatricula = $value['idMatricula'];
                                $objNotaCriterio->codArea = $campo['id'];
                                $objNotaCriterio->Anho = $_POST['anho'];
                                $objNotaCriterio->curso = $_POST['curso'];
                                $objNotaCriterio->tabla = $campo['tipo'];
                                $objNotaCriterio->idCriterio = $criterio['codCriterio'];

                                $notaCriterio = $objNotaCriterio->cargarPorCriterio();
                                $suma = $suma + $notaCriterio; 
                    $html .=  $notaCriterio;
                    $html .= '</td>';
                    }

		$html .= '
			<td></td>
			<td style=" text-align: center; padding: 0px; width: 50px;">'.round((($suma / $numCriterios) * 0.8),1).'</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		  </tr>';
		  $No ++;
		}
				
	$html .= '</tbody>
	</table>';
	}
$html .= '</body>
</html>';

  $codigoHTML = $html;

$enc = include("membrete/t1_cen.php");
  require_once("../../../complementos/mpdf/mpdf.php");
  
  if($accion== 5){
    $pdf = new mPDF('c','',0,0,10,10);
    $pdf->AddPage("LETTER");
  }else{
    $pdf = new mPDF('c');
    $pdf->AddPage("LETTER");
  }
  $pdf->WriteHtml($codigoHTML);
  $pdf->Output();
  exit;