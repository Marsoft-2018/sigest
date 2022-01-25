<?php 

class grados extends ConectarPDO{
    public $sede;
    public $CODNIVEL;
    public $CODGRADO;
    public $NOMGRADO;
    public $nomCampo;
    private $sql;

    public function listar1($sede,$nivel,$gradoTope){
        if($nivel=='PRE'){ $n=0; }
        if($nivel=='PRI'){ $n=1; }
        if($nivel=='SEC'){ $n=6; }
        if($nivel=='MED'){ $n=10;}
        if($nivel=='CI1'){ $n=111;}
        if($nivel=='CI2'){ $n=114;}
        if($nivel=='CI3'){ $n=116;}
        if($nivel=='CI4'){ $n=118;}
        if($nivel=='CI5'){ $n=120;}
        if($nivel=='CI6'){ $n=121;}
        if($nivel=='Todos'){
            $n=0;
            while($n<=$gradoTope){
                if($n==0){
                   $insertGradoTemp=mysql_query("INSERT INTO grados_temp values('$sede','PRE','$n','1');");                       
                }elseif($n<=5){
                    $insertGradoTemp=mysql_query("INSERT INTO grados_temp values('$sede','PRI','$n','1');");                          
                }elseif($n<=9){
                   $insertGradoTemp=mysql_query("INSERT INTO grados_temp values('$sede','SEC','$n','1');");    
                }elseif($n<=11){
                  $insertGradoTemp=mysql_query("INSERT INTO grados_temp values('$sede','MED','$n','1');");   
                }elseif($n>110 and $n<=113){
                  $insertGradoTemp=mysql_query("INSERT INTO grados_temp values('$sede','CI1','$n','1');");  
                }elseif($n>113 and $n<=115){
                  $insertGradoTemp=mysql_query("INSERT INTO grados_temp values('$sede','CI2','$n','1');");  
                }elseif($n>115 and $n<=117){
                  $insertGradoTemp=mysql_query("INSERT INTO grados_temp values('$sede','CI3','$n','1');");  
                }elseif($n>117 and $n<=119){
                  $insertGradoTemp=mysql_query("INSERT INTO grados_temp values('$sede','CI4','$n','1');");  
                }elseif($n==120){
                  $insertGradoTemp=mysql_query("INSERT INTO grados_temp values('$sede','CI5','$n','1');");  
                }elseif($n==121){
                  $insertGradoTemp=mysql_query("INSERT INTO grados_temp values('$sede','CI6','$n','1');");  
                }
                $n++;
            }
        }else{
            while($n<=$gradoTope){
                $insertGradoTemp=mysql_query("INSERT INTO grados_temp values('$sede','$nivel','$n','1');");                                      
                $n++;
            }
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

    public function modificar($clave,$sede,$valor){             
        $sqlActualiza=mysql_query("UPDATE grados_temp SET topeGrupos='$valor' WHERE CODGRADO='$clave' AND codsede='$sede';");                     
    }

    public function eliminar($sede,$id_aEliminar){
       $sqlEliminar=mysql_query("DELETE FROM grados_temp WHERE CODGRADO='$id_aEliminar' AND codsede='$sede';");
    }

    public function trasladar($sede){//no funcionó hay que revisar donde está el problema porque no está guardando en la tabla cursos
        //echo "Entró al metodo trasladar con la sede: $sede";
        $sqlRecorre=mysql_query("SELECT * FROM grados_temp WHERE codsede='$sede';");
        while($re=mysql_fetch_array($sqlRecorre)){
            $n=1;
            while($n<=$re[3]){
                $sqlTraslada=mysql_query("INSERT INTO `cursos`(`codSede`, `CODGRADO`, `grupo`, `idJornada`) VALUES('$sede','$re[2]','$n','1');");
                $n++;
            }
            
        }
        $sqlEliminar=mysql_query("DELETE FROM grados_temp WHERE codsede='$sede';");
        
    }      
}
