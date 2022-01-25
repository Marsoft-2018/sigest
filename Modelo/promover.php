<?php 
	class Promover extends ConectarPDO{
		public $idMatricula;
		public $documento;
		public $grado;
		public $grupo;
		public $curso;
		public $sede;
		public $nomAcudiente;
		public $barrioAcudiente;
		public $dirAcudiente;
		public $celAcudiente;
		public $correoAcudiente;
		public $anho;
		public $conteoPerdidas;
	    public $estadoDefinitivo; 
		private $sql;
		
		
		public function estadoFinalAnho($idMatricula,$curso,$anho){
			$desmFinal = "BAJO";
			$acumFinal = 0;
			$objPensum = new Area();
			$objPeriodo = new Periodo();
			$objPensum->codSede	= $this->sede;
			$objPensum->anho	= $anho;
			$objPensum->idGrado	= $this->grado;
			$sqlAreas = $objPensum->cargarPensum();
			foreach ($sqlAreas as $area) {
				$acumFinal = 0;
	            foreach ($objPeriodo->cargar() as $per) { 
				    $objCalificacion = new Calificacion();
				    $objCalificacion->curso = $curso;
				    $objCalificacion->Anho = $anho;
					$objCalificacion->idMatricula = $idMatricula;
					$objCalificacion->codArea =  $area['id'];
		            $objCalificacion->periodo = $per['periodo'];                
		            foreach ($objCalificacion->cargar() as $calif) {
		                $objCalificacion->nota = $calif['NOTA'];
		                $objCalificacion->porPeriodo = $per['valorPeriodo'];
		                $acumFinal += $objCalificacion->acumulado();
		                //echo $acumFinal;
		            } 
		        } 
		        $objD = new  Desempenos();
		        if($acumFinal < $objCalificacion->notaBaja()){
		        	$acumFinal = $objCalificacion->notaBaja();
		        }
				$objD->nota = $acumFinal;
		        $desmFinal = $objD->cargar();
		        //echo "Nota final ".$acumFinal."<br>";
		        if($desmFinal == "BAJO"){
	                $this->conteoPerdidas += 1;
	            }
	        }
			try {
                $sql2 = "SELECT areasReprobadas FROM a_lectivo WHERE Alectivo = '".$anho."'";
                $stm = $this->Conexion->prepare($sql2);
                $stm->execute(); 
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $value) {
                    $this->areasReprobadas = $value['areasReprobadas'];
                }
            } catch (Exception $e) {
                echo "Ocurrió un error: ".$e3;
            }

	        $areasPerder = $this->areasReprobadas;
	        $objCalificacion = new Calificacion();
			$this->estadoDefinitivo = $objCalificacion->estadoAnho($this->conteoPerdidas, $areasPerder); 

            return $this->estadoDefinitivo;
	    }

		public function Avanzar($sede,$grado,$grupo,$idMatricula,$anho){
			
			if($grado === 11){
				try {
					$this->sql = "UPDATE matriculas SET estado = 'Graduado' WHERE idMatricula  =  '$idMatricula'";
					$stm = $this->Conexion->prepare($this->sql);
					$stm->execute();

					echo "<div class = 'alert alert-success'>";
					echo 	"<i clas s ='fa fa-graduation-cap'>Graduado</i>";
					echo "</div>"; 
				} catch (Exception $e) {
					echo "Error: No se pudo Graduar<br>".$e;
				}
			}else{
				//1. consulta para encontrar el curso siguiente teniendo en cuenta el grado y grupo actual.
				try {
					$sqlcursoSig  = "SELECT CODGRADO, grupo, codCurso FROM cursos WHERE CODGRADO = '".($grado+1)."' AND grupo = '$grupo' AND codSede  =  '$sede'"; 
					$stm = $this->Conexion->prepare($sqlcursoSig);
					$stm->execute();
					$rdatos = $stm->fetchAll(PDO::FETCH_ASSOC);
					foreach ($rdatos as $value) {
						try {
							//1.1 Actualizar el estado del estudiante a promovido en la tabla matriculas
							$sqlPromover = "UPDATE matriculas SET estado = 'Promovido' WHERE idMatricula = '$idMatricula'";
							$stm2 = $this->Conexion->prepare($sqlPromover);
							$stm2->execute(); 

							$sqlAcudiente = "SELECT Documento, NombreAcudiente, barrioAcudiente, direccionAcudiente, celAcudiente, correoAcudiente FROM matriculas WHERE idMatricula = ?";
							$stm3 = $this->Conexion->prepare($sqlAcudiente);
							$stm3->bindparam(1, $idMatricula);
							$stm3->execute();
							$acudiente = $stm3->fetchAll(PDO::FETCH_ASSOC);
							foreach ($acudiente as $Avalue) {
								//1.2 Se inserta un nuevo registro de matricula con el curso siguiente en la tabla matriculas                        
								$nuevaMatricula  =  "INSERT INTO matriculas(`codsede`,`Documento`,`Curso`,`NombreAcudiente`,`barrioAcudiente`,`direccionAcudiente`,`celAcudiente`,`correoAcudiente`,`anho`) VALUES(?,?,?,?,?,?,?,?,'".($anho+1)."')";
								$stm4 = $this->Conexion->prepare($nuevaMatricula);
								$stm4->bindparam(1,$sede);
								$stm4->bindparam(2,$Avalue['Documento']);
								$stm4->bindparam(3,$value['codCurso']);
								$stm4->bindparam(4,$Avalue['NombreAcudiente']);
								$stm4->bindparam(5,$Avalue['barrioAcudiente']);
								$stm4->bindparam(6,$Avalue['direccionAcudiente']);
								$stm4->bindparam(7,$Avalue['celAcudiente']);
								$stm4->bindparam(8,$Avalue['correoAcudiente']);
								//$stm4->bindparam(9,);

								$stm4->execute();
								//1.3 Se imprime el resultado del proceso de promoción
								echo "<div class = 'alert alert-success' style = 'padding:1px;margin:0px;font-size:10px;text-align:center;'>";
								echo    "<i class = 'fa fa-check-circle'> Promovido a:".$value['CODGRADO']."° ".$value['grupo']."</i>";
								echo "</div>";
							}							
						} catch (Exception $e) {
							echo "Error al matricular en el nuevo curso.<br>".$e;
						}
						$resultadoSql = 1;
					}
	 				
					/*if($resultadoSql>0){ //Si existe el nuevo curso en la sede                   
						                   
					}else{
						//2 En Caso de que no exista el proximo grado.
						//2.1 Se Crea el nuevo curso para posteriormente promover al estudiante.
						
						$sqlJornadaAct  =  mysql_query("SELECT idJornada FROM cursos WHERE CODGRA D O='$grado' AND grupo='$grupo' AN D  codSede='$sede';");

						while($j  =  mysql_fetch_array($sqlJornadaAct)){
							mysql_query("INSERT INTO `cursos`(`codSede`, `CODGRADO`, `grupo`, `idJornada`) VALUES('$sede','".($grado+1)."','$grupo','$j[0]');");
						}

						//2.2.2 Obtengo el código del nuevo curso creado
						$sqlcursoNuevo  =  mysql_query("SELECT CODGRADO,grupo,codCurso FROM cursos WHERE CODGRADO = '".($grado + 1)."' AND grupo = '$grupo' AND codSede = '$sede';");

					 	 $rSql = mysql_num_rows($sqlcursoNuevo);
						
						if($rSql > 0){ 
							while($curN = mysql_fetch_array($sqlcursoNuevo)){
								//2.2.3 Actualizar el estado del estudiante a promovido en la tabla matriculas
								$sqlPromover = mysql_query("UPDATE matriculas SET estado = 'Promovi d o' WHERE idMatricula = '$idMatricula'"); 
								
								//2.2.4 Se inserta un nuevo registro de matricula con el curso siguiente en la tabla matriculas                        
								$nuevaMatricula  =  mysql_query("INSERT INTO matriculas(`codsede`,`Documento`,`Curso`,`NombreAcudiente`,`barrioAcudiente`,`direccionAcudiente`,`celAcudiente`,`correoAcudiente`,`anho`) VALUES('$sede','$documento','$curN[2]','$nomAcudiente','$barrioAcudiente','$dirAcudiente','$celAcudiente','$correoAcudiente','".($anho+1)."')")or die("Error al ingresar la nueva matricula<br>".mysql_error());

								//2.2.5 Se imprime el resultado del proceso de promoción
								echo "<div class = 'alert alert-alert alert-info'><i class = 'fa fa-check-circle'> Promovido al Nuevo Curso: ".($grado+1)."° $grupo</div>";                     
							}
						}
					}*/
				} catch (Exception $e) {
					echo "Error: al pasar de curso<br>".$e; 
				}
				
			}            
		}
	}

?>