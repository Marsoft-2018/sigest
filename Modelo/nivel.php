<?php 
	class Nivel extends ConectarPDO{
		public $CODNIVEL;
	  	public $NOMBRE_NIVEL;
	  	public $orden;
	  	public $curso;
	  	private $sql;

		public function agregar(){        
			$this->sql = "INSERT INTO niveles(CODNIVEL,NOMBRE_NIVEL,orden) VALUES(?,?,?)";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->CODNIVEL);
				$stm->bindParam(2, $this->NOMBRE_NIVEL);
				$stm->bindParam(3, $this->orden);
				if($stm->execute()){
					$reg = '<div class="alert alert-success" role="alert">Registro agregado con éxito</div>';
				}else{
					$reg = '<div class="alert alert-warning" role="alert">Falló al agregar el registro</div>';
				}
				echo $reg;
			} catch (Exception $e) {
				echo '<div class="alert alert-danger" role="alert">Error al agregar el registro: '.$e.'</div>';
			}
		}

		public function cargar(){
			$this->sql = "SELECT * FROM niveles  WHERE CODNIVEL = ?";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->CODNIVEL);
				$stm->execute();
				$datos = $stm->fetchAll(PDO::FETCH_ASSOC);
				return $datos;
			} catch (Exception $e) {
				echo "Error al listar los niveles. ".$e;
			}
		}

	  	public function listar(){
	  		$this->sql = "SELECT * FROM niveles  ORDER BY orden ASC";
	  		try {
	  			$stm = $this->Conexion->prepare($this->sql);
	  			$stm->execute();
	  			$datos = $stm->fetchAll(PDO::FETCH_ASSOC);
	  			return $datos;
	  		} catch (Exception $e) {
	  			echo "Error al listar los niveles. ".$e;
	  		}
	  	}
		
		public function modificar(){        
			$this->sql = "UPDATE niveles SET NOMBRE_NIVEL = ?, orden = ? WHERE CODNIVEL = ?";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->NOMBRE_NIVEL);
				$stm->bindParam(2, $this->orden);
				$stm->bindParam(3, $this->CODNIVEL);
				if($stm->execute()){
					$reg = '<div class="alert alert-success" role="alert">Registro actualizado con éxito</div>';
				}else{
					$reg = '<div class="alert alert-warning" role="alert">Falló al actualizar el registro</div>';
				}
				echo $reg;
			} catch (Exception $e) {
				echo '<div class="alert alert-danger" role="alert">No se pudo modificar el registro, Error: '.$e.'</div>';
			}
		}

		public function eliminar(){        
			$this->sql = "DELETE FROM niveles WHERE CODNIVEL = ?";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->CODNIVEL);
				if($stm->execute()){
					$reg = '<div class="alert alert-success" role="alert">Registro Eliminado con éxito</div>';
				}else{
					$reg = '<div class="alert alert-warning" role="alert">Falló al tratar de eliminar el registro</div>';
				}
				echo $reg;
			} catch (Exception $e) {
				echo '<div class="alert alert-danger" role="alert">No se pudo eliminar el registro, Error: '.$e.'</div>';
			}
		}
		
	  	public function segunCurso(){
	  		$this->sql = "SELECT n.* FROM niveles n INNER JOIN grados gr ON gr.CODNIVEL = n.`CODNIVEL` INNER JOIN cursos cr ON cr.CODGRADO = gr.CODGRADO WHERE cr.`codCurso` = '".$this->curso."' ORDER BY orden ASC";
	  		try {
	  			$stm = $this->Conexion->prepare($this->sql);
	  			$stm->execute();
	  			$datos = $stm->fetchAll(PDO::FETCH_ASSOC);
	  			return $datos;
	  		} catch (Exception $e) {
	  			echo "Error al listar los niveles. ".$e;
	  		}
	  	}
	}
