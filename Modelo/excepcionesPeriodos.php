<?php 
// session_start();
// require("Conect.php")	;
    class excepcionPeriodo extends ConectarPDO{
		public $id;
		public $periodo;
		public $idUsuario;
		public $fechaInicio;
		public $fechaCierre;
        public $anho;
    	private $sql;

        public function cargar(){
            $this->sql = "SELECT fechaInicio, fechaCierre FROM excepciones_periodos WHERE periodo = ? AND idUsuario = ? AND anho = ? ";
            try {
            	$stm = $this->Conexion->prepare($this->sql);
            	$stm->bindparam(1,$this->periodo);
                $stm->bindparam(2,$this->idUsuario);
                $stm->bindparam(3,$this->anho);
            	$stm->execute();
            	$datos = $stm->fetchAll(PDO::FETCH_ASSOC);
            	return $datos;
            } catch (Exception $e) {
            	echo "error Al cargar los ajustes";
            }            
        }

        public function Guardar(){            
        	$this->sql = "INSERT INTO excepciones_periodos (periodo, idUsuario, fechaInicio, fechaCierre,anho) VALUES(?,?,?,?,?)";
        	
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->periodo);
                $stm->bindparam(2,$this->idUsuario);
                $stm->bindparam(3,$this->fechaInicio);
                $stm->bindparam(4,$this->fechaCierre);
                $stm->bindparam(5,$this->anho);
                $stm->execute();
                echo "<br>Guardado con éxito";
            } catch (Exception $e) {
                echo "<br>Ocurrió un error al guardar el periodo. <br>".$e;
            }              
        }

        public function Modificar(){ 
            $this->sql = "UPDATE excepciones_periodos SET fechaInicio = ?, fechaCierre = ? WHERE periodo = '".$this->periodo."' AND idUsuario = '".$this->idUsuario."' AND anho = '".$this->anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->fechaInicio);
                $stm->bindparam(2,$this->fechaCierre);
                $stm->execute();
                echo "<br>Guardado con éxito";
            } catch (Exception $e) {
                echo "<br>Ocurrió un error al actualizar el periodo. <br>".$e;
            }       
        }

        public function Eliminar(){
            $this->sql = "DELETE FROM excepciones_periodos WHERE periodo = '".$this->periodo."' AND idUsuario = '".$this->idUsuario."' AND anho = '".$this->anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                echo "<br>Eliminado con éxito";
            } catch (Exception $e) {
                echo "Ocurrió un error al eliminar ".$e;
            }            
        }
        
        public function validar(){
            $resultado = 15;
            $this->sql = "SELECT fechaInicio, fechaCierre FROM excepciones_periodos WHERE periodo = '".$this->periodo."' AND anho = '".$this->anho."' AND idUsuario = '".$this->idUsuario."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $respuesta = $stm->fetchAll(PDO::FETCH_ASSOC);
                $fechaHoy = date('Y-m-d');   //$fechaHoy=('2016-02-20');
                foreach ($respuesta as $plazo) {                    
                    if($fechaHoy >= $plazo['fechaInicio'] and $fechaHoy <= $plazo['fechaCierre']){
                        $f1 = date_create(''.$fechaHoy);
                        $f2 = date_create(''.$plazo['fechaCierre']);
                        $intervalo = date_diff($f1, $f2);
                        if($intervalo->format('%R')=='+'){
                            if($intervalo->format('%a')>=10){                                    
                                $resultado = "<div class='alert alert-success' style = 'margin:20px; height:30px; padding:1px; text-align:center;'>Faltan %a días para cerrar el periodo $this->periodo</div>";
                            }elseif($intervalo->format('%a')<10){
                                $resultado = $intervalo->format("<div class='alert alert-warning' style = 'margin:20px; height:30px; padding:1px; text-align:center;'>Tiene una excepción de tiempo y Faltan %a días para cerrarse</div>");
                            }
                        }
                    }else{                            
                        $resultado = 15;
                    }           
                }
                return $resultado;
            } catch (Exception $e) {
                echo "Error al consultar los periodos. ".$e;
            }           
        }
    }
    
