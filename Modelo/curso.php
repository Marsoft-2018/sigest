<?php 
	
	class Curso extends ConectarPDO
	{
	    public $registro = array();
	    Public $codSede;
	    Public $curso;
		public $tipoUsuario;
		public $idUsuario;
		public $anho;
		public $grado;
		public $grupo;
		public $jornada;
		public $periodo;
	    private $sql;
		
	    public function listar(){
	    	$this->tipoUsuario = $_SESSION['rol'];
	    	switch ($this->tipoUsuario) {
	    		case 'Administrador':
					$this->sql = "SELECT DISTINCT(cr.`codCurso`),cr.codSede,cr.CODGRADO,  cr.grupo, cr.idJornada, CONCAT (sd.`NOMSEDE`,' - ',cr.`CODGRADO`,'° ',cr.`grupo`) AS nombreCurso FROM cursos cr INNER JOIN sedes sd ON sd.`CODSEDE` = cr.codSede ";
		    		if (isset($this->codSede)) {
		    			$this->sql .= " WHERE cr.codSede ='".$this->codSede."' ORDER BY cr.`codSede`, cr.codgrado, cr.grupo ASC";
		    		}else{
		    			$this->sql .= " ORDER BY cr.`codSede`, cr.codgrado, cr.grupo ASC";
		    		}
    			break;
	    		case 'Profesor':
	    			$this->sql = "SELECT DISTINCT(cr.`codCurso`),cr.codSede, cr.CODGRADO,  cr.grupo, cr.idJornada,CONCAT (cr.`CODGRADO`,'° ',cr.`grupo`) AS nombreCurso FROM cursos cr INNER JOIN cargaacademica_new car ON car.codcurso = cr.codcurso WHERE car.codProfesor ='".$this->idUsuario."' AND car.`anho` ='".$this->anho."' ORDER BY cr.codgrado, cr.grupo ASC";
	    			break;	
	    		default:
	    			break;
	    	}
			try{
				$stm = $this->Conexion->prepare($this->sql);
				$stm->execute();
				$this->registro = $stm->fetchAll(PDO::FETCH_ASSOC);
				return $this->registro;
			}catch(PDOException $e){
				echo "Ocurrio un error: ".$e;
			}
	    }

	    public function listaXsedes(){
			$this->sql = "SELECT cr.*, niveles.`NOMBRE_NIVEL`,grados.NOMGRADO FROM cursos cr INNER JOIN grados ON grados.`CODGRADO` = cr.CODGRADO INNER JOIN niveles ON niveles.`CODNIVEL` = grados.`CODNIVEL` WHERE cr.`codSede` = '".$this->codSede."' ORDER BY cr.CODGRADO, cr.grupo ASC";
			try{
				$stm = $this->Conexion->prepare($this->sql);
				$stm->execute();
				$this->registro = $stm->fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				echo "Ocurrio un error: ".$e;
			}
			return $this->registro;
	    }

	    public function consultarGrado(){
	        $this->sql = "SELECT cur.`CODGRADO`, cur.`grupo`,g.`NOMGRADO` FROM cursos cur inner join grados g ON cur.`CODGRADO`= g.`CODGRADO` WHERE cur.codCurso='".$this->curso."'";
			try{
				$stm = $this->Conexion->prepare($this->sql);
				$stm->execute();
				$this->registro = $stm->fetchAll(PDO::FETCH_ASSOC);
				return $this->registro;
			}catch(PDOException $e){
				echo "Ocurrio un error: ".$e;
			}
	    }

	    public function verificarDireccionDeGrupo(){
            $this->sql = "SELECT codProfesor FROM direccioncursos WHERE codCurso='".$this->curso."'";
			try{
				$stm = $this->Conexion->prepare($this->sql);
				$stm->execute();
				$this->registro = $stm->fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				echo "Ocurrio un error: ".$e;
			}
			return json_encode($this->registro);
        }

	    public function cambiarJornada(){
	        $this->sql = "UPDATE cursos SET idJornada = ? WHERE  codCurso = '".$this->curso."'";
			try{
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindparam(1,$this->jornada);
				$stm->execute();
				echo "Jornada cambiada con éxito";
			}catch(PDOException $e){
				echo "Ocurrio un error: ".$e;
			}
	    }

	    public function agregar(){
	        $this->sql = "INSERT INTO cursos(codSede, CODGRADO, grupo, idJornada) VALUES(?,?,?,?)";
			try{
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindparam(1,$this->codSede);
				$stm->bindparam(2,$this->grado);
				$stm->bindparam(3,$this->grupo);
				$stm->bindparam(4,$this->jornada);
				$stm->execute();
				echo "Curso Agregado con éxito";
			}catch(PDOException $e){
				echo "Ocurrio un error: ".$e;
			}
	    }

	    public function eliminar(){
	        $this->sql = "DELETE FROM cursos WHERE  codCurso = ?";
			try{
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindparam(1,$this->curso);
				$stm->execute();
				echo "El registro del curso fue eliminado con éxito";
			}catch(PDOException $e){
				echo "Ocurrio un error: ".$e;
			}
	    }  

	    public function esDirector(){
	    	$this->sql = "select codCurso FROM direccioncursos where codProfesor = '".$this->idUsuario."' AND codCurso = '".$this->curso."' AND anho = '".$this->anho."'";
			try{
				$reg = false;
				$stm = $this->Conexion->prepare($this->sql);
				$stm->execute();
				$reg = $stm->fetchAll(PDO::FETCH_ASSOC);
				foreach ($reg as $value) {
					$reg = true;
				}
				return $reg;
			}catch(PDOException $e){
				echo "Ocurrio un error: ".$e;
			}
	    }

	}
 ?>