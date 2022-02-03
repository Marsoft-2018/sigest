<?php 

class Grado extends ConectarPDO{
    public $sede;
    public $CODNIVEL;
    public $CODGRADO;
    public $NOMGRADO;
    public $nomCampo;
    public $estiloDesempeno;
    private $sql;

    public function agregar(){        
        $this->sql = "INSERT INTO grados(CODNIVEL,CODGRADO,NOMGRADO,nomCampo,estiloDesempeno) VALUES(?,?,?,?,?)";
        try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindParam(1, $this->CODNIVEL);
            $stm->bindParam(2, $this->CODGRADO);
            $stm->bindParam(3, $this->NOMGRADO);
            $stm->bindParam(4, $this->nomCampo);
            $stm->bindParam(5, $this->estiloDesempeno);
            if($stm->execute()){
                $reg = '<div class="alert alert-success" role="alert">Registro agregado con éxito</div>';
            }else{
                $reg = '<div class="alert alert-warning" role="alert">Falló al agregar el registro</div>';
            }
            echo $reg;
        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">Error al agregar el registro: '.$e.'</div>';
        }
    }

    public function cargar(){
        $this->sql = "SELECT * FROM grados WHERE CODGRADO = ?";
        try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindparam(1,$this->CODGRADO);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $reg;
        } catch (Exception $e) {
            
        }
    }

    public function listar(){
        $this->sql = "SELECT * FROM grados ORDER BY CODGRADO ASC";
        try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $reg;
        } catch (Exception $e) {
            
        }
    }

    public function listarPorNivel(){
        $this->sql = "SELECT * FROM grados WHERE CODNIVEL='".$this->CODNIVEL."'";
        try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $reg;
        } catch (Exception $e) {
            
        }
    }

    public function cargarGradosTemp(){
        $this->sql = "SELECT * from grados_temp WHERE codsede='".$this->sede."' ORDER BY CODGRADO";
        try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $reg;
        } catch (Exception $e) {
            echo "Error: ".$e;
        }
    }

    public function cargarCursos(){
        $this->sql = "SELECT c.`codCurso`,n.`NOMBRE_NIVEL`,g.`NOMGRADO`,c.`grupo`,j.`idJornada`, c.CODGRADO,g.`nomCampo` FROM niveles n INNER JOIN grados g ON n.`CODNIVEL`=g.`CODNIVEL` INNER JOIN cursos c ON c.`CODGRADO`=g.`CODGRADO` INNER JOIN jornadas j ON j.`idJornada`=c.`idJornada` WHERE c.`codSede`='".$this->sede."' ORDER BY c.CODGRADO, c.`grupo` ASC";
        try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->execute();
            $reg = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $reg;
        } catch (Exception $e) {
            echo "Error: ".$e;
        }
    }

    public function modificar(){        
        $this->sql = "UPDATE grados SET NOMGRADO = ?, nomCampo = ?, estiloDesempeno = ? WHERE CODGRADO = ?";
        try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindParam(1, $this->NOMGRADO);
            $stm->bindParam(2, $this->nomCampo);
            $stm->bindParam(3, $this->estiloDesempeno);
            $stm->bindParam(4, $this->CODGRADO);
            if($stm->execute()){
                $reg = "resgistro actualizado con éxito";
            }else{
                $reg = "Falló la actualización del registro";
            }
            echo $reg;
        } catch (Exception $e) {
            echo "Error: ".$e;
        }
    }

    public function eliminar(){
       $this->sql = "DELETE FROM grados WHERE CODGRADO = ?";
        try {
            $stm = $this->Conexion->prepare($this->sql);
            $stm->bindParam(1, $this->CODGRADO);
            if($stm->execute()){
                $reg = "Registro eliminado con éxito";
            }else{
                $reg = "Falló la eliminación del registro";
            }
            echo $reg;
        } catch (Exception $e) {
            echo "Error: ".$e;
        }
    }    
}
