<!-- `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodo` int(5) NOT NULL,
  `idMatricula` int(11) NOT NULL,
  `curso` int(11) NOT NULL,
  `asistencia` varchar(100) DEFAULT NULL,
  `cumplimiento` varchar(100) DEFAULT NULL,
  `observacion` text NOT NULL,
  `anho` char(4) CHARACTER SET latin1 NOT NULL COMMENT 'Año en que se calificó',
  `fecha_reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` tinyint(1) NOT NULL DEFAULT '1', -->

  <?php
   // require ('Conect.php');
   class observacionArea extends ConectarPDO{
		public $id;
		public $periodo;
      	public $idMatricula;
      	public $curso;
		public $idArea;
		public $asistencia;
		public $cumplimiento;
		public $observacion;
		public $anho;
		private $sql;

		public function cargar(){
			$this->sql = "SELECT * FROM observaciones_areas WHERE idMatricula ='".$this->idMatricula."' AND idArea='".$this->idArea."' AND curso = '".$this->curso."' AND periodo='".$this->periodo."' AND anho='".$this->anho."'";
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
			$this->sql = "INSERT INTO observaciones_area(periodo, idMatricula, curso, asistencia, cumplimiento, observacion, anho, idArea) VALUES(?,?,?,?,?,?,?,?)";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->periodo);
				$stm->bindParam(2, $this->idMatricula);
				$stm->bindParam(3, $this->curso);
				$stm->bindParam(4, $this->asistencia);
				$stm->bindParam(5, $this->cumplimiento);
				$stm->bindParam(6, $this->observacion);				
				$stm->bindParam(7, $this->anho);				
				$stm->bindParam(8, $this->idArea);
				$stm->execute();
				echo "Observación guardada con éxito.";
			} catch (Exception $e) {
				echo "Ocurrio un error al insertar la observación del área al estudiante. <br>".$e;
			}
		}

		public function modificar(){
			$this->sql = "UPDATE observaciones_area SET asistencia = ?, cumplimiento = ?, observacion = ? WHERE id='".$this->id."'";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->asistencia);
				$stm->bindParam(2, $this->cumplimiento);
				$stm->bindParam(3, $this->observacion);
				$stm->execute();
			} catch (Exception $e) {
				echo "Ocurrio un error al insertar el area. <br>".$e;
			}
		}

		public function eliminar(){
			$this->sql = "DELETE FROM observaciones_area WHERE id='".$this->id."'";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->execute();
			} catch (Exception $e) {
				echo "Ocurrio un error al insertar el area. <br>".$e;
			}
		}

		public function listar(){
			$this->sql = "SELECT * FROM observaciones_area WHERE curso ='".$this->curso."'  AND idArea ='".$this->idArea."' AND  periodo ='".$this->periodo."' AND anho='".$this->anho."'  ORDER BY idMatricula ASC";
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
   }
 
?>
