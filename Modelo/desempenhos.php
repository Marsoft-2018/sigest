<?php 
    class Desempenos extends ConectarPDO{
        public $idInst;
        public $limiteInf;
        public $limiteSup;
        public $CONCEPT;
        public $idDes;
        public $nota;
        private $sql;

        public function Listar(){
            $this->idInst = $_SESSION['institucion'];
            $this->sql = "SELECT * FROM desempenos Where CODINST = ? order by limiteInf";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->idInst);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Ocurrió un error al momento al tratar de obtener los desempeños. ".$e;
            }  
        }

        public function cargar(){
            $this->sql = "SELECT limiteInf, limiteSup, CONCEPT, emoticon FROM desempenos WHERE CODINST = 1 ORDER BY limiteInf DESC";
            try {
                $notaN = "";
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                if($this->nota > 0){
                    $notaN = round($this->nota,1);
                }
               foreach ($datos as $concep) {
                   if($notaN >= $concep['limiteInf'] && $notaN <= $concep['limiteSup']){
                        $this->CONCEPT = $concep['CONCEPT'];
                    }
               }
               return $this->CONCEPT;
            } catch (Exception $e) {
                echo "Ocurrió un error al tratar de obtener los desempeños. ".$e;
            }  
        }

        public function Guardar(){
            $this->idInst = $_SESSION['institucion'];
            $this->sql = "INSERT INTO desempeNos (CODINST, limiteInf, limiteSup, CONCEPT)  VALUES (?,?,?,?)";
            // echo "la institucion es: ".$this->idInst." Infe: ".$this->limiteInf." Sup: ".$this->limiteSup." el desempeño es: ".$this->CONCEPT;
            try {
                $stm = $this->Conexion->prepare($this->sql);                
                $stm->bindparam(1,$this->idInst);
                $stm->bindparam(2,$this->limiteInf);
                $stm->bindparam(3,$this->limiteSup);
                $stm->bindparam(4,$this->CONCEPT);
                $stm->execute();
            } catch (Exception $e) {
                echo "Ocurrió un error al tratar de agregar el desempeño. ".$e;
            }
        }
        
        public function Eliminar(){            
            $this->idInst = $_SESSION['institucion'];
            $this->sql = "DELETE FROM desempeNos WHERE CODINST='".$this->idInst."' AND idDes='".$this->idDes."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
            } catch (Exception $e) {
                 echo "Ocurrió un error al momento de eliminar el desempeño. ".$e;
            }
        }

        public function Modificar($campo,$clave,$valor){
            //echo "la institucion es: ".$institucion." el desempeño es: ".$DesempenoNom." Infer: ".$desempenoVmin." Sup: ".$desempenoVmax;
            $this->idInst = $_SESSION['institucion'];
            $campo = "`".str_replace("`","``",$campo)."`";
            $this->sql = "UPDATE desempeNos SET $campo = '$valor' WHERE idDes = '$clave' AND CODINST='".$this->idInst."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
            } catch (Exception $e) {
                echo "Ocurrió un error al momento de modificar el desempeño. ".$e;
            }
        }

        public function load(){
            $this->sql = "SELECT * FROM desempenos WHERE idDes = ? ORDER BY limiteInf DESC";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->idDes);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Ocurrió un error al tratar de obtener los desempeños. ".$e;
            }  
        }

    }
?>