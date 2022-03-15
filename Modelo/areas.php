<?php
   // require ('Conect.php');
   class Area extends ConectarPDO{
		public $codSede;
		public $areaInst;
		public $id;
		public $abreviatura;
		public $nombre;
		public $formadepromediar;
		public $anho;
		public $intensidad;
		public $idGrado;
      public $curso;
      public $tipoUsuario;
      public $idUsuario;
      public $idAsignatura;
      public $nombreAsignatura;
      public $porcentajeAsignatura;
		private $sql;

		public function cargarPensum(){
			$this->sql = "SELECT axs.`codsede`,axs.`id`,axs.`Abreviatura`,axs.`Nombre`,axs.`formaDePromediar`,ih.`idGrado`,ih.`intensidad` FROM areas_intensidad ih INNER JOIN areasxsedes_2 axs ON axs.`id` = ih.`idArea` INNER JOIN areas_anho ara ON ara.`idArea` = axs.`id` WHERE axs.codSede ='".$this->codSede."' AND ara.anho='".$this->anho."' AND ih.`intensidad` != 0 AND ih.idGrado='".$this->idGrado."' ORDER BY axs.Abreviatura ASC";
			try {
   			$stm = $this->Conexion->prepare($this->sql);
   			$stm->execute();
   			$reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
   			return $reg; 				
			} catch (Exception $e) {
				echo "Error al consultar los datos. <br>".$e;
			}
		}

		public function agregar(){
			$this->sql = "INSERT INTO areasxsedes_2(codsede, Abreviatura, Nombre, formaDePromediar) VALUES(?,?,?,?)";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->codSede);
				$stm->bindParam(2, $this->abreviatura);
				$stm->bindParam(3, $this->nombre);
				$stm->bindParam(4, $this->formaDePromediar);
				$stm->execute();
            $sql2 = "SELECT MAX(id) AS id FROM areasxsedes_2 WHERE codsede = ? AND abreviatura = ?";
            try {
               $stm2 = $this->Conexion->prepare($sql2);
               $stm2->bindParam(1, $this->codSede);
               $stm2->bindParam(2, $this->abreviatura);
               $stm2->execute();
               $datos = $stm2->fetchAll(PDO::FETCH_ASSOC);
               foreach ($datos as $value) {
                  $sql3 = "INSERT INTO areas_anho(idArea,anho) VALUES(?,?)";
                  try {
                     $stm3 = $this->Conexion->prepare($sql3);
                     $stm3->bindParam(1, $value['id']);
                     $stm3->bindParam(2, $this->anho);
                     $stm3->execute();
                     echo "Área agregada con éxito";
                  } catch (Exception $e) {
                     echo "Error al insertar el anho para el área";
                  }
               }
            } catch (Exception $e) {
               echo "Error al obtener el id de la última área";
            }
			} catch (Exception $e) {
				echo "Ocurrio un error al insertar el área. <br>".$e;
			}
		}

		public function modificar(){
			$this->sql = "UPDATE areasxsedes_2 SET codsede = ?, areaInst = ?, Abreviatura = ?, Nombre = ?, formaDePromediar = ?, anho = ? WHERE id='".$this->id."'";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->codSede);
				$stm->bindParam(2, $this->areaInst);
				$stm->bindParam(3, $this->abreviatura);
				$stm->bindParam(4, $this->nombre);
				$stm->bindParam(5, $this->formaDePromediar);
				$stm->bindParam(6, $this->anho);
				$stm->execute();
			} catch (Exception $e) {
				echo "Ocurrio un error al insertar el area. <br>".$e;
			}
		}

		public function eliminar(){
			$this->sql = "DELETE FROM areas_anho WHERE idArea = ? and anho = ?";
			try {
				$stm = $this->Conexion->prepare($this->sql);
            $stm->bindparam(1,$this->id);
            $stm->bindparam(2,$this->anho);
				$stm->execute();
			} catch (Exception $e) {
				echo "Ocurrio un error al insertar el area. <br>".$e;
			}
		}

		public function listar(){
			$this->sql = "SELECT axs.*,ara.`anho` FROM areasxsedes_2 axs INNER JOIN areas_anho ara ON ara.`idArea` = axs.`id` WHERE axs.codSede ='".$this->codSede."' AND ara.anho='".$this->anho."' ORDER BY axs.Nombre ASC";
			try {
   			$stm = $this->Conexion->prepare($this->sql);
   			$stm->execute();
   			$reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
   			return $reg; 	
            $this->Conexion->cerrarConexion(); 			
			} catch (Exception $e) {
				echo "Error al consultar los datos. <br>".$e;
			}
		}

		public function addIntensidad(){
			$this->sql = "INSERT INTO areas_intensidad(idArea, idGrado, intensidad) VALUES(?,?,?)";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->id);
				$stm->bindParam(2, $this->idGrado);
				$stm->bindParam(3, $this->intensidad);
				if($stm->execute()){ echo "Registro agregado con éxito<br>"; }
			} catch (Exception $e) {
				echo "Ocurrio un error al insertar la intensidad horaria. <br>".$e;
			}
		}

      public function profesorAsignado(){
         $this->sql = "SELECT CONCAT(pf.PrimerNombre,' ', pf.SegundoNombre,' ', pf.PrimerApellido,' ', pf.SegundoApellido)AS profesor FROM cargaacademica_new cg INNER JOIN areasxsedes_2 ar ON ar.id = cg.codArea INNER JOIN profesores pf ON pf.Documento = cg.codProfesor WHERE cg.codArea = '".$this->id."' AND cg.`codCurso`='".$this->curso."' AND cg.anho='".$this->anho."'";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
            return $reg;            
         } catch (Exception $e) {
            echo "Error al consultar los datos. <br>".$e;
         }
      }

		public function setIntensidad(){
         $this->sql = "UPDATE areas_intensidad SET intensidad = ? WHERE idArea = ? AND idGrado = ?";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindParam(1, $this->intensidad);
            $stm->bindParam(2, $this->id);
            $stm->bindParam(3, $this->idGrado);
            $stm->execute();
            echo "Se modificó la intensidad horaria con éxito";
         } catch (Exception $e) {
            echo "Ocurrio un error al modificar la intensidad horaria. ".$e;
         }
		}

      public function setTipoPromedio(){
         $this->sql = "UPDATE areasxsedes_2 SET formaDePromediar = ? WHERE id = ?";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindParam(1, $this->formadepromediar);
            $stm->bindParam(2, $this->id);
            $stm->execute();
            echo "Se modificó el tipo de promedio con éxito";
         } catch (Exception $e) {
            echo "Ocurrio un error al modificar el tipo de promedio para el área. ".$e;
         }
      }

		public function cargarIntensidad(){
         $this->sql = "SELECT * FROM areas_intensidad WHERE idArea = '".$this->id."' AND idGrado ='".$this->idGrado."'";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
            return $reg;            
         } catch (Exception $e) {
            echo "Error al consultar los datos. <br>".$e;
         }
		}

      public function cargarTodasLasAreas(){
         $this->tipoUsuario = $_SESSION['rol'];
         $this->idUsuario = $_SESSION['idUsuario'];
         switch ($this->tipoUsuario) {
            case 'Administrador':
               $this->sql = "SELECT axs.`id`,axs.`Nombre`,axs.`Abreviatura`, 'Area' AS tipo FROM areas_intensidad ih INNER JOIN areasxsedes_2 axs ON axs.`id` = ih.`idArea` INNER JOIN areas_anho ara ON ara.`idArea` = axs.`id` WHERE axs.codSede =(SELECT codSede FROM cursos WHERE codCurso='".$this->curso."')  AND ara.anho='".$this->anho."' AND ih.`intensidad` != 0 AND ih.idGrado=(SELECT codGrado FROM cursos WHERE codCurso='".$this->curso."')";
               break;
            case 'Profesor':
               $this->sql = "SELECT DISTINCT (axs.id), axs.Abreviatura, axs.Nombre, 'Area' AS tipo FROM cargaacademica_new cr INNER JOIN areasxsedes_2 axs ON cr.`codArea` = axs.`id` INNER JOIN areas_anho ara ON ara.`idArea` = axs.`id` WHERE cr.`codCurso` = '".$this->curso."' AND cr.`codProfesor` = '".$this->idUsuario."' AND cr.`anho` = '".$this->anho."' UNION SELECT DISTINCT (axs.id), axs.Abreviatura, axs.Nombre, 'Asignatura' AS tipo  FROM areas_asignaturas axs INNER JOIN cargaacademica_new cr ON cr.`codAsignatura` = axs.`id` INNER JOIN areasxsedes_2 ar ON ar.id = axs.idArea INNER JOIN areas_anho ara ON ara.`idArea` = ar.`id` WHERE cr.`codCurso` = '".$this->curso."' AND cr.`codProfesor` = '".$this->idUsuario."' AND ara.`anho` ='".$this->anho."' ORDER BY Nombre ASC";
               break;
         }
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
            return $reg;            
         } catch (Exception $e) {
            echo "<br>Error al consultar los datos. <br>".$e;
         }
      }

      public function totalHoras($grado){
         $this->sql = "SELECT SUM(intensidad) AS 'total' FROM (SELECT axs.`id`,axs.`Abreviatura`,axs.`Nombre`,ih.`intensidad` FROM areasxsedes_2 axs INNER JOIN areas_intensidad ih ON ih.`idArea` = axs.`id` INNER JOIN areas_anho ara ON ara.`idArea` = axs.`id` WHERE axs.`codsede` = ? AND ara.anho = ? AND ih.`idGrado`=?) AS horas";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindparam(1,$this->codSede);
            $stm->bindparam(2,$this->anho);
            $stm->bindparam(3,$grado);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
            foreach ($reg as $key => $horas) {
               $reg = $horas['total'];
            }
            if (empty($reg)) {
               $reg = 0;
            }
            return $reg; 

         } catch (Exception $e) {
            echo "Error al consultar los datos. <br>".$e;
         }
      }

      public function totalAreas(){
         $this->sql = "SELECT COUNT(ih.id) AS total FROM areas_intensidad ih INNER JOIN areasxsedes_2 axs ON axs.`id` = ih.`idArea` INNER JOIN areas_anho ara ON ara.`idArea` = ih.`idArea`  WHERE axs.codSede = ? AND ara.anho= ? AND ih.`intensidad` != 0 AND ih.idGrado= ? ORDER BY axs.Abreviatura ASC";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindparam(1,$this->codSede);
            $stm->bindparam(2,$this->anho);
            $stm->bindparam(3,$this->idGrado);
              $stm->execute();
              $total = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($total as $val) {
                  $total = $val['total'];
              }
              return $total;
          } catch (Exception $e) {
              
          }
      }

      public function conteoAsignaturas(){
         $this->sql = "SELECT COUNT(ih.id) AS total FROM asignaturas_intensidad ih INNER JOIN areas_asignaturas axs ON axs.`id` = ih.`idAsignatura` WHERE  ih.`intensidad` != 0 AND idArea = ? AND ih.idGrado = ?";
         try {
              $stm = $this->Conexion->prepare($this->sql);
              $stm->bindparam(1,$this->idArea);
              $stm->bindparam(2, $this->idGrado);
              $stm->execute();
              $total = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($total as $val) {
                  $total = $val['total'];
              }
              return $total;
          } catch (Exception $e) {
              echo "Error al traer el total de asignaturas del área";
          }
      }

      public function copiarAreas($anhoActual){
         //Esta funcion permite copiar las areas al pasar de un año a otro para que el usuario no tenga que volver a digitar todas las areas nuevamente.
         $this->sql = "SELECT * FROM areas_anho WHERE anho = ? ";
         try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindparam(1,$this->anho);
            $stm->execute();
            $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($datos as $value) {
               $sql = "INSERT INTO areas_anho(idArea,anho) VALUES(?, ?) ";
               try {
                  $stm2 = $this->Conexion->prepare($sql);
                  $stm2->bindparam(1,$value['idArea']);
                  $stm2->bindparam(2,$anhoActual);
                  $stm2->execute();                  
               } catch (Exception $e) {
                  
               }
            }
         } catch (Exception $e) {
            
         }

      }
   }
         
?>
