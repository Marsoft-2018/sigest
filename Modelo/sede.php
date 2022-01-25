<?php
    class Sede extends ConectarPDO
    {        
      public $CODINST;
      public $CODSEDE;
      public $NOMSEDE;
      public $curso;
      private $sql;
        public function cargar(){
            $this->CODINST = $_SESSION['institucion'];
            $this->sql = "SELECT * FROM sedes WHERE CODSEDE ='".$this->CODSEDE."' AND CODINST='".$this->CODINST."' ORDER BY NOMSEDE ASC";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
                return $reg;                
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }
        }

        public function listar(){
            $this->CODINST = $_SESSION['institucion'];
            $this->sql = "SELECT * FROM sedes WHERE CODINST ='".$this->CODINST."' ORDER BY NOMSEDE ASC";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
                return $reg;                
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }
        }

        public function reportes(){
            $this->CODINST = $_SESSION['institucion'];
            $this->sql = "SELECT sd.* FROM sedes sd INNER JOIN cursos cr ON cr.`codSede` = sd.`CODSEDE` WHERE sd.CODINST='".$this->CODINST."' AND cr.`codCurso` = '".$this->curso."' ORDER BY sd.NOMSEDE ASC";
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
            $this->sql = "INSERT INTO sedes(CODINST, CODSEDE, NOMSEDE) VALUES(?,?,?)";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1, $_SESSION['institucion']);
                $stm->bindParam(2, $this->CODSEDE);
                $stm->bindParam(3, $this->NOMSEDE);
                $stm->execute();
                echo "La Sede sa ha agregado satisfactoriamente";
            } catch (Exception $e) {
                echo "Ocurrio un error al insertar la sede. <br>".$e;
            }
        }

        public function modificar(){
            $this->sql = "UPDATE sedes SET  NOMBRE = ? WHERE id='".$this->CODSEDE."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1, $this->NOMSEDE);
                $stm->execute();
            } catch (Exception $e) {
                echo "Ocurrio un error al modificar el nombre de la sede. <br>".$e;
            }
        }

        public function eliminar(){
            $this->sql = "DELETE FROM sedes WHERE CODSEDE='".$this->CODSEDE."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                echo "El registro de la Sede fue eliminado con éxito";
            } catch (Exception $e) {
                echo "Ocurrio un error al eliminar la sede. <br>".$e;
            }
        }

        public function totalSedes(){
            $this->CODINST = $_SESSION['institucion'];
            $this->sql = "SELECT COUNT(NOMSEDE) AS Total FROM sedes WHERE CODINST='".$this->CODINST."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
                foreach ($reg as $dato) {
                    $reg = $dato['Total'];
                }
                return $reg;                
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }
        }

        public function sedeCurso($curso){
            ;
            $this->sql = "SELECT sd.`CODSEDE` AS sede FROM cursos cr INNER JOIN sedes sd ON sd.`CODSEDE` = cr.`codSede` WHERE cr.`codCurso` = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1,$curso);
                $stm->execute();
                $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
                foreach ($reg as $dato) {
                    $reg = $dato['sede'];
                }
                return $reg;                
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }
        } 
    }

