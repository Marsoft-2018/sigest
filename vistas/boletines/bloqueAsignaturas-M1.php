<?php 
	$objIh = new Asignatura();
	$objIh->id = $asignatura['id'];
	$objIh->idGrado = $area['idGrado'];

?>

<tr style=''>
	<td style='width:90.1pt; border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding: 1px;'>
	<p >
		<span style='font-size:0.6em; margin-left: 10%;'>
			<?php echo $area['Abreviatura']." | ".strtoupper ($asignatura['Nombre']) ?></strong>
		</span>
	</p>
	</td>
	<td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
		<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
			<strong>
				<span lang=ES-AR style='font-family:Arial,sans-serif;font-size:6.0pt'>
				    <!--INTENSIDAD HORARIA */-->
	                <?php 
	                	echo $objIh->intensidad(); 
	                ?>	                 
	    		</span>
			</strong>
		</p>
	</td>
	<!-- //Espacio para las notas
	//Verifico si se puede promediar con las asignaturas en cada periodo-->
	<?php  
	for( $i = 1; $i <= $periodoBol; $i++) {
		$obj = new Calificacion();
		$obj->idMatricula = $idMatricula;
		$obj->idAsignatura = $asignatura['id'];
		$obj->curso = $curso;
		$obj->Anho  = $anho;
		$obj->periodo = $i;
		$notaAsignatura = 0;
		$inasistencias  = 0;

		foreach ($obj->notaAsignatura() as  $val) {
		 	$notaAsignatura = $val['NOTA'];
		 	$inasistencias  = $val['Faltas'];
		} 

		if($notaAsignatura > 0){//En caso de que no se pueda promediar si tiene nota directa
			//NOTA  
			?>
			<td style='width:20pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>
		        <p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:center; '>
					<span lang=ES-AR style='font-size:0.7em'>
						<?php echo number_format($notaAsignatura, 1, '.', '');   ?>							                               
		            </span>
				</p>
		    </td>
		<?php 
		}else{//en caso de que no exista nota en el area se coloca el espacio vacio
		?>
			<td style='width:20pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>
		        <p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:center; line-height:normal'>
					<span lang=ES-AR style='font-size:12.0pt'></span>
				</p>
		    </td>
		<?php
		}
	}?>
	<td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
		<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>
			<span lang=ES-AR style='font-size:0.6em'>
			<?php
				//DESEMPEÑO
                $objDesempenho = new Desempenos();

                if($notaAsignatura > 0){ 
					$objDesempenho->nota = $notaAsignatura;
                	echo $objDesempenho->cargar();
				}  
			?>
			</span>
		</p>
	</td>
	<td style='width:20;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding:0cm 5.4pt 0cm 5.4pt;'>
		<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
			<span lang=ES-AR style='font-size:0.6em'>
				<!-- //FALTAS -->
				<?php echo $inasistencias ?>
			</span>
		</p>
	</td>
	<td style='width:90.1pt; border-top:none; border-left:solid windowtext 1.5pt; border-bottom:none;border-right:solid windowtext 1.5pt;padding:0cm 5pt 0cm 5pt;'>
		<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
			<span lang=ES style='font-size:6.0pt'>
				<?php 
				//LOGROS
	            $objLogros = new Logro();
                $objLogros->periodo = $periodoBol;
                $objLogros->codCurso = $curso;
                $objLogros->codArea = $asignatura['id'];
    			$objLogros->tabla = "Asignatura";
	            if($notaPromedioArea > 0){
					$objLogros->calificacion = $notaPromedioArea;
	            	$objLogros->cargar();
				}elseif($notaAsignatura > 0){ 
					$objLogros->calificacion = $notaAsignatura;
	            	$objLogros->cargar();
				}
            	?>
			</span>
		</p>
	</td>					
</tr>
