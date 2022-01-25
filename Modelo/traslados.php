<?php
   // require ('Conect.php');
   class Traslado extends ConectarPDO{
    public $id;
		public $codSede;
		public $idMatricula;
		public $anho;
    public $areaOrigen;
    public $abreviatura;
    public $nombre;
		public $idGrado;
    public $cursoOrigen;
    public $codSedeDestino;
    public $areaDestino;
    public $cursoDestino;
    public $idAsignatura;
    public $nombreAsignatura;
		private $sql;

    public function areasSedeDestino(){
      $this->sql = "SELECT axs.`codsede`,axs.`id`,axs.`Abreviatura`,axs.`Nombre`,axs.`formaDePromediar`,ih.`idGrado`,ih.`intensidad` FROM areas_intensidad ih INNER JOIN areasxsedes_2 axs ON axs.`id` = ih.`idArea` INNER JOIN areas_anho ara ON ara.`idArea` = axs.`id` WHERE axs.codSede ='".$this->codSede."' AND ara.anho='".$this->anho."' AND ih.`intensidad` != 0 AND ih.idGrado='".$this->idGrado."' AND axs.`Abreviatura` = '".$this->abreviatura."' AND axs.`Nombre` = '".$this->nombre."'";
      try {
        $stm = $this->Conexion->prepare($this->sql);
        $stm->execute();
        $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
        return $reg;        
      } catch (Exception $e) {
        echo "Error al consultar los datos. <br>".$e;
      }
    }

    public function cambiarCalificaciones(){
      $this->sql = "UPDATE notas SET codArea = ?, curso = ? WHERE idMatricula = ? AND codArea = ? AND curso = ? AND Anho = ?";
      try {
        $stm = $this->Conexion->prepare($this->sql);
        $stm->bindparam(1,$this->areaDestino);
        $stm->bindparam(2,$this->cursoDestino);
        $stm->bindparam(3,$this->idMatricula);
        $stm->bindparam(4,$this->areaOrigen);
        $stm->bindparam(5,$this->cursoOrigen);
        $stm->bindparam(6,$this->anho);
        $stm->execute();
        //echo "Calificaciones trasladadas con éxito";
      } catch (Exception $e) {
        echo "Error al trasladar las calificaciones";
      }
    }

    public function nombreEstudiante($id){
      $sql = "SELECT est.PrimerNombre,est.SegundoNombre,est.PrimerApellido,est.SegundoApellido  FROM estudiantes est INNER JOIN matriculas mt ON mt.Documento = est.Documento WHERE mt.idMatricula = ? ";
      try {
        $stm = $this->Conexion->prepare($sql);
        $stm->bindparam(1,$id);
        $stm->execute();
        $dato = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($dato as $value) {
          $dato = $value['PrimerNombre']." ".$value['SegundoNombre']." ".$value['PrimerApellido']." ".$value['SegundoApellido'];
        }
        return $dato;
      } catch (Exception $e) {
        
      }
    }

		public function finalizar(){
			$this->sql = "UPDATE matriculas SET codsede = ?, Curso = ? WHERE idMatricula = ?";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->codSedeDestino);
				$stm->bindParam(2, $this->cursoDestino);
				$stm->bindParam(3, $this->idMatricula);
				$stm->execute();
        $estudiante = $this->nombreEstudiante($this->idMatricula);
        echo "<div class='alert alert-success'><p>El Estudiante ".$estudiante." fue trasladado con éxito</p></div>";
			} catch (Exception $e) {
				echo "<div class='alert alert-danger'><p>Error al trasladar al Estudiante ".$estudiante." <br>".$e."</p></div>";
			}
		}

		
   }
         
?>
