<?php 
	class Anho extends ConectarPDO{
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

        public function Agregar(){
            $this->sql = "INSERT INTO a_lectivo(codInst,Alectivo) VALUE(?,?)";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$_SESSION['institucion']);
                $stm->bindparam(2,$this->anho);
                $stm->execute();
             } catch (Exception $e) {
                echo "Ocurrió un error: ".$e;
             } 
        }

        public function guardarModelo(){
            $this->inst = $_SESSION['institucion'];
            $this->anho = $this->cargar();
            $this->sql = "UPDATE a_lectivo SET modeloBoletin = ?, areasReprobadas = ? WHERE codInst ='".$this->inst."' AND Alectivo = '".$this->anho."' ";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->modelo);
                $stm->bindparam(2,$this->areasReprobadas);
                $stm->execute();
             } catch (Exception $e) {
                echo "Ocurrió un error: ".$e;
             } 
        }

        public function modeloInforme(){
            $this->inst = $_SESSION['institucion'];
            $this->sql = "SELECT modeloBoletin, areasReprobadas FROM a_lectivo WHERE codInst = ? AND Alectivo = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->inst);
                $stm->bindparam(2,$this->anho);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $data; 
            } catch (Exception $e) {
                echo "Error al consultar los datos de la institucion: <br>".$e;
            }
        }

        public function cierre(){
            $this->inst = $_SESSION['institucion'];
            $this->anho = $this->cargar();
            $this->sql = "UPDATE a_lectivo SET estado = 2 WHERE codInst ='".$this->inst."' AND Alectivo = '".$this->anho."' ";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->modelo);
                $stm->bindparam(2,$this->areasReprobadas);
                $stm->execute();
                
                try {
                    $sql2 = "SELECT modeloBoletin, areasReprobadas FROM a_lectivo WHERE Alectivo = '".$this->anho."'";
                    $stm = $this->Conexion->prepare($sql2);
                    $stm->execute(); 
                    $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($data as $value) {
                        $this->modelo = $value['modeloBoletin'];
                        $this->areasReprobadas = $value['areasReprobadas'];
                    }
                    try {
                        $anhoSig = $this->anho + 1;
                        $this->sql = "INSERT INTO a_lectivo(codInst, Alectivo, modeloBoletin, areasReprobadas) VALUE(?,?,?,?)";
                        try {
                            $stm = $this->Conexion->prepare($this->sql);
                            $stm->bindparam(1,$_SESSION['institucion']);
                            $stm->bindparam(2,$anhoSig);
                            $stm->bindparam(3,$this->modelo);
                            $stm->bindparam(4,$this->areasReprobadas);
                            $stm->execute();

                            $sql3 = "SELECT * FROM tipos_planilla WHERE anho = '".$this->anho."' ";
                            $stm3 = $this->Conexion->prepare($sql3);
                            $stm3->execute();
                            $tipo = $stm3->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($tipo as $ti) {
                                $sql4 = "INSERT INTO tipos_planilla VALUES(?,?,?,?,?)";
                                $stm4 = $this->Conexion->prepare($sql4);
                                $stm4->bindparam(1,$anhoSig);
                                $stm4->bindparam(2,$ti['tipo']);
                                $stm4->bindparam(3,$ti['cantidad_notas']);
                                $stm4->bindparam(4,$ti['tipo_promedio']);
                                $stm4->bindparam(5,$ti['tipo_logro']);
                                $stm4->execute();
                            }
                            echo "<div class='alert alert-success'>El procedimiento de cierre del año lectivo termino con éxito. Puede continuar con el proceso de promoción";
                            echo "<h4>El año lectivo actual es el:  <strong>".$anhoSig."</strong></h4></div>";

                         } catch (Exception $e3) {
                            echo "Ocurrió un error: ".$e3;
                         } 
                    } catch (Exception $e2) {
                        echo "Ocurrió un error 2: ".$e3;
                    }
                } catch (Exception $e) {
                    echo "Ocurrió un error: ".$e3;
                }
             } catch (Exception $e) {
                echo "Ocurrió un error: ".$e;
             } 
        }
    }

?>