<?php 
	$objEst = new Estudiante();
	$objEst->sede = $sede;
	$objEst->anho = $anho;
 ?>

<table id="listado" class = 'display table table-striped table-hover dataTable'>
<thead>
	<tr style = 'background-color:#436756;color:#fff;'>
		<th>No. Matricula</th>
		<th>Tipo Doc</th>
		<th>Documento</th>
		<th>Primer Apellido</th>
		<th>Segundo Apellido</th>
		<th>Primer Nombre</th>
		<th>Segundo Nombre</th>
		<th>Curso Actual</th>
		<th>Estado</th>
		<th>Prom</th>
	</tr>
</thead>
<tbody>
	<?php 
	foreach ($objEst->listadoSede() as $value) { ?>					
		<tr style = 'padding:1px;font-size:10px;margin:0px;'>
			<td><?php echo $value['idMatricula']; ?></td>
			<td><?php echo $value['tipoDocumento']; ?></td>
			<td><?php echo $value['Documento']; ?></td>
			<td><?php echo $value['PrimerApellido']; ?></td>
			<td><?php echo $value['SegundoApellido']; ?></td>
			<td><?php echo $value['PrimerNombre']; ?></td>
			<td><?php echo $value['SegundoNombre']; ?></td>
			<td><?php echo $value['CODGRADO']."°".$value['grupo']; ?></td>
			<?php 
				$estado = "";
				$objEstado  =  new Promover();
				$objEstado->sede = $sede;
				$objEstado->grado = $value['CODGRADO'];
				$objEstado->grupo = $value['grupo'];
				$objEstado->idMatricula = $value['idMatricula'];
				$objEstado->curso = $value['Curso'];
				$objEstado->anho  = $anho;

				$estado = $objEstado->estadoFinalAnho($value['idMatricula'],$value['Curso'],$anho);
				$estilo = "";
				if($estado === 'Aprobado'){
					$estilo = "background-color:#0fa;";
				}elseif($estado === 'Aplazado'){
					$estilo = "background-color:#ffcc00;";
				}elseif($estado === 'Reprobado'){
					$estilo = "background-color:#f01f05; padding:1px; font-size:10px; margin:0px; border:1px solid #E7E7E7; text-align:center; vertical-align:middle; color:#fff;";
				}  
			?>   
			<td style="<?php echo $estilo ?> " >
				<?php echo    $estado; ?>
			</td> 
			<td style = 'width:100px;'>
				<div id = "<?php echo $value['idMatricula']; ?>">
					<?php 
						if($estado === 'Aprobado'){
							//echo "Debe avanzar al grado siguiente";
							
							$objEstado->Avanzar($sede, $value['CODGRADO'], $value['grupo'], $value['idMatricula'], $anho);
						} 
					 ?>
					<!-- -->
				</div>
			</td>    
		</tr>  			
	<?php }	 ?>		
</tbody>
<tfoot>
</tfoot>
</table>