<!-- <table cellspacing="0" cellpadding="0" style="width:100%; margin:0 auto; border-collapse:collapse;border:1px;"> -->
<table style='width:100%; margin:0 auto; border-collapse:collapse;' >
	<tr>
		<td width='6%' valign=top style="width:6.52%; padding:3px">
			<div style="width: 80px; height: 80px;">
                <img src="<?php echo $escudo ?>" alt="Logo" style="position:relative;  width:90%; height:100%">				
			</div>
        </td>
		<td>
			<span lang=ES-AR style='font-size:12px'>
                <strong><?php echo $nombreInstitucion; ?></strong><br>
            </span>
            <div lang=ES-AR style="width:250px; font-size:9.0pt">
            	<?php echo $ciudad ?><br>
                <?php echo $aprobacion ?>
            </div>
		</td>
		<td></td>
	</tr>
	
</table>

<div style="letter-spacing: 2px; text-align: center;">
	<strong>	
	<?php 
		if ($objSede->totalSedes() > 1	) {
			foreach ($objSede->reportes() as $sedeN) {
		       echo "SEDE ".$sedeN['NOMSEDE'];
		    }
		}	

		$gradoR = "";
	?>		
	</strong>      	
</div>

<div  style="width:100%; margin-top:5px;">
	<div style="width: 50%;text-align: center; float:left; position: relative;">
		<table style="margin-left: 25%; width: 50%;text-align: center; float:left; position: relative; border: 1px solid #500; font-size: 10px;">
			<tr style="border-bottom: 1px solid #2d2d2d; height: 20px;">
				<th></th>
				<th>PONDERACION</th>
			</tr>
			<?php 
				$perMin = $objPeriodo->periodoMin();
				$perMax = $objPeriodo->periodoMax();
				for ($i= $perMin; $i <= $perMax ; $i++) { 
					$objPer = new Periodo();
					$objPer->periodo = $i; ?>
					<tr>
						<td><?php echo "Periodo ".$i ?></td>
						
					<?php 
					foreach ($objPer->valorPeriodo() as $valor) { ?>
						<td><?php echo $valor['valorPeriodo']; ?>%</td>
					<?php } ?>
					</tr>
				<?php } ?>
		</table>
	</div>
	<div style="width: 50%;text-align: center; float:left; position: relative;">
		<table style="margin-left: 20%; width: 60%;text-align: left; position: relative; border: 1px solid #500; font-size: 10px; margin-bottom: 10px;">
			<tr style="border-bottom: 1px solid #2d2d2d; height: 20px;">
				<th>VALORACION</th>
				<th>RANGO DE CALIFICACIONES</th>
			</tr>
			<?php
				$objD = new Desempenos();
                foreach ($objD->Listar() as $desemp) { ?>  
				<tr>
					<td><strong style="margin-left: 5px;"><?php echo $desemp['CONCEPT'] ?></strong></td>
					<td><?php echo "de ".$desemp['limiteInf']." hasta ".$desemp['limiteSup'] ?></td>
				</tr>
            <?php } 
            ?>
		</table>
	</div>	
</div>
<div style='width:100%; margin-top:10px; border-collapse:collapse;'>
	<table style='width:100%; margin:0px; margin-top: 10px; border-collapse:collapse; font-size: 12px;'>
		<tr style="border-bottom: 1px solid #2d2d2d; height: 20px;">
			<td >
				<strong>Estudiante: </strong>
 				<?php echo $campo['PrimerNombre']." ".$campo['SegundoNombre']." ".$campo['PrimerApellido']." ".$campo['SegundoApellido'] ?>
 			</td>
			<td>
				<strong>Código: </strong>
				<?php echo $campo['num_interno'] ?>
			</td>
			<td>
				<strong>No. de Lista: </strong> 
				<?php 
				$objNumeroLista = new Estudiante();
				$objNumeroLista->sede= $sede;
                $objNumeroLista->curso= $curso;
                $objNumeroLista->anho= $anho;
				echo $objNumeroLista->numeroEnLista($idMatricula);
				?>
			</td>
		</tr>
		<tr  style="border-bottom: 1px solid #2d2d2d; height: 20px;">
			<td>
				<strong>Nivel: </strong>				
				<?php 
                foreach ($objNivel->segunCurso() as $key => $nivel) {
                    echo $nivel['NOMBRE_NIVEL'];
                }
            	?>
			</td>
			<td>
				<strong>Curso:</strong>	<?php echo $campo['CODGRADO']."°".$campo['grupo'] ?></td>
			<td>
				<strong>Jornada: </strong> <?php echo $campo['jornada'] ?>
			</td>
		</tr>
		<tr  style="border-bottom: 1px solid #2d2d2d; height: 20px;">
			<td>
				<strong>Año: </strong> <?php echo $campo['anho'] ?>
				<strong style="margin-left: 100px;">Periodo: </strong><?php echo $periodoBol ?>
			</td>
			<td>
				<strong>Promedio</strong>
				<?php
					$gradoR = $campo['CODGRADO']."°";
					$objAreas = new Area();
					$objAreas->idGrado = $campo['CODGRADO'];
					$objAreas->codSede = $sede;
					$objAreas->anho = $anho;
					$totalAreas = $objAreas->totalAreas();
					
					$objCalificacion = new Calificacion();
					$objCalificacion->idMatricula = $campo['idMatricula'];   
                    $objCalificacion->curso = $curso;
			        $objCalificacion->grado = $campo['CODGRADO'];
			        // $objCalificacion->tipoPromedio = $campo['formaDePromediar'];
                    $objCalificacion->periodo = $periodoBol;
                    $objCalificacion->Anho = $anho;
                    
                    $promedio = $objCalificacion->promedioEstudiante();
                    //echo "<br>Total areas: ".$totalAreas;
                    //echo "<br>Suma de notas: ".$promedio;
					@$promedioEst = round(($promedio / $totalAreas),2);
                    echo  $promedioEst;
				?>
				<strong style="margin-left: 100px;">Puesto:</strong>
				<?php 
                    $objPuesto = new Puesto();
                    $objEstudiante = new Estudiante();
                    $objEstudiante->sede = $sede;
                    $objEstudiante->curso = $curso;
                    $objEstudiante->anho = $anho;
                    $objPuesto->idMatri = $campo['idMatricula'];   
                    $objPuesto->cur = $curso;
                    $objPuesto->anno = $anho;
                    $objPuesto->per = $periodoBol;
                    $objPuesto->listaEstudiantes = $objEstudiante->Listar();
                    $objPuesto->totalAreas = $totalAreas;
                    $objPuesto->promedioEstudiante = $promedioEst;
                    echo $objPuesto->puestoEstudiante();

					$areaNum = 0;
					$areasPerdidas = 0;
					$areaAplazada = "";
                ?>
			</td>
			<td>
				<strong>No. de estudiantes en el grado:</strong><?php echo $objEstudiante->totalEstudiantesXcurso(); ?>
			</td>
		</tr>
	</table>
</div>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
<span lang=ES-AR style='font-size:3.0pt'> &nbsp; </span>
</p>