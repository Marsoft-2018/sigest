<?php
	class Guia extends ConectarPDO{
		public $id;
		public $idProfesor;
		public $idCurso;
		public $idArea;
		public $guia;
		public $sede;
		public $fecha_reg;
		public $estado;
		private $sql;

		public function cargar() {
			$con = 0;
			$this->sql = "SELECT g.id,CONCAT(p.`PrimerNombre`,' ', p.`SegundoNombre`,' ', p.`PrimerApellido`,' ', p.`SegundoApellido`) AS profesor, a.`Nombre`  AS n_area,CONCAT(c.`CODGRADO`,'° ',c.`grupo`) AS grado,g.`guia`,g.`estado` FROM guias g INNER JOIN profesores p ON p.`IDUsuario` = g.`idProfesor` INNER JOIN cursos c ON c.`codCurso` = g.`idCurso` INNER JOIN areasxsedes a ON a.`idAreaSede` = g.`idArea` WHERE g.id = ? ";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->id);
				$stm->execute();
				$reg = $stm->fetchAll(PDO::FETCH_ASSOC);
				return $reg;
			} catch (Exception $e) {
				echo "Error en la validacion. ".e;
			}

			if($con == 0){
				return false;
			}
		}

		public function listar() {
			$con = 0;
			$this->sql = "SELECT g.id,CONCAT(p.`PrimerNombre`,' ', p.`SegundoNombre`,' ', p.`PrimerApellido`,' ', p.`SegundoApellido`) AS profesor, a.`Nombre`  AS n_area,CONCAT(c.`CODGRADO`,'° ',c.`grupo`) AS grado,g.`guia`,g.`estado`,sd.`NOMSEDE` AS sede FROM guias g INNER JOIN profesores p ON p.`IDUsuario` = g.`idProfesor` INNER JOIN sedes sd ON sd.`CODSEDE` = p.`codsede` INNER JOIN cursos c ON c.`codCurso` = g.`idCurso` INNER JOIN areasxsedes a ON a.`idAreaSede` = g.`idArea` WHERE g.estado = 1 ";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->execute();
				$reg = $stm->fetchAll(PDO::FETCH_ASSOC);
				return $reg;
			} catch (Exception $e) {
				echo "Error en la validacion. ".e;
			}

			if($con == 0){
				return false;
			}
		}

		public function listarProfesor() {
			$con = 0;
			$this->sql = "SELECT g.id,CONCAT(p.`PrimerNombre`,' ', p.`SegundoNombre`,' ', p.`PrimerApellido`,' ', p.`SegundoApellido`) AS profesor, a.`Nombre`  AS n_area,CONCAT(c.`CODGRADO`,'° ',c.`grupo`) AS grado,g.`guia`,g.`estado`,sd.`NOMSEDE` AS sede FROM guias g INNER JOIN profesores p ON p.`IDUsuario` = g.`idProfesor` INNER JOIN sedes sd ON sd.`CODSEDE` = p.`codsede` INNER JOIN cursos c ON c.`codCurso` = g.`idCurso` INNER JOIN areasxsedes a ON a.`idAreaSede` = g.`idArea` WHERE g.`idProfesor` = '".$this->idProfesor."' AND g.estado = 1 ";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->execute();
				$reg = $stm->fetchAll(PDO::FETCH_ASSOC);
				return $reg;
			} catch (Exception $e) {
				echo "Error en la validacion. ".e;
			}

			if($con == 0){
				return false;
			}
		}

		public function agregar(){
			$this->sql ="INSERT INTO guias(idProfesor, idCurso, idArea, guia) VALUES(?,?,?,?)";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1,$this->idProfesor);
				$stm->bindParam(2,$this->idCurso);
				$stm->bindParam(3,$this->idArea);
				$stm->bindParam(4,$this->guia);
				$stm->execute();
				echo "<div class='alert alert-success' role='alert'>Guía guardada con éxito</div>";
			} catch (Exception $e) {
				echo "error al guardar los datos: ".$e;
			}
		}

		public function actualizar(){
			$this->sql ="UPDATE t_users SET idProfesor=?, idCurso=?, idArea=?, guia=? WHERE id = '".$this->id."' ";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1,$this->idProfesor);
				$stm->bindParam(2,$this->idCurso);
				$stm->bindParam(3,$this->idArea);
				$stm->bindParam(4,$this->guia);
				$stm->execute();
				// session_start();
				// session_unset();
				// $this->login();
				// header("Location: /appGestiondeactivos/inicio.php");
				echo "<div class='alert alert-success' role='alert'>Registro guardado con éxito</div>";
			} catch (Exception $e) {
				echo "error al guardar los datos: ".$e;
			}
		}

		public function eliminar(){
			$this->sql = "DELETE FROM guias WHERE id = ?";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1,$this->id);
				$stm->execute();
				echo "El registro de la guia fue eliminado con éxito";
			} catch (Exception $e) {
				echo "error al eliminar los datos de esta guia: ".$e;
			}
		}

		public function profesores(){
			$this->sql = "SELECT idUsuario,CONCAT(`PrimerNombre`,' ', `SegundoNombre`,' ', `PrimerApellido`,' ', `SegundoApellido`) AS nombre FROM profesores WHERE estado = 'Activo' ORDER BY nombre ASC";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->execute();
				$reg = $stm->fetchAll(PDO::FETCH_ASSOC);
				return $reg;
			} catch (Exception $e) {
				echo "Error en la validacion. ".e;
			}
		}

		public function sedes(){
			$this->sql = "SELECT * FROM sedes ORDER BY NOMSEDE asc";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->execute();
				$reg = $stm->fetchAll(PDO::FETCH_ASSOC);
				return $reg;
			} catch (Exception $e) {
				echo "Error en la validacion. ".e;
			}
		}

		public function cursos(){
	        $this->sql = "SELECT c.`codCurso`,c.`grupo`, c.CODGRADO FROM cursos c WHERE c.`codSede`='".$this->sede."' ORDER BY c.CODGRADO, c.`grupo` ASC";
	        try {
	            $stm = $this->Conexion->prepare($this->sql);
	            $stm->execute();
	            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);
	            return $reg;
	        } catch (Exception $e) {
	            echo "Error: ".$e;
	        }
	    }

	    public function cargarRol($usuario){
		    $tipoDeUsuario = "Profesor";
		    
		    $this->sql = "SELECT  tRol.Tipo FROM roles rl INNER JOIN tipoderol tRol ON rl.`idRol`=tRol.`idRol` WHERE idUsuario='$usuario'";
	        try {
	            $stm = $this->Conexion->prepare($this->sql);
	            $stm->execute();
	            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);
	            foreach ($reg as $value) {
	            	$tipoDeUsuario = $value['Tipo'];
	            }
	            return $tipoDeUsuario;
	        } catch (Exception $e) {
	            echo "Error: ".$e;
	        }

	    }

	}
?>