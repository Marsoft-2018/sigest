<!-- <table cellspacing="0" cellpadding="0" style="width:100%; margin:0 auto; border-collapse:collapse;border:1px;"> -->
<table style='width:100%; margin:0 auto; border-collapse:collapse;' >
	<tr>
		<td width='6%' valign=top style="width:6.52%; padding:3px">
			<div style="width: 70px; height: 70px;">
                <img src="../vistas/img/<?php echo $escudo ?>" alt="Logo" style="position:relative;  width:90%; height:100%">				
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

<div style="letter-spacing: 2px; text-align: center; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: flex-end; align-items: center; align-content: stretch; ">
	<div  style="width: 70%;">
		<?php 
		if ($objSede->totalSedes() > 1	) {
			foreach ($objSede->reportes() as $sedeN) {
				echo '<h4 style="letter-spacing: 5px;font-style: italic;">
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LIBRO FINAL DE CALIFICACIONES
				</h4>';
		       //echo "<strong>SEDE ".$sedeN['NOMSEDE']."</strong> ";
		    }
		}else{
			echo "<h4>LIBRO FINAL DE CALIFICACIONES</h4>";
		}	    
		?>		
	</div>
	<div style="width: 180px; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: flex-end; align-items: center; align-content: stretch; ">
		<div>Folio:</div> <div style="width: 80px; border: 1px solid; padding: 15px;"></div>
	</div>     	
</div>
<div style='width:100%; margin-top:10px; border-collapse:collapse;'>
	<table style='width:100%; margin:0px; margin-top: 10px; border-collapse:collapse; font-size: 15px;'>
		<tr style="height: 20px;">
			<td  style="width: 60%;">
				Alumno: 
				<strong>
 				<?php 
 				    $nombre_completo =   $campo['PrimerNombre']." ".$campo['SegundoNombre']." ".$campo['PrimerApellido']." ".$campo['SegundoApellido'];
 				    echo $nombre_completo;
 				
 				?>					
 				</strong>
 			</td>
			<td>
				Código: 
				<strong><?php echo $campo['num_interno'] ?></strong>
			</td>
			<td>
				Grado:	<strong><?php echo $nombreGrado ?></strong>
			<td>
			<td>
				Año:  <strong><?php echo $campo['anho'] ?></strong>
			</td>
		</tr><!-- 
		<tr  style="height: 20px;">			
			<td colspan="4">
				Promedio:
				<strong  style="margin-right: 50px;">
									
				</strong>
				Desempeño: <strong></strong>	
			</td>
		</tr> -->
		<?php 
			$promedioFinal = 0;
			$desPromedio = "";
			$areaNum = 0;
			$areasPerdidas = 0;
		?>
	</table>
</div>
<br>
<div>
	<table  cellspacing=0 cellpadding=0 width='100%' class="bloq-areas" style='width:100%; margin:0 auto; border-collapse:collapse;'>
	    <thead>
	        <tr>
	            <th style='text-align:center; border:1px solid; text-align:center;'>AREAS/Asignaturas: </th>
	            <th style='text-align:center; border:1px solid; text-align:center;'>I.H.S</th>
	            <?php            
	                foreach ($objPeriodo->cargar() as $per) {
	                    echo "<th style='text-align:center; border:1px solid;'>";
	                    echo "Per. ".$per['periodo']."<br>";
	                    echo "<i style='font-size: 12px;'>".$per['valorPeriodo']."%</i>";      
	                    echo "</th>";
	                }
	            ?> 
	            <th style='text-align:center; border:1px solid;'>Total <br>Inasist</th>
	            <th style='text-align:center; border:1px solid;'>Acum. <br>Final</th>
	            <th style='text-align:center; border:1px solid;'>Desempeños</th>
	        </tr>
	    </thead>
	    <tbody>
		<?php 
	        foreach ($sqlAreas as $key => $area) {
	            include("../vistas/boletines/finales/bloqueAreas-M2.php");
	        }
	    ?> 
		