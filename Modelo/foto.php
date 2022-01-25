<?php 
    //require("matricula.php");
    //require("Conect.php");
	class Foto extends ConectarPDO{
        public $IDUsuario;
        public $Rol;
        public $foto;
        private $sql;

        public function cambiarFoto(){ 
            switch ($this->Rol) {
                case 'Profesor':
                    $this->sql ="UPDATE profesores SET foto = ? WHERE idUsuario = '".$this->IDUsuario."' ";
                    break;
                case 'Administrador':
                    $this->sql ="UPDATE t_users SET foto = ? WHERE usuario = '".$this->IDUsuario."' ";
                    break;
                case 'Estudiante':
                    # code...
                    break;
                
                default:
                    # code...
                    break;
            }

            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1, $this->foto);
                $stm->execute();
                echo $this->foto;
            } catch (Exception $e) {
                echo "Error en la validacion. ".$e;
            }          
        }
    }

    // $obj = new Estudiantes();
    // $obj->curso = 18;
    // $obj->anho = 2020;
    // $obj->sede = '213244000880';
    // $datos = $obj->consulta();
    // echo "<pre>";
    // var_dump($datos);
    // echo "</pre>";
 ?>