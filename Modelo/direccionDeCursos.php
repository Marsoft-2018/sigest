<?php
    class DireccionCurso extends ConectarPDO{
        public $codCurso;
        public $codProfesor;
        public $ID;
        public $anho;
        private $sql;

        public function cargar(){
            $this->sql = "SELECT CONCAT (prof.`PrimerNombre`,' ',prof.`SegundoNombre`,' ', prof.`PrimerApellido`,' ',prof.`SegundoApellido`)  AS nombre FROM direccioncursos dirc INNER JOIN cursos cr ON cr.codCurso = dirc.codCurso INNER JOIN profesores prof ON prof.Documento = dirc.codProfesor WHERE cr.codCurso = '".$this->codCurso."' AND dirc.anho = '".$this->anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al cargar el director de grupo. ".$e;
            }                  
        } 

        public function guardar(){
            $this->sql = "INSERT INTO direccioncursos (codCurso,codProfesor,anho) VALUES(?,?,?)";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codCurso);
                $stm->bindparam(2,$this->codProfesor);
                $stm->bindparam(3,$this->anho);
                $stm->execute();
                echo "<div class='alert alert-success'>
                    Se asignó la dirección del curso con éxito
                </div>";
            } catch (Exception $e) {
                echo "Error al guardar la direccion de grupo. ".$e;
            }
            
        }

        public function quitar(){
            $this->sql = "DELETE FROM direccioncursos WHERE codCurso = ? and anho = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codCurso);
                $stm->bindparam(2,$this->anho);
                $stm->execute();
                echo "<div class='alert alert-success'>
                    Se quitó la dirección del curso con éxito
                </div>";
            } catch (Exception $e) {
                echo "Error al quitar la direccion de grupo. ".$e;
            }

        }
        

        public function verificar(){
            $this->sql = "SELECT ID FROM direccioncursos WHERE codCurso = ? AND anho = ? AND codProfesor = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codCurso);
                $stm->bindparam(2,$this->anho);
                $stm->bindparam(3,$this->codProfesor);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                $respuesta = array();
                $respuesta['estado'] = [false];
                foreach($datos as $value) {                    
                    $respuesta['estado'] = [true];
                }
                return $respuesta;
            } catch (Exception $e) {
                echo "Error al cargar el director de grupo. ".$e;
            }
        }
    }  

?>