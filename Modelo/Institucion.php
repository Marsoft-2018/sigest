<?php
   //require ('Conect.php');

   class Institucion extends ConectarPDO{
		public $id;
		public $nombre;
		public $dane;
		public $nit;
		public $direccion;
		public $telefono;
		public $rector;
		public $logo;
		public $icfes;
		public $resolucion;
		public $correo;
		public $ciudad;
		public $membrete;
        private $sql;
        
        public function Cargar(){
            //$this->sql = "SELECT * FROM centroeducativo WHERE id = ?";
            $this->sql = "SELECT * FROM centroeducativo";
            try {
            	$stm = $this->Conexion->prepare($this->sql);
            	//$stm->bindparam(1,$_SESSION['institucion']);
            	$stm->execute();
            	$data = $stm->fetchAll(PDO::FETCH_ASSOC);
            	return $data; 
            } catch (Exception $e) {
            	echo "Error al consultar los datos de la institucion: <br>".$e;
            }
        }

        public function validarActivacion($rol){
            $this->sql = "SELECT activacion, dias, estado from centroeducativo where id = ? ";
            $datos = array();
            //echo "Institucion: ".$_SESSION['institucion']."<br>";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$_SESSION['institucion']);
                $stm->execute();
                $respuesta = $stm->fetchAll(PDO::FETCH_ASSOC);
                $fechaHoy = date('Y-m-d');   //$fechaHoy=('2016-02-20');
                $men = "";
                foreach ($respuesta as $plazo) {
                    $diasTranscurridos = -1; 
                   
                    $f1 = date_create(''.$plazo['activacion']);
                    $f2 = date_create(''.$fechaHoy);
                    $intervalo = date_diff($f1, $f2);

                    if($intervalo->format('%R')=='+'){ $diasTranscurridos = $intervalo->format('%a'); }
                    // echo "Fecha de incio: ".$plazo['activacion']."<br>";    
                    // echo "Fecha de hoy: ".$fechaHoy."<br>";    
                    
                    // echo "Dias transcurridos: ".$diasTranscurridos."<br>";
                    
                    if($diasTranscurridos >= $plazo['dias']){
                        $men = "<div class='alert alert-danger' style = 'padding:10px; text-align:center;'>La plataforma se encuentra cerrada el periodo de activación se supera por ".($diasTranscurridos - $plazo['dias']  )." dias</div>";
                        
                        $datos['mensaje'] = [$men];
                        $datos['estado'] = [2];
                        //$men = 2;
                    }elseif($diasTranscurridos >= ($plazo['dias'] - 30) && $diasTranscurridos <= $plazo['dias']){
                        $men = "<div class='alert alert-warning' style = 'padding:10px; text-align:center;'>El periodo de activación de la plataforma esta próximo a terminar Faltan ".($plazo['dias'] - $diasTranscurridos )." días</div>";
                        if($rol != "Administrador"){
                            $men = "";
                        }
                        $datos['mensaje'] = [$men];
                        $datos['estado'] = [3];
                        //$men = 3;
                    }elseif($diasTranscurridos < ($plazo['dias'] - 30) && $diasTranscurridos >= 0){
                        $men = "<div class='alert alert-success' style = 'padding:10px; text-align:center;'>Todo Ok</div>";
                        $datos['mensaje'] = [$men];
                        $datos['estado'] = [1];
                        //$men = 1;
                    }else{
                        $men = "<div class='alert alert-danger' style = 'padding:1px; text-align:center;'>La plataforma se encuentra cerrada error en la fecha de activación</div>";
                        $datos['mensaje'] = [$men];
                        $datos['estado'] = [4];
                    }
                }
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar. ".$e;
            }   
        }
    }
?>