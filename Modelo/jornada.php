<?php 

class Jornada extends ConectarPDO{
 
 	public $idJornada;
 	public $abreviatura;
 	public $Nombre;
    private $sql;

    public function listar(){
    	$this->sql = "SELECT * FROM jornadas";
        try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $reg;
        } catch (Exception $e) {
            
        }
    }

    public function cargar(){
    	$this->sql = "SELECT * FROM jornadas  WHERE idJornada='".$this->idJornada."'";
        try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $reg;
        } catch (Exception $e) {
            
        }
    }
}