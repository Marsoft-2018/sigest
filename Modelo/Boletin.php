<?php
	require("logros.php");
	require("puesto.php");
	class Boletin extends ConectarPDO{
		private $sqlEstudiantes;
		private $sqlEncabezado;
		public function ConsultaEstudiantes($sede,$curso,$anho,$Rinicio,$registros){
			$this->sqlEstudiantes = mysql_query("SELECT est.`Documento`,est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`, est.`SegundoNombre`, mt.`idMatricula`, est.`sexo`, est.`tipoDocumento` FROM estudiantes est INNER JOIN matriculas mt ON mt.Documento = est.Documento WHERE mt.`codsede`='$sede' AND mt.`Curso`='$curso' AND mt.`estado`='Matriculado' AND mt.anho = '$anho' ORDER BY est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre` DESC LIMIT $Rinicio, $registros;") or die ("Existe un error en la consulta de las notas o NO HAY ESTUDIANTES CON NOTAS PARA ESTE CURSO<br>Error: ".mysql_error());
			return $this->sqlEstudiantes;
		}

		public function ConsultaEstudiantesEspecificos($sede,$curso,$estudiantes,$anho,$Rinicio,$registros){

			$sqlString = "SELECT est.`Documento`,est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`, est.`SegundoNombre`, mt.`idMatricula`, est.`sexo`, est.`tipoDocumento` FROM estudiantes est INNER JOIN matriculas mt ON mt.Documento = est.Documento WHERE mt.`codsede`='$sede' AND mt.`Curso`='$curso' AND mt.anho = '$anho' ";
			for($i = 0;$i < sizeof($estudiantes); $i++ ){
				if($i == 0){
					$sqlString .= " AND mt.`idMatricula` = '$estudiantes[$i]'";
				}else{
					$sqlString .= " OR mt.`idMatricula` = '$estudiantes[$i]'";
				}
			}

			$sqlString .= " ORDER BY est.`PrimerApellido`, est.`SegundoApellido`, est.`PrimerNombre`, est.`SegundoNombre` DESC LIMIT $Rinicio, $registros;";

			$this->sqlEstudiantes = mysql_query($sqlString) or die ("Existe un error en la consulta de las notas o NO HAY ESTUDIANTES CON NOTAS PARA ESTE CURSO<br>Error: ".mysql_error());
			return $this->sqlEstudiantes;
		}

		public function ConsultaEncabezado($centro,$sede,$curso,$anho,$idMatricula){
			$this->sqlEncabezado = mysql_query("SELECT DISTINCTROW cent.`NOMBREINST`,cent.`regdane`,cent.`nit`,cent.`direccion`,cent.`tel`,cent.`Logo`,sedes.`nomsede`, mat.`Documento`,alum.`PrimerNombre`,alum.`SegundoNombre`,alum.`PrimerApellido`,alum.`SegundoApellido`,grados.`NOMGRADO`,cursos.`codCurso`,cursos.`CODGRADO`,cursos.`grupo`,jornadas.`Nombre`, prof.`PrimerNombre`,prof.`SegundoNombre`,prof.`PrimerApellido`,prof.`SegundoApellido`,niveles.`NOMBRE_NIVEL`, cent.`ICFES`,cent.`RESOLUCION`,cent.`CORREO`,cent.`CIUDAD`,cent.`RECTOR`,cent.`membrete`,alum.`sexo`,alum.`tipoDocumento`,mat.`idMatricula`  FROM matriculas mat INNER JOIN estudiantes alum ON mat.`Documento` = alum.`Documento` INNER JOIN cursos ON cursos.`codCurso` = mat.`Curso` INNER JOIN jornadas ON jornadas.`idJornada`=cursos.`idJornada`INNER JOIN grados ON grados.`CODGRADO`=cursos.`CODGRADO` INNER JOIN niveles ON niveles.`CODNIVEL`=grados.`CODNIVEL` INNER JOIN sedes ON sedes.`CODSEDE`=mat.`codsede` INNER JOIN centroeducativo cent ON sedes.`CODINST`=cent.`CODINST` INNER JOIN direccioncursos dirc ON dirc.codCurso = cursos.`codCurso` INNER JOIN profesores prof ON prof.`IDUsuario` = dirc.codProfesor WHERE cent.codinst='$centro' AND sedes.codsede='$sede' AND mat.`Curso`='$curso' AND mat.`estado`='Matriculado' AND mat.`idMatricula`='$idMatricula'") or die ("Existe un error en la consulta de los datos para el encabezado del boletin<br>Error: ".mysql_error());
			return $this->sqlEncabezado;
		}

        public function bloqueAreas($anho,$periodoBol,$alumnoe,$centro,$curso,$sede){
            $campoIH=0;
             //consulta para optener el nombre del campo para el grado
            $sql_grado=mysql_query("SELECT gr.nomCampo FROM grados gr INNER JOIN cursos cr ON cr.`CODGRADO`=gr.`CODGRADO` WHERE cr.`codCurso`='$curso';");
            while($ng=mysql_fetch_array($sql_grado)){
                $campoIH=$ng[0];
            }
            //Consulta para recorrer todas las areas de la sede
            $notaPromedio;
            $sqlAreasEnsede=mysql_query("SELECT axs.`idAreaSede`,axs.`formaDePromediar`,axs.`Nombre` FROM areasxsedes axs WHERE axs.`CODSEDE`='$sede' AND `$campoIH`<>0;");
            
            while($fila2 = mysql_fetch_array($sqlAreasEnsede)){
            	$notaPromedio = 0;//esta variable almacenara el promedio del área
            	$notaDirecta = 0;//esta variable almacenara en caso de quel el area tenga notas directas
	            //Busco las asignaturas que dependen del área con el código que esta en la variable $codArea
	            $sql_Asignaturas = mysql_query("SELECT * FROM asignaturas_sedes axs WHERE axs.idarea='$fila2[0]' AND axs.`$campoIH`<>0;");
	            $rAsign=mysql_num_rows($sql_Asignaturas);//--- almaceno la cantidad de registro para conocer si hubo algun resultado
	            if($rAsign>0){// Verifico si existe algun registro relacionado con la consulta 
	                /// como existe almenos una asignatura en el área imprimo primero la fila del area y luego las filas de las asignaturas
	                echo "<tr style=''>
							<td style='width:90.1pt;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
							<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
								<span lang=ES style='font-size:10.0pt'>"
									/*NOMBRE DE LA MATERIA */.utf8_encode($fila2[2]).
								"</span>
							</p>
							</td>
							<td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
							<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
								<b>
									<span lang=ES-AR style='font-family:Arial,sans-serif;font-size:6.0pt'>";
	                        
									/*INTENSIDAD HORARIA */
	                                $sql_horasAreas=mysql_query("SELECT `$campoIH` FROM areasxsedes WHERE idAreaSede='$fila2[0]';");
	                                while($ho=mysql_fetch_array($sql_horasAreas)){
	                                    echo $ho[0];
	                                    $totalHoras=$ho[0];
	                                }                                
	                        echo "</span>";
							echo "</b>";
							echo "</p>";
							echo "</td>";
							//Espacio para las notas
							//Verifico si se puede promediar con las asignaturas en cada periodo
							for( $i = 1; $i <= $periodoBol; $i++){
								$notaPromedio = $this->promedioAreas($centro, $totalHoras, $fila2[0], $anho, $i, $alumnoe, $fila2[1], $campoIH);
								$notaDirecta = $this->BuscaNotaArea($anho,$i,$fila2[0],$alumnoe); 
								if($notaPromedio > 0){

									echo "<td style='width:20pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
										echo "<p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:center; line-height:normal'>";
										echo "<span lang=ES-AR style='font-size:12.0pt'>";
												// NOTA   
	                               				// Aquí cargo el metodo para calcular el promedio del area dependiendo de la forma de promediarla
	                                			echo number_format($notaPromedio, 1, '.', '');
										echo "</span>";
										echo "</p>";
									echo "</td>";
								}elseif($notaDirecta > 0){//En caso de que no se pueda promediar si tiene nota directa
									echo "<td style='width:20pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
		                            echo    "<p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:center; line-height:normal'>
												<span lang=ES-AR style='font-size:12.0pt'>";
													//NOTA                                 
		                            echo number_format($notaDirecta, 1, '.', '');                
									echo "		</span>
											</p>";
		                            echo "</td>"; 
								}else{//en caso de que no exista nota en el area se coloca el espacio vacio
									echo "<td style='width:20pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
		                            echo    "<p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:center; line-height:normal'>
												<span lang=ES-AR style='font-size:12.0pt'>";
									              
									echo "		</span>
											</p>";
		                            echo "</td>";
								}
							}
							

							
							echo "<td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
								<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>
								<span lang=ES-AR style='font-size:10.0pt'>";
									//DESEMPEÑO
	                                $objDes=new Desempenho();
	                                if($notaPromedio > 0){
	                                	echo $objDes->cargar($notaPromedio,$centro);
									}elseif($notaDirecta > 0){ 
	                                	echo $objDes->cargar($notaDirecta,$centro);
									}
							echo	"</span>
							</p>
							</td>
							<td style='width:20;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding:0cm 5.4pt 0cm 5.4pt;'>
							<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
								<span lang=ES-AR style='font-size:10.0pt'>";
									//FALTAS
	                                $faltas=$this->buscarFaltas($anho,$periodoBol,$fila2[0],$alumnoe);
	                                echo $faltas;
							echo	"</span>
							</p>
							</td>
							<td style='width:90.1pt;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 0.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5pt 0cm 5pt;'>
							<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
								<span lang=ES style='font-size:5.0pt'>";
									//LOGROS
	                                $objLogro=new Logro();
	                                if($notaPromedio > 0){
	                                	$objLogro->cargar($periodoBol,$fila2[0],$notaPromedio,$centro,$curso);
									}elseif($notaDirecta > 0){ 
	                                	$objLogro->cargar($periodoBol,$fila2[0],$notaDirecta,$centro,$curso);
									}
							echo	"</span>
							</p>
							</td>";						
					echo "</tr>";
	                
	                while($as=mysql_fetch_array($sql_Asignaturas)){//Recorro las asignaturas encontradas y busco las notas de cada una de ellas 
	                    //----- Consulto las notas almacenadas para el estudiante en la asignatura, en el periodo y año correspondiente
	                    /*
	                    $resultnotasAsig=$this->buscaNotaAsig($anho,$periodoBol,$as[1],$alumnoe);
	                    if($resultnotasAsig!='NO'){
	                        //se imprime la fila de la asignatura con todos los datos
	                        echo $this->filaAsignaturas1($as[1],$as[3],$campoIH,$resultnotasAsig,$anho,$periodoBol,$alumnoe,$centro,$curso);
	                    }else{
	                        //se imprime la fila de la asignatura con los datos vacios
	                        echo $this->filaAsignaturas0($as[1],$as[3],$campoIH,$resultnotasAsig,$anho,$periodoBol,$alumnoe,$centro,$curso); 
	                    }
						*/
	                    echo "
					<tr style=''>
						<td style='width:90.1pt;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
						<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
							<span lang=ES style='font-size:10.0pt'>"
								/*NOMBRE DE LA MATERIA */.utf8_encode($as[3]).
							"</span>
						</p>
						</td>
						<td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
						<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
							<b>
								<span lang=ES-AR style='font-family:Arial,sans-serif;font-size:6.0pt'>";
                        
								/*INTENSIDAD HORARIA */
                                $sql_horasAsignaturas = mysql_query("SELECT `$campoIH` FROM asignaturas_sedes WHERE codAsig = '$as[1]';");
                                while($ho=mysql_fetch_array($sql_horasAsignaturas)){
                                    echo $ho[0];
                                }                                
                        echo "</span>
							</b>
						</p>
						</td>";
						for($i = 1; $i<=$periodoBol;$i++){
                            echo "<td style='width:20pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
                            echo    "<p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:center; line-height:normal'>
										<span lang=ES-AR style='font-size:12.0pt'>";
											/*NOTA */    
										$resultnotasAsig = $this->buscaNotaAsig($anho,$i,$as[1],$alumnoe);
					                    if($resultnotasAsig != 0){                               
                                			echo number_format($resultnotasAsig, 1, '.', '');           
					                    }              
							echo "		</span>
									</p>";
                            echo "</td>";
                        }
						echo	"<td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
							<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>
							<span lang=ES-AR style='font-size:10.0pt'>";
								/*DESEMPEÑO .$fila2[3].*/
                                $objDes = new Desempenho();
                                $notaAsignatura=$this->buscaNotaAsig($anho,$periodoBol,$as[1],$alumnoe);
                                if($notaAsignatura > 0){
                                	echo $objDes->cargar($notaAsignatura,$centro);
								}
						echo	"</span>
						</p>
						</td>
						<td style='width:20;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding:0cm 5.4pt 0cm 5.4pt;'>
						<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
							<span lang=ES-AR style='font-size:10.0pt'>";
								/*FALTAS */
                                $faltas=$this->buscarFaltas($anho,$periodoBol,$as[1],$alumnoe);
                                echo $faltas;
						echo	"</span>
						</p>
						</td>
						<td style='width:90.1pt;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 0pt;border-right:solid windowtext 1.5pt;padding:0cm 5pt 0cm 5pt;'>
						<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
							<span lang=ES style='font-size:5.0pt'>";
								/*Logros .utf8_encode($fila2[0]).*/
                                $objLogro=new Logro();
                                $notaAsignatura=$this->buscaNotaAsig($anho,$periodoBol,$as[1],$alumnoe);
                                if($notaAsignatura > 0){
                                	$objLogro->cargar($periodoBol,$as[1],$notaAsignatura,$centro,$curso);
								}
						echo	"</span>
						</p>
						</td>";
						
					echo "</tr>";

	                }                                
	            }else{// esta es la nueva programacion para mostrar todos los periodos transcurridos	
	            
	            	echo "<tr style=''>
							<td style='width:90.1pt;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
							<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
								<span lang=ES style='font-size:10.0pt'>";
									//NOMBRE DE LA MATERIA 
									echo utf8_encode($fila2[2]);
								echo "</span>
							</p>
							</td>
							<td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
							<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
								<b>
									<span lang=ES-AR style='font-family:Arial,sans-serif;font-size:6.0pt'>";
	                        
									//INTENSIDAD HORARIA
	                                $sql_horasAreas=mysql_query("SELECT `$campoIH` FROM areasxsedes WHERE idAreaSede='$fila2[0]';");
	                                while($ho=mysql_fetch_array($sql_horasAreas)){
	                                    echo $ho[0];
	                                }                                
	                        echo "</span>
								</b>
							</p>
							</td>";
							for($i = 1; $i<=$periodoBol;$i++){
	                            echo "<td style='width:20pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
	                            echo    "<p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:center; line-height:normal'>
											<span lang=ES-AR style='font-size:12.0pt'>";
												//NOTA                                 
	                            echo number_format($this->BuscaNotaArea($anho,$i,$fila2[0],$alumnoe), 1, '.', '');                
								echo "		</span>
										</p>";
	                            echo "</td>";
	                        }
							echo	"<td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
								<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>
								<span lang=ES-AR style='font-size:10.0pt'>";
									//DESEMPEÑO .$fila2[3]
	                                $objDes=new Desempenho();
	                                echo $objDes->cargar($this->BuscaNotaArea($anho,$periodoBol,$fila2[0],$alumnoe),$centro);
							echo	"</span>
							</p>
							</td>
							<td style='width:20;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
					echo 		"<p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:center;line-height:normal'>";
					echo 			"<span lang=ES-AR style='font-size:10.0pt'>";
									//FALTAS 
	                                	$faltas = $this->buscarFaltas($anho,$periodoBol,$fila2[0],$alumnoe);
	                                	echo $faltas;
					echo			"</span>";
					echo 		"</p>";
					echo 	"</td>";
					echo 	"<td style='width:90.1pt;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5pt 0cm 5pt;'>";
					echo 		"<p class=MsoNormal style='margin-bottom:0cm; margin-bottom:.0001pt; line-height: normal'>";
					echo			"<span lang=ES style='font-size:5.0pt'>";
									//Logros .utf8_encode($fila2[0]).
	                                $objLogro=new Logro();
	                                $objLogro->cargar($periodoBol,$fila2[0],$this->BuscaNotaArea($anho,$periodoBol,$fila2[0],$alumnoe),$centro,$curso);
					echo			"</span>";
					echo 		"</p>";
					echo 	"</td>";							
					echo "</tr>";
	            }  
            }
			//echo "</table>";					 
        }
        
        public function areaFilaTipo0($codArea,$nomArea,$campoIH){
            echo "<tr style=''>
						<td style='width:90.1pt;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
						<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
							<span lang=ES style='font-size:10.0pt'>";
								/*NOMBRE DE LA MATERIA */
                        echo utf8_encode($nomArea);
				        echo "</span>
						</p>
						</td>
						<td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
						<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
							<b>
								<span lang=ES-AR style='font-family:Arial,sans-serif;font-size:6.0pt'>";
                        
								/*INTENSIDAD HORARIA */
                                $sql_horasAreas=mysql_query("SELECT `$campoIH` FROM areasxsedes WHERE idAreaSede='$codArea';");
                                while($ho=mysql_fetch_array($sql_horasAreas)){
                                    echo $ho[0];
                                }                                
                        echo "</span>
							</b>
						</p>
						</td>";
						for($i = 1; $i<=4;$i++){
                            echo "<td style='width:10pt;border-top:none;border-left:none; border-bottom:solid black 1.5pt; border-right:solid black 1.0pt; padding:0cm 5.4pt 0cm 5.4pt'>";
                            echo    "<p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:center; line-height:normal'>
                                        <span lang=ES-AR style='font-size:10.0pt'>NOTA P".$i."</span>
                                    </p>";
                            echo "</td>";
                        }
								             
						echo	"
						<td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
							<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>
							<span lang=ES-AR style='font-size:10.0pt'>";
                               
						echo	"</span>
						</p>
						</td>
						<td style='width:20;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding:0cm 5.4pt 0cm 5.4pt;'>
						<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
							<span lang=ES-AR style='font-size:10.0pt'>";
                                
						echo	"</span>
						</p>
						</td>
						<td style='width:90.1pt;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5pt 0cm 5pt;'>
						<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
							<span lang=ES style='font-size:5.0pt'>";
                                
						echo	"</span>
						</p>
						</td>";
						
					echo "</tr>";
        }//OK
        
        public function areaFilaTipo1($codArea,$nomArea,$campoIH,$nota,$anho,$periodoBol,$alumnoe,$centro,$curso){
            echo "
					<tr style=''>
						<td style='width:90.1pt;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
						<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
							<span lang=ES style='font-size:10.0pt'>"
								/*NOMBRE DE LA MATERIA */.utf8_encode($nomArea).
							"</span>
						</p>
						</td>
						<td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
						<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
							<b>
								<span lang=ES-AR style='font-family:Arial,sans-serif;font-size:6.0pt'>";
                        
								/*INTENSIDAD HORARIA */
                                $sql_horasAreas=mysql_query("SELECT `$campoIH` FROM areasxsedes WHERE idAreaSede='$codArea';");
                                while($ho=mysql_fetch_array($sql_horasAreas)){
                                    echo $ho[0];
                                }                                
                        echo "</span>
							</b>
						</p>
						</td>";
						for($i = 1; $i<=$periodoBol;$i++){
                            echo "<td style='width:20pt; border-top:none; border-left:none; border-bottom:solid windowtext 1.0pt; border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
                            echo    "<p class=MsoNormal align=center style='margin-bottom:0cm; margin-bottom:.0001pt; text-align:center; line-height:normal'>
										<span lang=ES-AR style='font-size:12.0pt'>";
											/*NOTA */                                    
                                		echo number_format($nota, 1, '.', '');                
							echo "		</span>
									</p>";
                            echo "</td>";
                        }
						echo	"<td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
							<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>
							<span lang=ES-AR style='font-size:10.0pt'>";
								/*DESEMPEÑO .$fila2[3].*/
                                $objDes=new Desempenho();
                                echo $objDes->cargar($nota,$centro);
						echo	"</span>
						</p>
						</td>
						<td style='width:20;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding:0cm 5.4pt 0cm 5.4pt;'>
						<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
							<span lang=ES-AR style='font-size:10.0pt'>";
								/*FALTAS */
                                $faltas=$this->buscarFaltas($anho,$periodoBol,$codArea,$alumnoe);
                                echo $faltas;
						echo	"</span>
						</p>
						</td>
						<td style='width:90.1pt;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5pt 0cm 5pt;'>
						<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
							<span lang=ES style='font-size:5.0pt'>";
								/*Logros .utf8_encode($fila2[0]).*/
                                $objLogro=new Logro();
                                $objLogro->cargar($periodoBol,$codArea,$nota,$centro,$curso);
						echo	"</span>
						</p>
						</td>";
						
					echo "</tr>";
        }//OK
        
        public function areaFilaTipo2($codArea,$nomArea,$campoIH,$anho,$periodoBol,$alumnoe,$centro,$curso,$tipoPromedio){
            $notaPromedio=4;//esta variable almacenara el promedio del área
            //Busco las asignaturas que dependen del área con el código que esta en la variable $codArea
            $sql_Asignaturas=mysql_query("SELECT * FROM asignaturas_sedes axs WHERE axs.idarea='$codArea' AND axs.`$campoIH`<>0;");
            $rAsign=mysql_num_rows($sql_Asignaturas);//--- almaceno la cantidad de registro para conocer si hubo algun resultado
            if($rAsign>0){// Verifico si existe algun registro relacionado con la consulta 
                /// como existe almenos una asignatura en el área imprimo primero la fila del area y luego las filas de las asignaturas
                echo "<tr style=''>
						<td style='width:90.1pt;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
						<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
							<span lang=ES style='font-size:10.0pt'>"
								/*NOMBRE DE LA MATERIA */.utf8_encode($nomArea).
							"</span>
						</p>
						</td>
						<td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
						<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
							<b>
								<span lang=ES-AR style='font-family:Arial,sans-serif;font-size:6.0pt'>";
                        
								/*INTENSIDAD HORARIA */
                                $sql_horasAreas=mysql_query("SELECT `$campoIH` FROM areasxsedes WHERE idAreaSede='$codArea';");
                                while($ho=mysql_fetch_array($sql_horasAreas)){
                                    echo $ho[0];
                                    $totalHoras=$ho[0];
                                }                                
                        echo "</span>
							</b>
						</p>
						</td>
						<td style='width:20pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
						<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
							<span lang=ES-AR style='font-size:12.0pt'>";
								/*NOTA */   
                                // Aquí cargo el metodo para calcular el promedio del area con las notas de las asignaturas
                               /*el calculo de la Nota promedio del area dependiendo de la forma de promediarla */
                                //$promedioArea=new Boletin();
                                $notaPromedio=$this->promedioAreas($centro,$totalHoras,$codArea,$anho,$periodoBol,$alumnoe,$tipoPromedio,$campoIH);
                                echo number_format($notaPromedio, 1, '.', '');
                                //echo number_format($nota, 1, '.', '');                
						echo	"</span>
						</p>
						</td>
						<td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
							<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>
							<span lang=ES-AR style='font-size:10.0pt'>";
								/*DESEMPEÑO .$fila2[3].*/
                                $objDes=new Desempenho();
                                echo $objDes->cargar($notaPromedio,$centro);
						echo	"</span>
						</p>
						</td>
						<td style='width:20;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding:0cm 5.4pt 0cm 5.4pt;'>
						<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
							<span lang=ES-AR style='font-size:10.0pt'>";
								/*FALTAS */
                                $faltas=$this->buscarFaltas($anho,$periodoBol,$codArea,$alumnoe);
                                echo $faltas;
						echo	"</span>
						</p>
						</td>
						<td style='width:90.1pt;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 0.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5pt 0cm 5pt;'>
						<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
							<span lang=ES style='font-size:5.0pt'>";
								/*Logros .utf8_encode($fila2[0]).*/
                                $objLogro=new Logro();
                                $objLogro->cargar($periodoBol,$codArea,$notaPromedio,$centro,$curso);
						echo	"</span>
						</p>
						</td>";						
				echo "</tr>";
                //Recorro las asignaturas encontradas y busco las notas de cada una de ellas 
                while($as=mysql_fetch_array($sql_Asignaturas)){
                    //----- Consulto las notas almacenadas para el estudiante en la asignatura, en el periodo y año correspondiente
                    $resultnotasAsig=$this->buscaNotaAsig($anho,$periodoBol,$as[1],$alumnoe);
                    if($resultnotasAsig!='NO'){
                        //se imprime la fila de la asignatura con todos los datos
                        echo $this->filaAsignaturas1($as[1],$as[3],$campoIH,$resultnotasAsig,$anho,$periodoBol,$alumnoe,$centro,$curso);
                    }else{
                        //se imprime la fila de la asignatura con los datos vacios
                        echo $this->filaAsignaturas0($as[1],$as[3],$campoIH,$resultnotasAsig,$anho,$periodoBol,$alumnoe,$centro,$curso); 
                    }       
                }                                
            }else{
                // Como no existen notas ni asignaturas para el área se imprime la fila tipo 0 del area con el metodo areaFilaTipo0  
                echo $this->areaFilaTipo0($codArea,$nomArea,$campoIH);
            }            
        }
        
        public function BuscaNotaArea($anho,$periodoBol,$area,$alumno){
            $notaResultante;
            $sqlNotas=mysql_query("SELECT notas.NOTA FROM notas WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$periodoBol' AND notas.`idMatricula`='$alumno' AND notas.`codArea`='$area';")or die("Error al traer la nota<br>Error: ".mysql_error()); 
                $tieneNotas=mysql_num_rows($sqlNotas);
                if($tieneNotas>0){
                    while($n=mysql_fetch_array($sqlNotas)){
                        $this->notaResultante=$n[0];
                    }
                }else{
                    $this->notaResultante = 0;
                }
                return $this->notaResultante;
            
        }//ok
        
        public function buscaNotaAsig($anho,$periodoBol,$codAsignatura,$alumno){
            $notaResultante;
            $sql_NotaAsi=mysql_query("SELECT nas.NOTA FROM notasasignaturas nas WHERE nas.`codAsignatura`='$codAsignatura' AND nas.`idMatricula`='$alumno' AND nas.`PERIODO`='$periodoBol' AND nas.anho='$anho'");
            $nNotas=mysql_num_rows($sql_NotaAsi);//--- almaceno la cantidad de registro para conocer si hubo algun resultado 
            if($nNotas>0){// Verifico si existe alguna nota almacenada 
                //Recorro el resultado de la consulta con las notas asignadas al estudiante en la asignatura
                while($nAs=mysql_fetch_array($sql_NotaAsi)){
                    $this->notaResultante=$nAs[0];
                }
            }else{
                $this->notaResultante = 0;
            }
            return $this->notaResultante;
            
        }//ok
        
        public function buscarFaltas($anho,$periodoBol,$area,$alumno){
            $faltaResultante;
            $sqlFaltas=mysql_query("SELECT notas.Faltas FROM notas WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$periodoBol' AND notas.`idMatricula`='$alumno' AND notas.`codArea`='$area';"); 
                $tieneFaltas=mysql_num_rows($sqlFaltas);
                if($tieneFaltas>0){
                    while($f=mysql_fetch_array($sqlFaltas)){
                        $this->faltaResultante=$f[0];
                    }
                }else{
                    $this->faltaResultante='0';
                }
                return $this->faltaResultante;
            
        }//ok       
        
        public function filaAsignaturas0($codAsignatura,$nomAsignatura,$campoIH){            
            //se ingresa a imprimir las asignaturas con sus notas
            echo "  <tr>
                        <td style='width:90.1pt;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 0.0pt;border-right:solid windowtext 1.5pt;'>
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal;'>
                            <span lang=ES style='font-size:8.0pt;margin-left:20px;'>- "
                                /*NOMBRE DE LA ASIGNATURA */.utf8_encode($nomAsignatura).
                            "</span>
                        </p>
                        </td>
                        <td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
                        <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                            <b>
                                <span lang=ES-AR style='font-family:Arial,sans-serif;font-size:6.0pt'>";
                                /*INTENSIDAD HORARIA */
                                $sql_horasAreas=mysql_query("SELECT `$campoIH` FROM asignaturas_sedes WHERE `codAsig`='$codAsignatura';");
                                while($ho=mysql_fetch_array($sql_horasAreas)){
                                    echo $ho[0];
                                }                                                 
                        echo   "</span>
                            </b>
                        </p>
                        </td>
                        <td style='width:20pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
                        <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                            <span lang=ES-AR style='font-size:8.0pt'>";
                                
                        echo "</span>
                        </p>
                        </td>
                        <td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
                            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>
                            <span lang=ES-AR style='font-size:7.0pt'>";
                                /*DESEMPEÑO */
                                
                        echo	"</span>
                        </p>
                        </td>
                        <td style='width:20;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding:0cm 5.4pt 0cm 5.4pt;'>
                        <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
                            <span lang=ES-AR style='font-size:7.0pt'>"
                                /*FALTAS */." ".
                            "</span>
                        </p>
                        </td>
                        <td style='width:90.1pt;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5pt 0cm 5pt;'>
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
                            <span lang=ES style='font-size:5.0pt'>";
                                /*Logros .utf8_encode($fila2[0]).*/
                                
                        echo	"</span>
                        </p>
                        </td>";
                echo "</tr>";
                        
        }//OK
        
        public function filaAsignaturas1($codAsignatura,$nomAsignatura,$campoIH,$nota,$anho,$periodoBol,$alumnoe,$centro,$curso){            
            //se ingresa a imprimir las asignaturas con sus notas
            echo "  <tr>
                        <td style='width:90.1pt;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 0.0pt;border-right:solid windowtext 1.5pt;'>
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal;'>
                            <span lang=ES style='font-size:8.0pt;margin-left:20px;'>- "
                                /*NOMBRE DE LA ASIGNATURA */.utf8_encode($nomAsignatura).
                            "</span>
                        </p>
                        </td>
                        <td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>
                        <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                            <b>
                                <span lang=ES-AR style='font-family:Arial,sans-serif;font-size:6.0pt'>";
                                /*INTENSIDAD HORARIA */
                                $sql_horasAreas=mysql_query("SELECT `$campoIH` FROM asignaturas_sedes WHERE `codAsig`='$codAsignatura';");
                                while($ho=mysql_fetch_array($sql_horasAreas)){
                                    echo $ho[0];
                                }                                                 
                        echo   "</span>
                            </b>
                        </p>
                        </td>
                        <td style='width:20pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
                        <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>
                            <span lang=ES-AR style='font-size:8.0pt'>"
                                /*NOTA */.number_format($nota, 1, '.', '').
                            "</span>
                        </p>
                        </td>
                        <td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>
                            <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>
                            <span lang=ES-AR style='font-size:7.0pt'>";
                                /*DESEMPEÑO */
                                $objDes=new Desempenho();
                                echo $objDes->cargar($nota,$centro);
                        echo	"</span>
                        </p>
                        </td>
                        <td style='width:20;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt; padding:0cm 5.4pt 0cm 5.4pt;'>
                        <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>
                            <span lang=ES-AR style='font-size:7.0pt'>"
                                /*FALTAS */." ".
                            "</span>
                        </p>
                        </td>
                        <td style='width:90.1pt;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5pt 0cm 5pt;'>
                        <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal'>
                            <span lang=ES style='font-size:5.0pt'>";
                                /*Logros .utf8_encode($fila2[0]).*/
                                $objLogro=new Logro();
                                $objLogro->cargar($periodoBol,$codAsignatura,$nota,$centro,$curso);
                        echo	"</span>
                        </p>
                        </td>";
                echo "</tr>";
                        
        }//Fin de la fila asignatura tipo 1 OK        
        
        public function promedioAreas($centro,$IHTotal,$codArea,$anho,$periodoBol,$alumnoe,$tipoPromedio,$campoIH){
            //echo "promedioAreas($centro,$IHTotal,$codArea,$anho,$periodoBol,$alumnoe,$tipoPromedio,$campoIH)<br>";
            $promedioArea = 0;
            if($alumnoe != 'todos'){
                if($tipoPromedio=='IH'){
                    $notaMax;
                    $sumaProcentajeNotaArea=0;
                    $porcentajeIHAsignatura;
                    $PorNotaAsig;
                    $PorcentajeNotaArea;

                    $sqlNotaMaxima=mysql_query("SELECT MAX(`limiteSup`) FROM desempenos WHERE `CODINST`='$centro' ORDER BY `limiteSup` DESC;");
                    $rsNota=mysql_num_rows($sqlNotaMaxima);                
                    if($rsNota>0){
                        while($n=mysql_fetch_array($sqlNotaMaxima)){
                            $notaMax=$n[0];
                        }
                    }
                    $sqlNotasAsig=mysql_query("SELECT axs.`$campoIH`,notas.NOTA FROM notasasignaturas notas
                    INNER JOIN asignaturas_sedes axs ON axs.`codAsig`=notas.`codAsignatura`
                    INNER JOIN areasxsedes axs1 ON axs1.`idAreaSede`=axs.`idArea`
                    WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$periodoBol' AND notas.`idMatricula` = '$alumnoe' AND axs1.`idAreaSede`='$codArea'");
                    
                    //*** Se verifica el numero de asignaturas que dependen del area y que tienen notas*---//
                    $numASignaturas=mysql_num_rows($sqlNotasAsig);
                    while($regAsi=mysql_fetch_array($sqlNotasAsig)){
                        $porcentajeIHAsignatura=($regAsi[0]*100)/$IHTotal;
                        $PorNotaAsig=($regAsi[1]*$porcentajeIHAsignatura)/$notaMax;
                        $sumaProcentajeNotaArea=$sumaProcentajeNotaArea+$PorNotaAsig;
                    }
                    $this->promedioArea=($sumaProcentajeNotaArea*$notaMax)/100;                
                }if($tipoPromedio=='Normal'){
                    $sumaNotasAsignatura=0;
                    $sqlNotasAsig=mysql_query("SELECT axs.`$campoIH`,notas.`NOTA` FROM notasasignaturas notas
                    INNER JOIN asignaturas_sedes axs ON axs.`codAsig`=notas.`codAsignatura`
                    INNER JOIN areasxsedes axs1 ON axs1.`idAreaSede`=axs.`idArea`
                    WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$periodoBol' AND notas.`idMatricula`='$alumnoe' AND axs1.`idAreaSede`='$codArea'");
                    
                    //*** Se verifica el numero de asignaturas que dependen del area y que tienen notas*---//
                    $numASignaturas=mysql_num_rows($sqlNotasAsig);
                    while($regAsi=mysql_fetch_array($sqlNotasAsig)){
                        $sumaNotasAsignatura=$sumaNotasAsignatura+$regAsi[1];
                    }
                    $this->promedioArea=($sumaNotasAsignatura/$numASignaturas);
                }elseif($tipoPromedio == 'Porcentaje'){
                    $notaMax;
                    $sumaProcentajeNotaArea=0;
                    $porcentajeIHAsignatura;
                    $PorNotaAsig;
                    $PorcentajeNotaArea;

                    $sqlNotaMaxima = mysql_query("SELECT MAX(`limiteSup`) FROM desempenos WHERE `CODINST` = '$centro' ORDER BY `limiteSup` DESC;");

                    $rsNota = mysql_num_rows($sqlNotaMaxima); 

                    if($rsNota > 0){
                        while($n = mysql_fetch_array($sqlNotaMaxima)){
                            $notaMax = $n[0];
                        }
                    }

                    $sqlNotasAsig = mysql_query("SELECT axs.`$campoIH`, notas.NOTA,axs.porcentaje FROM notasasignaturas notas INNER JOIN asignaturas_sedes axs ON axs.`codAsig`=notas.`codAsignatura` INNER JOIN areasxsedes axs1 ON axs1.`idAreaSede`=axs.`idArea` WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$periodoBol' AND notas.`idMatricula` = '$alumnoe' AND axs1.`idAreaSede`='$codArea'");
                    
                    //*** Se verifica el numero de asignaturas que dependen del area y que tienen notas*---//
                    $numASignaturas = mysql_num_rows($sqlNotasAsig);
                    if($numASignaturas>1){
                        while($regAsi = mysql_fetch_array($sqlNotasAsig)){
                            $porcentajeAsignatura = $regAsi[2];
                            $PorNotaAsig = ($regAsi[1] * $porcentajeAsignatura) / $notaMax;
                            $sumaProcentajeNotaArea = $sumaProcentajeNotaArea + $PorNotaAsig;
                        }
                        $this->promedioArea = ($sumaProcentajeNotaArea * $notaMax) / 100;
                    }elseif($numASignaturas==1){
                    	while($regAsi = mysql_fetch_array($sqlNotasAsig)){
                            $this->promedioArea = $regAsi[1];
                        }
                    }             
                }                
            }else{
                if($tipoPromedio=='IH'){
                    $notaMax;
                    $sumaProcentajeNotaArea=0;
                    $porcentajeIHAsignatura;
                    $PorNotaAsig;
                    $PorcentajeNotaArea;

                    $sqlNotaMaxima=mysql_query("SELECT MAX(`limiteSup`) FROM desempenos WHERE `CODINST`='$centro' ORDER BY `limiteSup` DESC;");
                    $rsNota=mysql_num_rows($sqlNotaMaxima);                
                    if($rsNota>0){
                        while($n=mysql_fetch_array($sqlNotaMaxima)){
                            $notaMax=$n[0];
                        }
                    }
                    $sqlNotasAsig=mysql_query("SELECT axs.`$campoIH`,notas.`NOTA` FROM notasasignaturas notas
                    INNER JOIN asignaturas_sedes axs ON axs.`codAsig`=notas.`codAsignatura`
                    INNER JOIN areasxsedes axs1 ON axs1.`idAreaSede`=axs.`idArea`
                    WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$periodoBol' AND axs1.`idAreaSede`='$codArea' AND notas.`idMatricula`='$alumnoe'");
                                //*** Se verifica el numero de asignaturas que dependen del area y que tienen notas*---//
                    $numASignaturas=mysql_num_rows($sqlNotasAsig);
                    while($regAsi=mysql_fetch_array($sqlNotasAsig)){
                        $porcentajeIHAsignatura=($regAsi[0]*100)/$IHTotal;
                        $PorNotaAsig=($regAsi[1]*$porcentajeIHAsignatura)/$notaMax;
                        $sumaProcentajeNotaArea=$sumaProcentajeNotaArea+$PorNotaAsig;
                    }
                    $this->promedioArea=($sumaProcentajeNotaArea*$notaMax)/100;                
                }if($tipoPromedio=='Normal'){
                    $sumaNotasAsignatura=0;
                    $sqlNotasAsig=mysql_query("SELECT axs.`IH`,notas.`NOTA` FROM notasasignaturas notas
                    INNER JOIN asignaturas_sedes axs ON axs.`codAsig`=notas.`codAsignatura`
                    INNER JOIN areasxsedes axs1 ON axs1.`idAreaSede`=axs.`idArea`
                    WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$periodoBol' AND axs1.`idAreaSede`='$codArea'");
                                //*** Se verifica el numero de asignaturas que dependen del area y que tienen notas*---//
                    $numASignaturas=mysql_num_rows($sqlNotasAsig);
                    while($regAsi=mysql_fetch_array($sqlNotasAsig)){
                        $sumaNotasAsignatura=$sumaNotasAsignatura+$regAsi[1];
                    }
                    $this->promedioArea=($sumaNotasAsignatura/$numASignaturas);
                }elseif($tipoPromedio == 'Porcentaje'){
                    $notaMax;
                    $sumaProcentajeNotaArea=0;
                    $porcentajeIHAsignatura;
                    $PorNotaAsig;
                    $PorcentajeNotaArea;

                    $sqlNotaMaxima = mysql_query("SELECT MAX(`limiteSup`) FROM desempenos WHERE `CODINST` = '$centro' ORDER BY `limiteSup` DESC;");

                    $rsNota = mysql_num_rows($sqlNotaMaxima); 

                    if($rsNota > 0){
                        while($n = mysql_fetch_array($sqlNotaMaxima)){
                            $notaMax = $n[0];
                        }
                    }

                    $sqlNotasAsig = mysql_query("SELECT axs.`$campoIH`, notas.NOTA, notas.porcentaje FROM notasasignaturas notas INNER JOIN asignaturas_sedes axs ON axs.`codAsig`=notas.`codAsignatura` INNER JOIN areasxsedes axs1 ON axs1.`idAreaSede`=axs.`idArea` WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$periodoBol' AND axs1.`idAreaSede`='$codArea'");
                    
                    //*** Se verifica el numero de asignaturas que dependen del area y que tienen notas*---//
                    $numASignaturas = mysql_num_rows($sqlNotasAsig);
                    if($numASignaturas>1){
                        while($regAsi = mysql_fetch_array($sqlNotasAsig)){
                            $porcentajeAsignatura = $regAsi[2];
                            $PorNotaAsig = ($regAsi[1] * $porcentajeAsignatura) / $notaMax;
                            $sumaProcentajeNotaArea = $sumaProcentajeNotaArea + $PorNotaAsig;
                        }
                        $this->promedioArea = ($sumaProcentajeNotaArea * $notaMax) / 100;
                    }elseif($numASignaturas==1){
                    	while($regAsi = mysql_fetch_array($sqlNotasAsig)){
                            $this->promedioArea = $regAsi[1];
                        }
                    }  
                } 
            }
            //return number_format(round($this->promedioArea,2),2,'.','');
            return $this->promedioArea;
        }//Fin Promedio del area OK

        public function promedioEstudiante($centro,$sede,$anho,$periodoBol,$idMatricula){
            $campoIH=0;
            $promedioEst=0;
            $sumaNotas=0;
             //consulta para optener el cod del grado
            $sql_grado=mysql_query("SELECT gr.nomCampo FROM grados gr INNER JOIN cursos cr ON cr.`CODGRADO`=gr.`CODGRADO` INNER JOIN matriculas mt ON mt.`Curso`=cr.`codCurso` WHERE mt.`idMatricula`='$idMatricula';");
            while($ng=mysql_fetch_array($sql_grado)){
                $campoIH=$ng[0];
            }
            
            //Consulta para recorrer todas las areas de la sede            
            error_reporting(0);
            $sqlAreasEnsede=mysql_query("SELECT axs.idAreaSede AS 'Area',axs.`$campoIH` AS 'IH', axs.formaDePromediar  FROM areasxsedes axs WHERE axs.`CODSEDE`='$sede' AND `$campoIH`<>0;");
            $TotalAreas=mysql_num_rows($sqlAreasEnsede);
            
            while ($regAr=mysql_fetch_array($sqlAreasEnsede)){
                //Consulto para conocer si el area tiene notas directas 
                $resultnotas=mysql_query("SELECT notas.nota FROM notas WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$periodoBol' AND notas.`idMatricula`='$idMatricula' AND notas.codArea='$regAr[0]'"); 
                $tieneNotas=mysql_num_rows($resultnotas);
                if($tieneNotas>0){ 
                    //Si tiene notas directas las acumulo para realizar el promedio
                   while ($ntA=mysql_fetch_array($resultnotas)){
                       $sumaNotas=$sumaNotas+$ntA[0];
                   }
                }else{
                    //Si NO tiene notas directas llamo a la funcion promediar areas que se encarga de obtener el promedio para el área y acumularlo luego
                    $notaPromedio=$this->promedioAreas($centro,$regAr[1],$regAr[0],$anho,$periodoBol,$idMatricula,$regAr[2],$campoIH);
                    $sumaNotas=$sumaNotas+$notaPromedio;                    
                }
            }
            //al finalizar las busquedas se realiza el procedimiento de calcular e imprimir el promedio del estudiante
                $this->promedioEst=($sumaNotas/$TotalAreas);
                echo number_format(round($this->promedioEst,2),2,'.','');
        }//fin promedio del estudiante OK
        
        public function promedioGrupo($centro,$sede,$anho,$periodoBol,$campo,$curso){
            //echo "Los valores que recibe son $centro, $sede; $anho; $periodoBol; $campo; $curso";
            $promedioGrup=0;
            $SQL_PROMEDIODIR=mysql_query("SELECT AVG(notas.NOTA) FROM notas WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$periodoBol' AND notas.`curso`='$curso';");
            while($pro=mysql_fetch_array($SQL_PROMEDIODIR)){
                 $this->promedioGrup=($pro[0]);   
            }
            
            echo number_format(round($this->promedioGrup,2),2,'.','');
        }//fin promedio del grupo OK
        
        public function puestoEstudiante($centro,$sede,$anho,$periodoBol,$curso,$idMatricula){
            /*-- Algoritmo básico para realizar el almacenamiento de los datos para ordenar los puestos ----------------------//
                $promedios=array('est1'=>1.2,'est2'=>4.2,'est3'=>3.2,'est4'=>5.2,'est5'=>2.2);
                $numero=count($promedios);
                echo "Total registros ".$numero."<br>";
                arsort($promedios);
                $cont=1;

                //ejemplo
                while (list($clave, $valor) = each($promedios)) {
                    echo "Clave: $clave; Valor: $valor -- Puesto: $cont<br />\n";
                    $cont++;
                }
            //-----------------------------------------------------------------------------//*/
            //1- recorro la tabla estudiantes para ir almacenando el promedio de cada uno en el array
            error_reporting(0);
            $sql_estudiantes=mysql_query("SELECT idMatricula FROM matriculas WHERE curso='$curso' AND estado='Matriculado' AND anho = '$anho';");
            $promedios=array();
            $sw=1;
            while($est=mysql_fetch_array($sql_estudiantes)){
                $campoIH=0;
                $promedioEst=0;
                $sumaNotas=0;
                 //consulta para optener el cod del grado
                $sql_grado=mysql_query("SELECT gr.nomCampo FROM grados gr INNER JOIN cursos cr ON cr.`CODGRADO`=gr.`CODGRADO` INNER JOIN matriculas mt ON mt.`Curso`=cr.`codCurso` WHERE mt.`idMatricula`='$est[0]';");
                while($ng=mysql_fetch_array($sql_grado)){
                    $campoIH=$ng[0];
                }
                
                //Consulta para recorrer todas las areas de la sede            
                error_reporting(0);
                $sqlAreasEnsede=mysql_query("SELECT axs.idAreaSede AS 'Area',axs.`$campoIH` AS 'IH', axs.formaDePromediar  FROM areasxsedes axs WHERE axs.`CODSEDE`='$sede' AND `$campoIH`<>0;");
                $TotalAreas=mysql_num_rows($sqlAreasEnsede);
                
                while ($regAr=mysql_fetch_array($sqlAreasEnsede)){
                    //Consulto para conocer si el area tiene notas directas 
                    $resultnotas=mysql_query("SELECT notas.nota FROM notas WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$periodoBol' AND notas.`idMatricula` = '$est[0]' AND notas.codArea='$regAr[0]'"); 
                    $tieneNotas=mysql_num_rows($resultnotas);
                    if($tieneNotas>0){ 
                        //Si tiene notas directas las acumulo para realizar el promedio
                       while ($ntA=mysql_fetch_array($resultnotas)){
                           $sumaNotas=$sumaNotas+$ntA[0];
                       }
                    }else{
                        //Si NO tiene notas directas llamo a la funcion promediar areas que se encarga de obtener el promedio para el área y acumularlo luego
                        $notaPromedio=$this->promedioAreas($centro,$regAr[1],$regAr[0],$anho,$periodoBol,$est[0],$regAr[2],$campoIH);
                        $sumaNotas=$sumaNotas+$notaPromedio;                    
                    }
                }
            //al finalizar las busquedas se realiza el procedimiento de calcular e imprimir el promedio del estudiante
                $this->promedioEst=($sumaNotas/$TotalAreas);
                $promedios[$est[0]]=$this->promedioEst;
            }
            arsort($promedios,SORT_NUMERIC);
            $cont=1;
            while (list($clave, $valor) = each($promedios) and $sw=1) {
                if($clave==$idMatricula){
                    echo $cont; 
                    $sw=0;
                }                
                $cont++;
            }
            
        }//OK Fin Puestos
        
        public function inasistencias($periodo,$anho,$estudiante,$codArea){
            $sqlInasistencias=mysql_query("SELECT COUNT(DISTINCT DIA,MES)FROM inasistencias WHERE periodo='$periodo' AND anho='$anho' AND CodEstudiante='$estudiante' AND codArea='$codArea';");
            
            while($ina=mysql_fetch_array($sqlInasistencias)){
                if($ina[0]!=0){
                    echo "$ina[0]";
                }
            }
        }//ok
        
        public function bloqueAreasFinal($anho,$periodoBol,$idMatricula,$centro,$curso,$sede){
            $campoIH=0;
            $totalHoras;
            $notaPromedio;
            $PorcentajePer;
            $conteoPerdidas=0;
            $definitiva;
            $promedioDefinitivo=0;
            
            //consulta para optener el cod del nivel
            $sql_grado=mysql_query("SELECT gr.`nomCampo` FROM grados gr INNER JOIN cursos cr ON cr.`CODGRADO`=gr.`CODGRADO` WHERE cr.`codCurso`='$curso';");
            while($ng=mysql_fetch_array($sql_grado)){
                $campoIH=$ng[0];
            }
            //Consulta para recorrer todas las areas de la sede            
            //Consulta las areas de la sede y que contienen horas asignadas en el grado seleccionado
            $sqlAreasEnsede=mysql_query("SELECT axs.`idAreaSede`,axs.`Nombre`,axs.`formaDePromediar` FROM areasxsedes axs WHERE axs.`codsede`='$sede' AND axs.`$campoIH`<>0;");
            $nAreas=mysql_num_rows($sqlAreasEnsede);
            
            //Inicio del recorrido de las areas con horas en el grado
            while($regArea=mysql_fetch_array($sqlAreasEnsede)){
                $PorcentajePer=0;
                $definitiva=0;
                echo "<tr>";
				echo    "<td style='width:90.1pt;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>";
                echo        "<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal;padding-left:10px;'>";
				echo            "<span lang=ES style='font-size:10.0pt'>";
								    /*NOMBRE DE LA MATERIA */
                echo                utf8_encode($regArea[1]);
				echo			"</span>";
				echo		"</p>";
				echo	"</td>";
				echo	"<td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>";
				echo	   "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>";
				echo            "<b>";
				echo				"<span lang=ES-AR style='font-family:Arial,sans-serif;font-size:6.0pt'>";                        
								        /*INTENSIDAD HORARIA */
                                        $sql_horasAreas=mysql_query("SELECT `$campoIH` FROM areasxsedes WHERE `idAreaSede`='$regArea[0]';");
                                        while($ho=mysql_fetch_array($sql_horasAreas)){
                                            echo $ho[0];
                                            $totalHoras=$ho[0];
                                        }                
                echo                "</span>";
				echo			"</b>";
				echo		"</p>";
				echo    "</td>";
                
                $periodoMin=periodoMin($centro);
                $periodoMax=periodoMax($centro);
                //Bucle para recorrer cada uno de los periodos y obtener cada una de las notas
                for($per=$periodoMin;$per<=$periodoMax;$per++){
                    //Consulto el valor en porcentaje del periodo en los ajustes
                    $sql_porPer=mysql_query("SELECT AJ.`valorPeriodo` FROM ajustes AJ WHERE AJ.`periodo`='$per' AND AJ.`idCentro`='$centro';");   
                    
                    while($pr=mysql_fetch_array($sql_porPer)){
                        $PorcentajePer=($pr[0]/100);
                    }
                    
                    //Consulto para conocer si el area tiene notas directas 
                    $resultnotas=mysql_query("SELECT notas.`NOTA` FROM notas WHERE notas.`Anho`='$anho' AND notas.`PERIODO`='$per' AND notas.`idMatricula`='$idMatricula' AND `codArea`='$regArea[0]';"); 
                    
                    $tieneNotas=mysql_num_rows($resultnotas);
                    if($tieneNotas>0){                    
                        while ($fila2=mysql_fetch_array($resultnotas)){
                            $notaAct=$fila2[0];
                            echo "<td style='width:20pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>";
                            echo    "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>";
                            echo        "<span lang=ES-AR style='font-size:12.0pt'>";
                                            /*NOTA */
                            echo            number_format($fila2[0], 1, '.', '');
                            echo        "</span>";
                            echo    "</p>";
                            $definitiva = ($notaAct * $PorcentajePer) + $definitiva;
                            //echo        "<span style='color:#f0a;font-size:9px;'>Nota A: $notaAct <br>% $PorcentajePer <br> Def: ".$definitiva."</span>";
                            echo "</td>";	
                            
                        }                    
                    }else{                        
                        echo "<td style='width:20pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;'>";
                        echo    "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>";
                        echo        "<span lang=ES-AR style='font-size:12.0pt'>";
                                        /*el calculo de la Nota promedio del area dependiendo de la forma de promediarla */                                
                                        $notaPromedio=$this->promedioAreas($centro,$totalHoras,$regArea[0],$anho,$per,$idMatricula,$regArea[2],$campoIH);
                        echo            number_format($notaPromedio, 1, '.', '');
                                        $definitiva = ($notaPromedio * $PorcentajePer) + $definitiva;
                        
                        echo	   "</span>";
                        echo    "</p>";
                        echo "</td>";
                    }
                } // Fin del bucle para recorrer los periodos
                
                echo    "<td style='width:20;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
				echo        "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>";
				echo            "<span lang=ES-AR style='font-size:10.0pt'>";
                echo                "<strong>";
								        // definitiva 
                                        // $objNota = new notaFinal();
                                        // $notaRetornada = $objNota->cargar($regArea[0],$campoIH,$anho,$centro,$idMatricula,$regArea[2]);
                echo                    number_format(round($definitiva,1),1, '.', '');
				echo                "</strong>";
                echo            "</span>";
				echo	   "</p>";
				echo    "</td>";
                
                echo    "<td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt;'>";
				echo        "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>";
				echo            "<span lang=ES-AR style='font-size:10.0pt'>";
                echo                "<strong>";
                                        /*DESEMPEÑO .$fila2[3].*/
                                        $objDes=new Desempenho();
                echo                    $objDes->cargar($definitiva,$centro); 
                                        $desR=$objDes->cargar($definitiva,$centro);
                                        $promedioDefinitivo=$promedioDefinitivo+$definitiva;
                                        if($desR=="BAJO"){
                                            $conteoPerdidas=$conteoPerdidas+1;
                                            //echo "- $conteoPerdidas";
                                        }
                echo                "</strong>";
				echo            "</span>";
				echo        "</p>";
				echo    "</td>";                
				echo "</tr>"; 
                
                // Se obtienen las asignaturas que dependen del area //
                $sql_AsigxAreas=mysql_query("SELECT * FROM asignaturas_sedes WHERE `idArea`='$regArea[0]' AND `$campoIH`<>0;");
                $nuAsig=mysql_num_rows($sql_AsigxAreas);
                
                if($nuAsig>0){
                    while($regAsi=mysql_fetch_array($sql_AsigxAreas)){
                        $defAsig=0;
                        echo "<tr style='height:10.0pt;background-color:rgba(200,200,200,0.6);'>";
                        
                        echo    "<td style='border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 0.0pt;border-right:solid windowtext 1.5pt;'>";
                        echo        "<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: normal;'>";
                        echo            "<span lang=ES style='font-size:8.0pt;margin-left:20px;'>- ";
                                            /*NOMBRE DE LA MATERIA */
                        echo                utf8_encode($regAsi[3]);
                        echo            "</span>";
                        echo        "</p>";
                        echo    "</td>";
                        
                        echo    "<td style='width:10.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;'>";
                        echo        "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>";
                        echo            "<b>";
                        echo                "<span lang=ES-AR style='font-family:Arial,sans-serif;font-size:6.0pt'>";
                                                /*INTENSIDAD HORARIA */
                                                $sql_horasAreas=mysql_query("SELECT `$campoIH` FROM asignaturas_sedes WHERE `codAsig`='$regAsi[1]';");
                                                while($ho=mysql_fetch_array($sql_horasAreas)){
                                                    echo $ho[0];
                                                }                                                 
                        echo                "</span>";
                        echo            "</b>";
                        echo        "</p>";
                        echo    "</td>";
                        
                        //Bucle para recorrer cada uno de los periodos y obtener cada una de las notas de la asignatura
                        for($p=1;$p<=4;$p++){
                            //Aqui se consulta las asignaturas con sus respectivas notas
                            $sqlNotasAsig=mysql_query("SELECT nt.`NOTA` FROM notasasignaturas nt WHERE nt.`Anho`='$anho' AND nt.`PERIODO`='$p' AND nt.`idMatricula`='$idMatricula' AND nt.`codAsignatura`='$regAsi[1]';");
                            
                            //Se verifica el numero de asignaturas que dependen del area y que tienen notas*---//
                            $numASignaturas=mysql_num_rows($sqlNotasAsig);
                            if($numASignaturas>0){
                                while($ntAsi=mysql_fetch_array($sqlNotasAsig)){
                                    //se ingresa a imprimir las asignaturas con sus notas
                                    echo "<td style='width:20;border-top:none;border-left:solid windowtext 1.0pt; border-bottom:solid windowtext 0.5pt;border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
                                    echo    "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>";
                                    echo        "<span lang=ES-AR style='font-size:7.0pt'>";
                                                    /*NOTA */
                                    echo            number_format($ntAsi[0], 1, '.', '');
                                    echo        "</span>";
                                    echo    "</p>";
                                    echo "</td>";

                                    $defAsig=($ntAsi[0]*$PorcentajePer)+$defAsig;
                                }
                            }else{
                                echo "<td style='width:20;border-top:none;border-left:solid windowtext 1.0pt; border-bottom:solid windowtext 0.5pt;border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
                                echo    "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>";
                                echo        "<span lang=ES-AR style='font-size:7.0pt'>";
                                                /*NOTA */
                                echo            number_format(0, 1, '.', '');
                                echo        "</span>";
                                echo    "</p>";
                                echo "</td>";
                            }
                        }
                        
                        echo    "<td style='width:20;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
                        echo        "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>";
                        echo            "<span lang=ES-AR style='font-size:7.0pt'>";
                                            /*definitiva */
                        echo                number_format(round($defAsig,1),1, '.', '');
                        echo            "</span>";
                        echo        "</p>";
                        echo    "</td>";
                        
                        echo    "<td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt;'>";
                        echo        "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>";
                        echo            "<span lang=ES-AR style='font-size:7.0pt'>";
                        echo                "<strong>";
                                                /*DESEMPEÑO*/
                                                $objDes=new Desempenho();
                        echo                    $objDes->cargar($defAsig,$centro); 
                                                $desR=$objDes->cargar($defAsig,$centro);
                                                /*if($desR=="BAJO"){
                                                    $conteoPerdidas=$conteoPerdidas+1;
                                                    echo " - $conteoPerdidas";
                                                }*/
                        echo                "</strong>";
                        echo	       "</span>";
                        echo        "</p>";
                        echo    "</td>";						
                        echo "</tr>";
                    }                        
                }
            }
            // Fin del recorrido de las Areas
            
            
            echo "<tr style='border:solid windowtext 1.5pt;margin:0px;'>";
            echo    "<td width='29%' colspan=2 valign=top style='width:29.34%;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt'>";
            echo        "<p class=MsoNormal align=right style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:right;line-height:normal'>";
            echo            "<span lang=ES-AR>";
            echo                "PROMEDIO DEL ESTUDIANTE ";
            echo            "</span>";
            echo        "</p>";
            echo    "</td>";
            
            for($p=1;$p<=4;$p++){
                echo    "<td width='5%' style='width:5.32%;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt'>";
                echo        "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>";
                echo            "<span lang=ES-AR style='font-size:12.0pt'>";
                                    /*-------------------- PROMEDIO DEL ESTUDIANTE -----------------------*/                                           
                                    $promedioEstudiante = new Boletin();
                                    $promedioEstudiante->promedioEstudiante($centro,$sede,$anho,$p,$idMatricula);
                                    //----- FIN DEL PROMEDIO DEL ESTUDIANTE -----------------------------///
                echo            "</span>";
                echo        "</p>";
                echo    "</td>";
            }
            
            echo    "<td style='width:20;border-top:none;border-left:solid windowtext 1.5pt; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt; padding:0cm 5.4pt 0cm 5.4pt;'>";
            echo        "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:center;line-height:normal'>";
            echo            "<span lang=ES-AR style='font-size:12.0pt'>";
            echo                "<strong>";
								    /*definitiva */
                                    $promedioDefinitivo=($promedioDefinitivo/$nAreas);
            echo                    number_format($promedioDefinitivo, 2, '.', '');
            echo                "</strong>";
            echo            "</span>";
            echo        "</p>";
            echo    "</td>";
            
            echo    "<td style='width:50pt;border-top:none;border-left:none; border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt;'>";
            echo        "<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt; text-align:left;line-height:normal'>";
            echo            "<span lang=ES-AR style='font-size:12.0pt'>";
            echo                "<strong>";
                                    /*DESEMPEÑO .$fila2[3].*/
                                    $objDes=new Desempenho();
            echo                    $objDes->cargar($promedioDefinitivo,$centro);
                                    $desR=$objDes->cargar($promedioDefinitivo,$centro);                                
            echo                "</strong>"; 
            echo            "</span>";
            echo        "</p>";
            echo    "</td>";						
            echo "</tr>"; 
            echo "</table>";
            
            //*------------------------------------- PIE DEL BOLETIN  ----------------------------------------/
            echo "<br>";        
            echo "<table class=MsoTableGrid cellspacing=0 cellpadding=0  style='margin:0 auto;border-collapse:collapse;border:none;width:50%'>";
            echo    "<tr style='border:solid windowtext 0.5pt;margin:0px;'>";
            echo        "<td width='26%' colspan='2' style='width:26.62%;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>";
            echo            "<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:normal;text-align:center;>";
            echo                "<span lang=ES-AR style='font-size:10.0pt'>";
            echo                    "PUESTOS DEL ESTUDIANTE";
            echo                "</span>";
            echo            "</p>";
            echo        "</td>";
            echo        "<td width='26%' colspan='' style='width:26.62%;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>";
            echo            "<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal;'>";
            echo                "<span lang=ES-AR style='font-size:10.0pt'>";
            echo                    "RESULTADO DEL AÑO LECTIVO";
            echo                "</span>";
            echo            "</p>";
            echo        "</td>";
            echo    "</tr>";
            
            echo    "<tr>";
            
            echo        "<td style='width:26.62%;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>";
            echo            "<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>";
            echo                "<span lang=ES-AR>";
            echo                    "<strong>En el Grupo: </strong>";
                                         //-- BLOQUE PARA COLOCAR EL PUESTO DEL ESTUDIANTE SEGUN EL PROMEDIO EN EL GRUPO
                                        $puesto = new Puestos();
                                        $puesto->finalGrupo($centro,$sede,$anho,$periodoBol,$curso,$idMatricula);
            echo                "</span>";
            echo            "</p>";
            echo        "</td>";
            
            echo        "<td style='width:26.62%;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>";
            echo            "<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal'>";
            echo                "<span lang=ES-AR>";
            echo                    "<strong>En el Grado: </strong>";
                                        //-- BLOQUE PARA COLOCAR EL PUESTO DEL ESTUDIANTE SEGUN EL PROMEDIO EN EL GRADO
                                        $puestoG = new Puestos();
                                        $puestoG->finalGrado($centro,$sede,$anho,$periodoBol,$curso,$idMatricula);
            echo                "</span>";
            echo            "</p>";
            echo        "</td>";
            echo        "<td width='26%' colspan='' style='width:26.62%;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>";
            echo            "<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:center;line-height:normal;'>";
            echo                "<span lang=ES-AR style='font-size:10.0pt'>";
                                    if($conteoPerdidas>=3){
                                        echo "<strong>REPROBADO</strong>";
                                    }elseif($conteoPerdidas>0 and $conteoPerdidas<3){
                                        echo "<strong>APLAZADO</strong>";
                                    }else{
                                        echo "<strong>APROBADO</strong>";
                                    }
            echo                "</span>";
            echo            "</p>";
            echo        "</td>";
            echo    "</tr>";
            echo "</table>";
        }//Fin Bloque de areas finales    
        
        function __destruct() {
           //$this->name ;
       }
    }//Fin de la clase Boletin
?>