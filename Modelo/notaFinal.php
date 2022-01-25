<?php 
	class notaFinal extends Conectar{
        public $definitiva=0;    
        public $totalHoras;
        public $notaPromedio;
        public $PorcentajePer;
        public $promedioDefinitivo=0;
        public $promedioAcumulado=0;
        public $conteoAreas=0;
        
        public function cargar($codArea,$campoIH,$anho,$centro,$idMatricula,$tipoPromedio){
            //Obtengo el periodo max y el periodo min
            $periodoMin = periodoMin($centro);
            $periodoMax = periodoMax($centro);
            
            $sql_horasAreas = mysql_query("SELECT `$campoIH` FROM areasxsedes WHERE `idAreaSede`='$codArea';");
            while($ho=mysql_fetch_array($sql_horasAreas)){
                $this->totalHoras=$ho[0]; //INTENSIDAD HORARIA
            }

            //Bucle para recorrer cada uno de los periodos y obtener cada una de las notas
            for($per = $periodoMin; $per <= $periodoMax; $per++){
                //Consulto el valor en porcentaje del periodo en los ajustes
                $sql_porPer = mysql_query("SELECT AJ.`valorPeriodo` FROM ajustes AJ INNER JOIN centroeducativo cen ON cen.`CODINST`=AJ.`idCentro` WHERE  AJ.`periodo`='$per' AND cen.`CODINST`='$centro'");   

                while($pr = mysql_fetch_array($sql_porPer)){
                    $this->PorcentajePer=($pr[0]/100);
                }
                
                //Consulta para conocer si el area tiene notas directas 
                $resultnotas=mysql_query("SELECT notas.`codArea`,IFNULL(notas.NOTA,0) AS nota,notas.PERIODO FROM notas INNER JOIN matriculas mt ON mt.`idMatricula` = notas.`idMatricula` WHERE notas.`PERIODO`='$per' AND notas.`idMatricula` = '$idMatricula' AND notas.codArea='$codArea' AND mt.anho='$anho'"); 

                $tieneNotas=mysql_num_rows($resultnotas);
                if($tieneNotas > 0){                    
                    while ($fila2=mysql_fetch_array($resultnotas)){
                        $notaAct=$fila2[1];
                        $this->definitiva = ($notaAct * $this->PorcentajePer) + $this->definitiva;                   
                    }                    
                }else{                        
                    /*el calculo de la Nota promedio del area dependiendo de la forma de promediarla */ 
                    $bol = new Boletin();                    
                    $this->notaPromedio=$bol->promedioAreas($centro,$this->totalHoras,$codArea,$anho,$per,$idMatricula,$tipoPromedio,$campoIH);
                    $this->definitiva = ($this->notaPromedio * $this->PorcentajePer) + $this->definitiva;
                }
            }// Fin del bucle para recorrer los periodos               
            return round($this->definitiva,1);            
        } //Fin del metodo Cargar
        
        public function cargarPromedio($campoIH,$anho,$centro,$idMatricula,$sede){
        	$cursoAct;
            $sqlCurso=mysql_query("SELECT Curso FROM matriculas WHERE idMatricula = '$idMatricula';");
            while($cr=mysql_fetch_array($sqlCurso)){
                $cursoAct=$cr[0];
            } 
            //Condicion en caso de que el usuario no sea un profesor
            //----- Consulto todas las areas asignadas a la sede ----------// 
            $sqlAreas = mysql_query("SELECT axs.idAreaSede,axs.abreviatura,axs.nombre,axs.`formaDePromediar` FROM areasxsedes axs WHERE axs.codsede='$sede' AND axs.`$campoIH`<>0 AND axs.ih<>0;");
            $rcargar = mysql_num_rows($sqlAreas);//--- almaceno la cantidad de registro para conocer si hubo algun resultado con las áreas
            if($rcargar > 0){// Verifico si existe algún registro relacionado con la consulta 
                while($a = mysql_fetch_array($sqlAreas)){                    
                    $objNuevaNota = new notaFinal();
                    $this->promedioAcumulado = ($this->promedioAcumulado + $objNuevaNota->cargar($a[0],$campoIH,$anho,$centro,$idMatricula,$a[3]));
                }
                $this->promedioDefinitivo=$this->promedioAcumulado/$rcargar;
            }
            return $this->promedioDefinitivo;
        }       
    }//Fin Clase Nota definitiva o final OK

?>