<tr style=''>
	<td style='width:90.1pt;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
	<p class="mayusculas" style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
		<span lang=ES style='font-size:10.0pt'>
			<?php echo ($area['Nombre']) ?></strong>
		</span>
	</p>
	</td>
	<td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
		<p class="MsoNormal" align="center" style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
			<strong>
				<span style='font-family: Arial,sans-serif; font-size: 0.7em'>    
				     <!--INTENSIDAD HORARIA */-->
	                 <?php echo $area['intensidad'] ?>
	                 
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
		$obj->codArea = $area['id'];
		$obj->curso = $curso;
		$obj->Anho  = $anho;
		$obj->periodo = $i;
        $obj->grado = $area['idGrado'];
        $obj->tipoPromedio = $area['formaDePromediar'];
		$notaArea = 0;
		$notaPromedioArea = 0;
		$inasistencias  = 0;
		$tabla = "Area";
		foreach ($obj->cargar() as  $value) {
		 	$notaArea = $value['NOTA'];
		 	$inasistencias  = $value['Faltas'];
		} 

		if($notaArea > 0){//En caso de que no se pueda promediar si tiene nota directa
			//NOTA  
			?>
			<td style='width:20pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>
		        <p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:center; line-height:normal'>
					<span lang=ES-AR style='font-size:12.0pt'>
						<?php echo number_format($notaArea, 1, '.', '');   ?>							                               
		            </span>
				</p>
		    </td>
		<?php 
		}else{
			$tabla = "Asignatura";
			//en caso de que no exista nota en el area se coloca el espacio vacio
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
			<span lang=ES-AR style='font-size:10.0pt'>
			<?php
				//DESEMPEÑO
                $objDesempenho = new Desempenos();

                if($notaPromedioArea > 0){
                	$objDesempenho->nota = $notaPromedioArea;
                	echo $objDesempenho->cargar();
				}elseif($notaArea > 0){ 
					$objDesempenho->nota = $notaArea;
                	echo $objDesempenho->cargar();
				}  
			?>
			</span>
		</p>
	</td>
	<td style='width:20;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding:0cm 5.4pt 0cm 5.4pt;'>
		<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
			<span lang=ES-AR style='font-size:10.0pt'>
				<!-- //FALTAS -->
				<?php echo $inasistencias ?>
			</span>
		</p>
	</td>
	<?php 
		if ($tipoLogros != "ninguno") {
	?>
	<td style='width:90.1pt; border-top:solid windowtext 1.0pt; border-left:solid windowtext 1.5pt; border-bottom:none;border-right:solid windowtext 1.5pt;padding:0cm 5pt 0cm 5pt;'>
		<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
			<span lang=ES style='font-size:6.0pt'>
				<?php 
				//LOGROS	            
    			if ($tipoLogros == "criterios") {
    				foreach ($obj->listarNotasPorCriterio() as $nc) {    					
			            $objLogros = new Logro();
		                $objLogros->periodo = $periodoBol;
		                $objLogros->codCurso = $curso;
		                $objLogros->codArea = $area['id'];
		    			$objLogros->tabla = $tabla;
    					$objLogros->calificacion = $nc['nota'];
    					$objLogros->codCriterio = $nc['idCriterio'];
		            	$objLogros->cargarLogrosCriterios();
    				}
    			}else{
    				$objLogros = new Logro();
	                $objLogros->periodo = $periodoBol;
	                $objLogros->codCurso = $curso;
	                $objLogros->codArea = $area['id'];
	    			$objLogros->tabla = $tabla;
		            if($notaPromedioArea > 0){
						$objLogros->calificacion = $notaPromedioArea;
		            	$objLogros->cargar();
					}elseif($notaArea > 0){ 
						$objLogros->calificacion = $notaArea;
		            	$objLogros->cargar();
					}

    			}
            	?>
			</span>
		</p>
	</td>
	<?php 
		}
	 ?>					
</tr>
