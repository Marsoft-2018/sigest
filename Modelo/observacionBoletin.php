<?php
          
    class observacionBoletin extends ConectarPDO{
        public $id;
        public $anho;
        public $periodo;
        public $idMatricula;
        public $curso;
        public $observacion;
        public $estado;
        public $fecha_reg;

        private $sql;

        public function cargar(){
            $this->sql = "SELECT * FROM observacionesboletin WHERE idMatricula = ? AND periodo= ? AND anho= ?";
            try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindParam(1, $this->idMatricula);
            $stm->bindParam(2, $this->periodo);			
            $stm->bindParam(3, $this->anho);
            $stm->execute();
            $registros = $stm->fetchAll(PDO::FETCH_ASSOC);  
            return $registros; 				
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }
        }

        public function agregar(){
            $this->sql = "INSERT INTO observacionesboletin(anho,periodo, idMatricula, curso, observacion) VALUES(?,?,?,?,?)";
            try {
                $stm = $this->Conexion->prepare($this->sql);		
                $stm->bindParam(1, $this->anho);
                $stm->bindParam(2, $this->periodo);
                $stm->bindParam(3, $this->idMatricula);
                $stm->bindParam(4, $this->curso);
                $stm->bindParam(5, $this->observacion);		
                $stm->execute();
            } catch (Exception $e) {
                echo "Ocurrio un error al insertar la observación al estudiante. <br>".$e;
            }
        }

        public function modificar(){
            $this->sql = "UPDATE observacionesboletin SET  observacion = ? WHERE id = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1, $this->observacion);
                $stm->bindParam(2, $this->id);
                if($stm->execute()){
                    echo "Observación guardada con éxito";
                }
            } catch (Exception $e) {
                echo "Ocurrio un error al agregar la observación. <br>".$e;
            }
        }

        public function eliminar(){
            $this->sql = "DELETE FROM observacionesboletin WHERE id= ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1, $this->id);
                if($stm->execute()){
                    echo "Observación eliminada con éxito";
                }
            } catch (Exception $e) {
                echo "Ocurrio un error al insertar el area. <br>".$e;
            }
        }

        public function listar(){
            $this->sql = "SELECT * FROM observacionesboletin WHERE anho= :anho AND periodo = :periodo AND curso = :curso ORDER BY id ASC";
            try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindParam(':anho', $this->anho);
            $stm->bindParam(':periodo', $this->periodo);
            $stm->bindParam(':curso', $this->curso);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
            return $reg; 			
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }
        }
    }  
?>