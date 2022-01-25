<?php
    abstract class Conectar{
        protected $serv="localhost";
        protected $usu="root";
        protected $pass="";
        protected $bdt = "personeros";
        protected $con;
        function __construct(){
            $this->con= mysql_connect($this->serv,$this->usu,$this->pass) or die ("No se pudo conectar");
            mysql_select_db($this->bdt,$this->con);
            return $this->con;    
        }
        public function cerrarConexion(){
            mysql_close($this->con);
        }

    }
?>

