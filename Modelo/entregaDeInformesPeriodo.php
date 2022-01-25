<?php 
// session_start();
// require("Conect.php")	;
    class entregaDeInformesPeriodo extends ConectarPDO{
		public $id;
		public $periodo;
		public $curso;
		public $fecha;
        public $anho;
        public $idMatricula;
        public $estado;
    	private $sql;

        public function cargar(){
            $this->sql = "SELECT * FROM entrega_informes WHERE idCurso = ? AND periodo = ? AND anho = ? AND estado = 1";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->curso);
                $stm->bindparam(2,$this->periodo);
                $stm->bindparam(3,$this->anho);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "error al cargar los datos: <br>".$e;
            }            
        }

        public function Guardar(){            
        	$this->sql = "INSERT INTO entrega_informes (idCurso,periodo, fecha, anho) VALUES(?,?,?,?)";
        	
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->curso);
                $stm->bindparam(2,$this->periodo);
                $stm->bindparam(3,$this->fecha);
                $stm->bindparam(4,$this->anho);
                $stm->execute();
                echo "<br>Guardado con éxito";
            } catch (Exception $e) {
                echo "<br>Ocurrió un error al guardar el periodo. <br>".$e;
            }              
        }

        public function Modificar(){ 
            $this->sql = "UPDATE entrega_informes SET fecha = ? WHERE periodo = '".$this->periodo."' AND idCurso = '".$this->curso."' AND anho = '".$this->anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->fecha);
                $stm->execute();
                echo "<br>Guardado con éxito";
            } catch (Exception $e) {
                echo "<br>Ocurrió un error al actualizar la fecha. <br>".$e;
            }       
        }

        public function Eliminar(){
            $this->sql = "DELETE FROM entrega_informes WHERE periodo = '".$this->periodo."' AND idCurso = '".$this->curso."' AND anho = '".$this->anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                echo "<br>Eliminado con éxito";
            } catch (Exception $e) {
                echo "Ocurrió un error al eliminar ".$e;
            }            
        }
        
        public function validar(){            
            $this->sql = "SELECT id FROM exepciones_entrega WHERE idEntrega = ? AND idMatricula = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->id);
                $stm->bindparam(2,$this->idMatricula);
                $stm->execute();
                $respuesta = $stm->fetchAll(PDO::FETCH_ASSOC);
                $habilitado = "true";
                foreach ($respuesta as $value) {
                    $habilitado = "false";
                }
                return $habilitado;
            } catch (Exception $e) {
                echo "Error al consultar la excepción. ".$e;
            }           
        }

        public function habilitarEstudiante(){  
            if ($this->estado == 'true') {
                $this->sql = "INSERT INTO exepciones_entrega(idEntrega, idMatricula) VALUES(?,?)";
                try {
                    $stm = $this->Conexion->prepare($this->sql);
                    $stm->bindparam(1,$this->id);
                    $stm->bindparam(2,$this->idMatricula);
                    $stm->execute();
                    echo "<i class='fa fa-check-circle'></i> Listo";
                } catch (Exception $e) {
                    echo "Error al consultar la excepción. ".$e;
                } 
            }else{
                $this->sql = "DELETE FROM exepciones_entrega WHERE idEntrega = ? AND idMatricula = ?";
                try {
                    $stm = $this->Conexion->prepare($this->sql);
                    $stm->bindparam(1,$this->id);
                    $stm->bindparam(2,$this->idMatricula);
                    $stm->execute();
                    echo "<i class='fa fa-check-circle'></i> Listo";
                } catch (Exception $e) {
                    echo "Error al consultar la excepción. ".$e;
                } 
            }           
        }

        public function verificarEstudiante(){            
            $this->sql = "SELECT id FROM exepciones_entrega WHERE idMatricula = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->idMatricula);
                $stm->execute();
                $respuesta = $stm->fetchAll(PDO::FETCH_ASSOC);
                $habilitado = "true";
                foreach ($respuesta as $value) {
                    $habilitado = "false";
                }
                return $habilitado;
            } catch (Exception $e) {
                echo "Error al consultar la excepción. ".$e;
            }           
        }
    }
    
