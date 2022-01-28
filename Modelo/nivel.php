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
					$reg = "resgistro agregado con éxito";
				}else{
					$reg = "Falló al agregar el registro";
				}
				echo $reg;
			} catch (Exception $e) {
				echo "Error: ".$e;
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
					$reg = "resgistro modificado con éxito";
				}else{
					$reg = "Falló al tratar de modificar el registro";
				}
				echo $reg;
			} catch (Exception $e) {
				echo "Error: ".$e;
			}
		}

		public function eliminar(){        
			$this->sql = "DELETE FROM niveles WHERE CODNIVEL = ?";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->CODNIVEL);
				if($stm->execute()){
					$reg = "resgistro Eliminado con éxito";
				}else{
					$reg = "Falló al tratar de eliminar el registro";
				}
				echo $reg;
			} catch (Exception $e) {
				echo "Error: ".$e;
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
