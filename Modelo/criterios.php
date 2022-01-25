<?php 
    class Criterio extends ConectarPDO{
        public $codinst;
        public $id;
        public $nombre;
        public $porcentaje;
        private $sql;
        public function Listar(){
            $this->sql = "SELECT * FROM criterios WHERE codinst= ? order by codCriterio";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$_SESSION['institucion']);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Ocurrió un error al consultar los criterios. ".$e;
            }           
        }

        public function Agregar(){
            $this->codinst = $_SESSION['institucion'];
            $this->sql = "INSERT INTO criterios(codinst, nomCriterio, porcentaje) VALUES (?,?,?)";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codinst);
                $stm->bindparam(2,$this->nombre);
                $stm->bindparam(3,$this->porcentaje);
                $stm->execute();
            } catch (Exception $e) {
                echo "Ocurrió un error al guardar el criterio. ".$e;
            }   
        }

        public function Modificar(){
            $this->sql = "UPDATE criterios SET nomCriterio = :criterio, porcentaje = :porcentaje WHERE codCriterio = :clave";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(':clave',$this->id);
                $stm->bindparam(':criterio',$this->nombre);
                $stm->bindparam(':porcentaje',$this->porcentaje);
                $stm->execute();
                echo "Criterio guardado con éxito";
            } catch (Exception $e) {
                echo "Ocurrió un error al actualizar el criterio. ".$e;
            }
        }

        public function Eliminar(){ 
            $this->codinst = $_SESSION['institucion'];           
            $this->sql = "DELETE FROM criterios WHERE codinst = ?  AND codCriterio = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codinst);
                $stm->bindparam(2,$this->id);
                $stm->execute();
            } catch (Exception $e) {
                echo "Ocurrió un error al eliminar el criterio. ".$e;
            }
        }

        public function conteoCriterios(){
            $total = 0;
            $this->sql = "SELECT COUNT(codCriterio) AS total FROM criterios WHERE codinst= ? order by codCriterio";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$_SESSION['institucion']);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datos as $value) {
                    $total = $value['total'];
                }
                return $total;
            } catch (Exception $e) {
                echo "Ocurrió un error al consultar los criterios. ".$e;
            }  
        }
        
    }
