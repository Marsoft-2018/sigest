<?php 
// session_start();
// require("Conect.php")	;
    class Periodo extends ConectarPDO{
		public $idCentro;
		public $periodo;
		public $valorPeriodo;
		public $fechaInicio;
		public $fechaCierre;
        public $anho;
        public $datos;
    	private $sql;

        public function cargar(){
            $idInst = $_SESSION['institucion'];
            $this->sql = "SELECT aj.* FROM ajustes aj WHERE aj.idCentro= ? ";
            try {
            	$stm = $this->Conexion->prepare($this->sql);
            	$stm->bindparam(1,$idInst);
            	$stm->execute();
            	$datos = $stm->fetchAll(PDO::FETCH_ASSOC);
            	return $datos;
            } catch (Exception $e) {
            	echo "error Al cargar los ajustes";
            }            
        }

        public function valorPeriodo(){
            $idInst = $_SESSION['institucion'];
            $this->sql = "SELECT valorPeriodo FROM ajustes WHERE idCentro= 1 AND periodo = '".$this->periodo."' ";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "error Al cargar los ajustes";
            }            
        }

        public function Guardar(){
            $this->idCentro = $_SESSION['institucion'];
        	$this->sql = "INSERT INTO ajustes (idCentro, periodo, valorPeriodo, fechaInicio, fechaCierre) VALUES(?,?,?,?,?)";
        	
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->idCentro);
                $stm->bindparam(2,$this->periodo);
                $stm->bindparam(3,$this->valorPeriodo);
                $stm->bindparam(4,$this->fechaInicio);
                $stm->bindparam(5,$this->fechaCierre);
                $stm->execute();
            } catch (Exception $e) {
                echo "<br>Ocurrió un error al guardar el periodo. <br>".$e;
            }              
        }

        public function Modificar($campo, $clave, $valor){ 
            $idInst = $_SESSION['institucion'];
             $campo = "`".str_replace("`","``",$campo)."`";
             $this->sql = "UPDATE ajustes SET $campo = '".$valor."' WHERE periodo = '".$clave."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
            } catch (Exception $e) {
                echo "<br>Ocurrió un error al actualizar el periodo. <br>".$e;
            }       
        }

        public function Eliminar(){
            $this->idCentro = $_SESSION['institucion'];
            $this->sql = "DELETE FROM ajustes WHERE idCentro = ?  AND periodo = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->idCentro);
                $stm->bindparam(2,$this->periodo);
                $stm->execute();
            } catch (Exception $e) {
                echo "Ocurrió un error al eliminar el periodo. ".$e;
            }            
        }

        public function periodoMin(){
            $pMin = 0;
            $idInst = $_SESSION['institucion'];
            $this->sql = "SELECT MIN(AJ.periodo) AS periodo FROM ajustes AJ WHERE AJ.idCentro='".$idInst."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $key => $per) {
                    $pMin = $per['periodo'];
                }
            } catch (Exception $e) {
                echo "Error no existen periodos: ".$e;
            }
            return $pMin;
        }
        
        public function periodoMax(){
            $pMax=0;
            $idInst = $_SESSION['institucion'];          
            $this->sql = "SELECT MAX(AJ.periodo) AS periodo FROM ajustes AJ WHERE AJ.idCentro='".$idInst."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $key => $per) {
                    $pMax = $per['periodo'];
                }
                return $pMax;
            } catch (Exception $e) {
                echo "Error no existen periodos: ".$e;
            }
        }
        
        public function ValidarPeriodo(){
            $datos = array();
            $this->sql = "SELECT fechaInicio, fechaCierre FROM ajustes WHERE ajustes.`idCentro` = '".$_SESSION['institucion']."' AND ajustes.`periodo` = '".$this->periodo."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $respuesta = $stm->fetchAll(PDO::FETCH_ASSOC);
                $fechaHoy = date('Y-m-d');   //$fechaHoy=('2016-02-20');
                foreach ($respuesta as $plazo) {
                    $anhoPeriodo = substr($plazo['fechaCierre'],0,4);
                    
                    if($anhoPeriodo != $this->anho){
                            $men = "<div class='alert alert-danger' style = 'margin:20px; height:30px; padding:1px; text-align:center;'>El periodo $this->periodo se encuentra por fuera del tiempo estipulado para calificaciones.</div>";
                            $datos['mensaje'] = [$men];
                            $datos['estado'] = [false];
                    }else{
                        if($fechaHoy >= $plazo['fechaInicio'] and $fechaHoy <= $plazo['fechaCierre']){
                            $f1 = date_create(''.$fechaHoy);
                            $f2 = date_create(''.$plazo['fechaCierre']);
                            $intervalo = date_diff($f1, $f2);
                            if($intervalo->format('%R')=='+'){
                                if($intervalo->format('%a')>=10){
                                    $men = $intervalo->format("<div class='alert alert-success' style = 'margin:20px; height:30px; padding:1px; text-align:center;'>Faltan %a días para cerrar el periodo $this->periodo</div>");
                                    $datos['mensaje'] = [$men];
                                    $datos['estado'] = [true];
                                }elseif($intervalo->format('%a')<10){
                                    $men = $intervalo->format("<div class='alert alert-warning' style = 'margin:20px; height:30px; padding:1px; text-align:center;'>Faltan %a días para cerrar el periodo $this->periodo</div>");
                                    $datos['mensaje'] = [$men];
                                    $datos['estado'] = [true];
                                }
                            }
                        }else{
                            $men = "";
                            $estado = "";
                            require("excepcionesPeriodos.php");
                            $objExcepcion = new excepcionPeriodo();
                            $objExcepcion->periodo = $this->periodo;
                            $objExcepcion->anho = $this->anho;
                            $objExcepcion->idUsuario = $_SESSION['idUsuario'];
                            $respon = $objExcepcion->validar();
                            if ($respon != 15) {                                
                                $men = $respon;
                                $estado = true;
                            }else{
                                $men = "<div class='alert alert-danger' style = 'margin:20px; height:30px; padding:1px; text-align:center;'>El periodo $this->periodo se encuentra por fuera del tiempo estipulado para calificaciones.</div>";
                                $estado = false;
                            }
                            
                            $datos['mensaje'] = [$men];
                            $datos['estado'] = [$estado];
                        }                    
                    }               
                }
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar los periodos. ".$e;
            }           
        }
    }
    
