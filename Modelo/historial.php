<?php 
	class Historial extends ConectarPDO{
		public $inst;
        public $anho;
        public $modelo;
        public $areasReprobadas;
        public $sql;
        
        public function Cargar(){
            $this->inst = $_SESSION['institucion'];
            $this->sql = "SELECT MAX(Alectivo) AS anho FROM a_lectivo WHERE codInst='".$this->inst."'"; 
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
            $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $key => $value) {
            	$anhoActual = $value['anho']; 
            }
            return $anhoActual;
        }

        public function Listar(){
            $this->inst = $_SESSION['institucion'];
            $this->sql = "SELECT Alectivo FROM a_lectivo WHERE codInst='".$this->inst."' ORDER BY Alectivo DESC";
            try {
             	$stm = $this->Conexion->prepare($this->sql);
             	$stm->execute();
             	$resultado = $stm->fetchAll(PDO::FETCH_ASSOC);
             	return $resultado;
             } catch (Exception $e) {
             	echo "Ocurrió un error: ".$e;
             } 
        }
    }

?>