<?php 
$html .="";
switch ($accion) {
	case 1: ?>
		<div align="center">
				<div class="banda"><h3>PLANILLA DE ASISTENCIA</h3></div>
				
		    <table class="table" style="border: 1px solid #000">
		    	<tr style="background-color:#fff;">
		    		<td colspan="3">Docente: <?php echo $profesor ?></td>
		    		<td colspan="10">Area/Asignatura: <?php echo strtoupper($area) ?></td>
		    		<td colspan="3">
		    			Grado: <?php echo $grado ?>
					</td>
					<td colspan="3"> 
						Grupo: <?php echo $grupo ?>
					</td>
					<td  colspan="4">
					 Periodo:
					</td>
		    	</tr>
		      <tr>
		        <th style="background-color:#cdcdcd;width:5px; padding:1px 2px;">
		        	No.
		        </th>
		        <th style="background-color:#cdcdcd;width: 160px; padding:1px 6px;">
		        	APELLIDOS
		        </th>
		        <th  style="background-color:#cdcdcd;width: 160px; padding:1px 2px;">
		        	NOMBRES
		        </th>
		        <?php 
		        for ($i=1; $i <=20 ; $i++) { ?>
		        	<th style="background-color:#cdcdcd; padding:1px 2px;"><?php echo $i ?></th>
		        <?php } ?>
		        
		      </tr>
		      <?php 
		      $objEstudiantes->sede = $sede;
		      $objEstudiantes->curso = $curso;
		      $objEstudiantes->anho = $anho;
		      $No = 1;
		      foreach ($objEstudiantes->Listar() as $estudiante) { ?>
		      	<tr>
			        <td style="font-size:8pt; padding:0px 2px;"><?php echo $No ?></td>
			        <td style="font-size:8pt; padding:0px 2px;"><?php echo $estudiante['PrimerApellido'].' '.$estudiante['SegundoApellido'] ?></td>
			        <td style="font-size:8pt; padding: 0px 2px;"><?php echo $estudiante['PrimerNombre'].' '.$estudiante['SegundoNombre'] ?></td>
			     <?php 
			     for ($i=1; $i <=20 ; $i++) { ?>
		        	<td style="padding: 10px;"></td>
		        <?php } ?>
		        </tr>
		        <?php 
			      $No ++;
		      } ?>
		    </table>
		</div>
		<h1 style="page-break-after:always"></h1>
		<?php 
	break;
	case 2:
		?>
		<div align="center">
				<div class="banda"><h3>PLANILLA PARA CONTROL DE CALIFICACIONES</h3></div>
				
		    <table class="table" style="border: 1px solid #000">
		    	<tr>
		    		<td  style="background-color:#fff;" colspan="3">Docente: <?php echo $profesor ?></td>
		    		<td  style="background-color:#fff;" colspan="5">Area/Asignatura: <?php echo strtoupper($area) ?></td>
		    		<td  style="background-color:#fff;" colspan="2">
		    			Grado: <?php echo $grado ?>
					</td>
					<td  style="background-color:#fff;" colspan="2"> 
						Grupo: <?php echo $grupo ?>
					</td>
					<td  style="background-color:#fff;"  colspan="2">
					 Periodo:
					</td>
		    	</tr>
		      <tr>
		        <th style="background-color:#cdcdcd;width:5px; padding:1px 2px;">
		        	No.
		        </th>
		        <th style="background-color:#cdcdcd;width: 160px; padding:1px 6px;">
		        	APELLIDOS
		        </th>
		        <th  style="background-color:#cdcdcd;width: 160px; padding:1px 2px;">
		        	NOMBRES
		        </th>
		        <?php 
		        for ($i=1; $i <=10 ; $i++) {  ?>
		        	<th style="background-color:#cdcdcd; padding:1px 2px; width: 55px;">N<?php echo $i ?></th>
		        <?php } ?>
		      
				<th  style="background-color:#cdcdcd;padding:1px 2px;">
		        	DEF
		        </th>
		      </tr>
		      <?php 
		      $objEstudiantes->sede = $sede;
		      $objEstudiantes->curso = $curso;
		      $objEstudiantes->anho = $anho;
		      $No = 1;
		      foreach ($objEstudiantes->Listar() as $estudiante) { ?>
		      	<tr>
			        <td style="font-size:8pt; padding:2px;"><?php echo $No ?></td>
			        <td style="font-size:8pt; padding:2px;"><?php echo $estudiante['PrimerApellido'].' '.$estudiante['SegundoApellido'] ?></td>
			        <td style="font-size:8pt; padding: 2px;"><?php echo $estudiante['PrimerNombre'].' '.$estudiante['SegundoNombre'] ?></td>
			        <?php 
			      for ($i=0; $i <=10 ; $i++) { ?>
		        	<td style="padding: 10px;"></td>
		        <?php } ?>
		        </tr>
		        <?php 
			      $No ++;
		      } ?>
		    </table>
		</div>
		<h1 style="page-break-after:always"></h1>
		<?php 
	break;
}



?>