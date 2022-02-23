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

<div  style="width:100%; margin-top:5px; text-align:center;">
<h3>INFORME ACADÉMICO Y DE CONVIVENCIA</h3>
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
				<strong>Curso:</strong>	<?php echo $campo['NOMGRADO'] ?></td>
			<td>
				<strong>Año: </strong> <?php echo $campo['anho'] ?>
				<strong style="margin-left: 100px;">Periodo: </strong><?php echo $periodoBol ?>
			</td>
		</tr>
	</table>
</div>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal'>
<span lang=ES-AR style='font-size:3.0pt'> &nbsp; </span>
</p>