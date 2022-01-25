<?php 
$html .="";
switch ($accion) {
	case 1:
		$html .= '<div align="center">
				<div class="banda"><h3>LISTADO DE COORDINACION</h3></div>
				<div style="text-align: right; margin-bottom: 5px;">
					Grado: '.$grado.' Grupo: '.$grupo.'
				</div>
		    <table class="table">
		      <tr>
		        <th bgcolor="#cdcdce" width="20px"><strong>No.</strong></th>
		        <th bgcolor="#cdcdcf"><strong>APELLIDOS</strong></th>
		        <th bgcolor="#cdcdcd"><strong>NOMBRES</strong></th>
		      </tr>';
		      $objEstudiantes->sede = $sede;
		      $objEstudiantes->curso = $curso;
		      $objEstudiantes->anho = $anho;
		      $No = 1;
		      foreach ($objEstudiantes->Listar() as $value) {
		      	$html .= '<tr>
			        <td>'.$No.'</td>
			        <td>'.$value['PrimerApellido'].' '.$value['SegundoApellido'].'</td>
			        <td>'.$value['PrimerNombre'].' '.$value['SegundoNombre'].'</td>
			      </tr>';
			      $No ++;
		      }
		    $html .= '
		    </table>
		</div>';
	break;
	case 2:
		$html .= '<div align="center">
				<div class="banda"><h3>LISTADO DE PAGADURÍA</h3></div>
				<div style="text-align: right; margin-bottom: 5px;">
					Grado: '.$grado.' Grupo: '.$grupo.'
				</div>
		    <table class="table">
		      <tr>
		        <th bgcolor="#cdcdce" width="20px"><strong>No.</strong></th>
		        <th bgcolor="#cdcdcf"><strong>APELLIDOS</strong></th>
		        <th bgcolor="#cdcdcd"><strong>NOMBRES</strong></th>
		        <th bgcolor="#cdcdcd"><strong>ACUDIENTE</strong></th>
		        <th bgcolor="#cdcdcd"><strong>CÓDIGO</strong></th>
		      </tr>';
		      $objEstudiantes->sede = $sede;
		      $objEstudiantes->curso = $curso;
		      $objEstudiantes->anho = $anho;
		      $No = 1;
		      foreach ($objEstudiantes->Listar() as $value) {
		      	$html .= '<tr>
			        <td>'.$No.'</td>
			        <td>'.$value['PrimerApellido'].' '.$value['SegundoApellido'].'</td>
			        <td>'.$value['PrimerNombre'].' '.$value['SegundoNombre'].'</td>
			        <td>'.$value['NombreAcudiente'].'</td>
			        <td style="text-align:center;">'.$value['idMatricula'].'</td>
			      </tr>';
			      $No ++;
		      }

		              
		     //consultar listado

		    $html .= '
		    </table>
		</div>';
	break;
	case 3:
		$html .= '<div align="center">
				<div class="banda"><h3>LISTADO DE RECTORÍA</h3></div>
				<div style="text-align: right; margin-bottom: 5px;">
					Grado: '.$grado.' Grupo: '.$grupo.'
				</div>
		    <table class="table">
		      <tr>
		        <th bgcolor="#cdcdce" width="20px"><strong>No.</strong></th>
		        <th bgcolor="#cdcdcf"><strong>APELLIDOS</strong></th>
		        <th bgcolor="#cdcdcd"><strong>NOMBRES</strong></th>
		        <th bgcolor="#cdcdcd"><strong>CÓDIGO</strong></th>
		      </tr>';
		      $objEstudiantes->sede = $sede;
		      $objEstudiantes->curso = $curso;
		      $objEstudiantes->anho = $anho;
		      $No = 1;
		      foreach ($objEstudiantes->Listar() as $value) {
		      	$html .= '<tr>
			        <td>'.$No.'</td>
			        <td>'.$value['PrimerApellido'].' '.$value['SegundoApellido'].'</td>
			        <td>'.$value['PrimerNombre'].' '.$value['SegundoNombre'].'</td>
			        <td style="text-align:center;">'.$value['idMatricula'].'</td>
			      </tr>';
			      $No ++;
		      }

		              
		     //consultar listado

		    $html .= '
		    </table>
		</div>';
	break;
	case 4:
		$html .= '<div align="center">
				<div class="banda"><h3>LISTADO DE SECRETARÍA</h3></div>
				<div style="text-align: right; margin-bottom: 5px;">
					Grado: '.$grado.' Grupo: '.$grupo.'
				</div>
		    <table class="table">
		      <tr>
		        <th bgcolor="#cdcdce" width="10px"><strong>No.</strong></th>
		        <th bgcolor="#cdcdcf"><strong>APELLIDOS</strong></th>
		        <th bgcolor="#cdcdcd"><strong>NOMBRES</strong></th>
		        <th bgcolor="#cdcdcd" width="10px"><strong>TIPO ID</strong></th>
		        <th bgcolor="#cdcdcd"><strong>NUMERO ID</strong></th>
		        <th bgcolor="#cdcdcd" width="10px"><strong>CÓDIGO</strong></th>
		      </tr>';
		      $objEstudiantes->sede = $sede;
		      $objEstudiantes->curso = $curso;
		      $objEstudiantes->anho = $anho;
		      $No = 1;
		      foreach ($objEstudiantes->Listar() as $value) {
		      	$html .= '<tr>
			        <td>'.$No.'</td>
			        <td>'.$value['PrimerApellido'].' '.$value['SegundoApellido'].'</td>
			        <td>'.$value['PrimerNombre'].' '.$value['SegundoNombre'].'</td>
			        <td style="text-align:center;">'.$value['tipoDocumento'].'</td>
			        <td>'.$value['Documento'].'</td>
			        <td style="text-align:center;">'.$value['idMatricula'].'</td>
			      </tr>';
			      $No ++;
		      }

		              
		     //consultar listado

		    $html .= '
		    </table>
		</div>';
	break;
	case 5:
		$html .= '<div align="center">
				<div class="banda"><h3>PLANILLA DE ASISTENCIA</h3></div>
				
		    <table class="table">
		    	<tr style="background-color:#fff;">
		    		<td colspan="3">Docente: </td>
		    		<td colspan="10">Area/Asignatura:</td>
		    		<td colspan="3">
		    			Grado: '.$grado.'
					</td>
					<td colspan="3"> 
						Grupo: '.$grupo.'
					</td>
					<td  colspan="4">
					 Periodo:
					</td>
		    	</tr>
		      <tr>
		        <th style="background-color:#cdcdcd;width:5px; padding:1px 2px;">
		        	No.
		        </th>
		        <th style="background-color:#cdcdcd;width: 130px; padding:1px 6px;">
		        	APELLIDOS
		        </th>
		        <th  style="background-color:#cdcdcd;width: 130px; padding:1px 2px;">
		        	NOMBRES
		        </th>';
		        for ($i=1; $i <=20 ; $i++) { 
		        	$html .= '<th style="background-color:#cdcdcd; padding:1px 2px;">'.$i.'</th>';
		        }
		      $html .= '</tr>';
		      $objEstudiantes->sede = $sede;
		      $objEstudiantes->curso = $curso;
		      $objEstudiantes->anho = $anho;
		      $No = 1;
		      foreach ($objEstudiantes->Listar() as $value) {
		      	$html .= '<tr>
			        <td style="font-size:8pt; padding:0px 2px;">'.$No.'</td>
			        <td style="font-size:8pt; padding:0px 2px;">'.$value['PrimerApellido'].' '.$value['SegundoApellido'].'</td>
			        <td style="font-size:8pt; padding: 0px 2px;">'.$value['PrimerNombre'].' '.$value['SegundoNombre'].'</td>';
			      for ($i=1; $i <=20 ; $i++) { 
		        	$html .= '<td></td>';
		        }
		      $html .= '</tr>';
			      $No ++;
		      }
		    $html .= '
		    </table>
		</div>';
	break;
	case 6:
		$html .= '<div align="center">
				<div class="banda"><h3>PLANILLA PARA CONTROL DE CALIFICACIONES</h3></div>
				
		    <table class="table">
		    	<tr>
		    		<td  style="background-color:#fff;" colspan="3">Docente: <br><br></td>
		    		<td  style="background-color:#fff;" colspan="5">Area/Asignatura: <br><br></td>
		    		<td  style="background-color:#fff;" colspan="2">
		    			Grado: '.$grado.'
					</td>
					<td  style="background-color:#fff;" colspan="2"> 
						Grupo: '.$grupo.'
					</td>
					<td  style="background-color:#fff;"  colspan="2">
					 Periodo:
					</td>
		    	</tr>
		      <tr>
		        <th style="background-color:#cdcdcd;width:5px; padding:1px 2px;">
		        	No.
		        </th>
		        <th style="background-color:#cdcdcd;width: 130px; padding:1px 6px;">
		        	APELLIDOS
		        </th>
		        <th  style="background-color:#cdcdcd;width: 130px; padding:1px 2px;">
		        	NOMBRES
		        </th>';
		        for ($i=1; $i <=10 ; $i++) { 
		        	$html .= '<th style="background-color:#cdcdcd; padding:1px 2px;">N'.$i.'</th>';
		        }
		      $html .= '
				<th  style="background-color:#cdcdcd;padding:1px 2px;">
		        	DEF
		        </th>
		      </tr>';
		      $objEstudiantes->sede = $sede;
		      $objEstudiantes->curso = $curso;
		      $objEstudiantes->anho = $anho;
		      $No = 1;
		      foreach ($objEstudiantes->Listar() as $value) {
		      	$html .= '<tr>
			        <td style="font-size:8pt; padding:2px;">'.$No.'</td>
			        <td style="font-size:8pt; padding:2px;">'.$value['PrimerApellido'].' '.$value['SegundoApellido'].'</td>
			        <td style="font-size:8pt; padding: 2px;">'.$value['PrimerNombre'].' '.$value['SegundoNombre'].'</td>';
			      for ($i=0; $i <=10 ; $i++) { 
		        	$html .= '<td></td>';
		        }
		      $html .= '</tr>';
			      $No ++;
		      }
		    $html .= '
		    </table>
		</div>';
	break;
	default:
		# code...
		break;
}



?>