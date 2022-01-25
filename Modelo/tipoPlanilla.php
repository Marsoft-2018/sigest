<?php 
// session_start();
// require("Conect.php")	;
    class tipoPlanilla extends ConectarPDO{
        public $anho;
        public $tipo;
        public $cantidad_notas;
        public $tipo_promedio;
        public $tipo_logros;
    	private $sql;

        public function cargar(){
            $this->sql = "SELECT * FROM tipos_planilla WHERE anho = ? ";
            try {
            	$stm = $this->Conexion->prepare($this->sql);
            	$stm->bindparam(1,$this->anho);
            	$stm->execute();
            	$datos = $stm->fetchAll(PDO::FETCH_ASSOC);
            	return $datos;
            } catch (Exception $e) {
            	echo "error Al cargar los ajustes";
            }            
        }

        public function Agregar(){
        	$this->sql = "INSERT INTO tipos_planilla (anho, tipo, cantidad_notas, tipo_promedio,tipo_logro) VALUES(?,?,?,?,?)";        	
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->anho);
                $stm->bindparam(2,$this->tipo);
                $stm->bindparam(3,$this->cantidad_notas);
                $stm->bindparam(4,$this->tipo_promedio);
                $stm->bindparam(5,$this->tipo_logros);
                $stm->execute();
                echo "Tipo de planilla guardada con éxito";
            } catch (Exception $e) {
                echo "<br>Ocurrió un error al guardar el tipo de planilla. <br>".$e;
            }              
        }

        public function Modificar(){ 
            $this->sql = "UPDATE tipos_planilla SET tipo = '".$this->tipo."', cantidad_notas = '".$this->cantidad_notas."', tipo_promedio = '".$this->tipo_promedio."', tipo_logro = '".$this->tipo_logros."' WHERE anho = '".$this->anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                echo "Tipo de planilla guardada con éxito";
            } catch (Exception $e) {
                echo "<br>Ocurrió un error al actualizar el periodo. <br>".$e;
            }       
        }

        public function Eliminar(){
            $this->sql = "DELETE FROM tipos_planilla WHERE anho = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->anho);
                $stm->execute();
            } catch (Exception $e) {
                echo "Ocurrió un error al eliminar el tipo de planilla. ".$e;
            }            
        }
    }
    
