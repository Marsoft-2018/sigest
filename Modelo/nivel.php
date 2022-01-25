<?php 
	class Nivel extends ConectarPDO{
		public $CODNIVEL;
	  	public $NOMBRE_NIVEL;
	  	public $orden;
	  	public $curso;
	  	private $sql;
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
