<?php 
	class Puesto extends ConectarPDO{
        public $idMatri;
        public $cur;
        public $anno;
        public $per;
        public $grado;
        public $sede;
        public $totalAreas;
        public $calificacion;
        public $totalEstudiantes;
        public $listaEstudiantes = array();
        public $promedioEstudiante;
        public $puesto;

        public function puestoEstudiante(){
            /*
                _______________________________________________________________________________________ 
                Algoritmo básico para realizar el almacenamiento de los datos para ordenar los puestos 
                _______________________________________________________________________________________

                $promedios = array('est1'=>1.2,'est2'=>4.2,'est3'=>3.2,'est4'=>5.2,'est5'=>2.2);
                $numero = count($promedios);
                echo "Total registros ".$numero."<br>";
                arsort($promedios);
                $cont=1;

                //ejemplo
                while (list($clave, $valor) = each($promedios)) {
                    echo "Clave: $clave; Valor: $valor -- Puesto: $cont<br />\n";
                    $cont++;
                }            
            */
            //1- recorro la tabla estudiantes para ir almacenando el promedio de cada uno en el array
            error_reporting(0);

            $promedios = array();
            $sw=1;
            foreach ($this->listaEstudiantes as $estudiante) {
                $objCal = new Calificacion();
                $objCal->periodo = $this->per;
                $objCal->idMatricula = $estudiante['idMatricula'];
                $objCal->Anho = $this->anno;
                $objCal->curso = $this->cur;

                //$promedios[$estudiante['idMatricula']] = round($objCal->promedioEstudiante() / $this->totalAreas,2);
                $promedios[$estudiante['idMatricula']] = $objCal->promedioEstudiante() / $this->totalAreas;
                $this->totalEstudiantes++;
            }
            arsort($promedios,SORT_NUMERIC);
            $cont=1;
            while (list($clave, $valor) = each($promedios) and $sw=1) {
                if($clave==$this->idMatri){
                    echo $cont; 
                    $sw=0;
                }                
                $cont++;
            }            
        }//OK Fin Puestos

        public function finalGrupo($centro,$sede,$anho,$periodoBol,$curso,$idMatricula){           
            //1- recorro la tabla estudiantes para ir almacenando el promedio de cada uno en el array
            // error_reporting(0);
            $sql_estudiantes=mysql_query("SELECT idMatricula FROM matriculas WHERE curso='$curso' AND estado='Matriculado' AND anho = '$anho';");
            $promedios=array();
            $sw=1;
            while($est=mysql_fetch_array($sql_estudiantes)){
                $promedioEst=0;
                $sumaNotas=0;
                $sqlAreasEnsede=mysql_query("SELECT * FROM areasxsedes axs WHERE axs.`CODSEDE`='$sede';");//Consultar rodas la areas
                $TotalAreas=mysql_num_rows($sqlAreasEnsede);// Obtener el número de áreas
                //Consulto para conocer si el area tiene notas directas 
                $resultnotas=mysql_query("SELECT notas.nota FROM notas WHERE notas.`Anho`='$anho' AND notas.`idMatricula` = '$est[0]'"); 
                $tieneNotas=mysql_num_rows($resultnotas);//--si existen notas directamente en el area el resultado sera mayor que cero
                if($tieneNotas>0){                    
                   while ($ntA=mysql_fetch_array($resultnotas)){//recorro todas las notas que tiene el estudiante en el periodo
                       $sumaNotas=$sumaNotas+$ntA[0];
                   }
                }
                $sqlAreasConAignaturas=mysql_query("SELECT * FROM areasxsedes axs WHERE NOT EXISTS (SELECT nota FROM notas WHERE notas.`codArea` = axs.`idAreaSede`  AND notas.`idMatricula`='$est[0]' AND notas.`Anho`='$anho')  AND axs.`CODSEDE`='$sede'");
                $resNotasAs=mysql_num_rows($sqlAreasConAignaturas);
                if($resNotasAs>0){
                    for($p=1;$p<=4;$p++){
                        while($aAsig=mysql_fetch_array($sqlAreasConAignaturas)){
                             $prome=new Boletin();
                             $notaPromedio=$prome->promedioAreas($centro,$aAsig[3],$aAsig[1],$anho,$p,$est[0],$aAsig[4]);
                             $sumaNotas=$sumaNotas+$notaPromedio;    
                        }
                    }
                    $promedioEst=($sumaNotas/($TotalAreas*4));
                    $promedios[$est[0]]=$promedioEst;
                }
            }
            arsort($promedios);
            $cont=1;
            while (list($clave, $valor) = each($promedios) and $sw=1) {
                if($clave==$idMatricula){
                    echo $cont; 
                    $sw=0;
                }                
                $cont++;
            }            
        }

        public function finalGrado($centro,$sede,$anho,$periodoBol,$curso,$alumnoe){            
            //1- recorro la tabla estudiantes para ir almacenando el promedio de cada uno en el array
            error_reporting(0);
            $sql1;
            $sql_estudiantes;
            $grado;
            $sqlGrado=mysql_query("SELECT g.codgrado FROM grados g INNER JOIN cursos cr ON cr.`CODGRADO`=g.`CODGRADO` WHERE cr.`codCurso`='$curso';");
            while($g=mysql_fetch_array($sqlGrado)){
                $grado=$g[0];
                $sql1="SELECT mt.`idMatricula` FROM matriculas mt INNER JOIN cursos ON cursos.`codCurso`= mt.`Curso` INNER JOIN grados ON grados.`CODGRADO`=cursos.`CODGRADO` WHERE grados.`CODGRADO` ='$grado' AND mt.estado='Matriculado' AND mt.anho = '$anho';";
            }
            
            $sql_estudiantes=mysql_query($sql1);
            $promedios=array();
            $sw=1;
            while($est=mysql_fetch_array($sql_estudiantes)){   
                $promedioEst=0;
                $sumaNotas=0;
                
                $sqlAreasEnsede=mysql_query("SELECT * FROM areasxsedes axs WHERE axs.`CODSEDE`='$sede';");
                $TotalAreas=mysql_num_rows($sqlAreasEnsede);
                //Consulto para conocer si el area tiene notas directas 
                $resultnotas=mysql_query("SELECT notas.nota FROM notas WHERE notas.`Anho`='$anho' AND notas.`idMatricula`='$est[0]'"); 
                $tieneNotas=mysql_num_rows($resultnotas);
                if($tieneNotas>0){  
                   while ($ntA=mysql_fetch_array($resultnotas)){
                       $sumaNotas=$sumaNotas+$ntA[0];                       
                   }
                }
                
                $sqlAreasConAignaturas=mysql_query("SELECT * FROM areasxsedes axs WHERE NOT EXISTS (SELECT nota FROM notas WHERE notas.`codArea` = axs.`idAreaSede`  AND notas.`idMatricula`='$est[0]' AND notas.`Anho`='$anho')  AND axs.`CODSEDE`='$sede'");
                $resNotasAs=mysql_num_rows($sqlAreasConAignaturas);
                if($resNotasAs>0){
                    for($p=1;$p<=4;$p++){
                        while($aAsig=mysql_fetch_array($sqlAreasConAignaturas)){
                             $prome=new Boletin();
                             $notaPromedio=$prome->promedioAreas($centro,$aAsig[3],$aAsig[1],$anho,$p,$est[0],$aAsig[4]);
                             $sumaNotas=$sumaNotas+$notaPromedio; 
                            //echo "--Suma: ".$sumaNotas."<br>";
                        }
                    }
                    $promedioEst=($sumaNotas/$TotalAreas);
                    $promedios[$est[0]]=$promedioEst;
                }
            }
            arsort($promedios);
            $cont=1;
            while (list($clave, $valor) = each($promedios) and $sw=1) {
                if($clave==$alumnoe){
                    echo $cont; 
                    $sw=0;
                }                
                $cont++;
            }           
        }

        public function finalSede($centro,$sede,$anho,$periodoBol,$curso,$alumnoe){
            //1- recorro la tabla estudiantes para ir almacenando el promedio de cada uno en el array
            error_reporting(0);
            $sql_estudiantes=mysql_query("SELECT idMatricula FROM matriculas WHERE codsede='$sede' AND estado='Matriculado' AND anho = '$anho' ORDER BY idMatricula, curso ASC;");
            $promedios=array();
            $sw=1;
            while($est=mysql_fetch_array($sql_estudiantes)){   
                $promedioEst=0;
                $sumaNotas=0;
                
                $sqlAreasEnsede=mysql_query("SELECT * FROM areasxsedes axs WHERE axs.`CODSEDE`='$sede';");
                $TotalAreas=mysql_num_rows($sqlAreasEnsede);
                //Consulto para conocer si el area tiene notas directas 
                $resultnotas=mysql_query("SELECT notas.nota FROM notas WHERE notas.`Anho`='$anho' AND notas.`idMatricula`='$est[0]'"); 
                $tieneNotas=mysql_num_rows($resultnotas);
                if($tieneNotas>0){  
                   while ($ntA=mysql_fetch_array($resultnotas)){
                       $sumaNotas=$sumaNotas+$ntA[0];                       
                   }
                }
                
                $sqlAreasConAignaturas=mysql_query("SELECT * FROM areasxsedes axs WHERE NOT EXISTS (SELECT nota FROM notas WHERE notas.`codArea` = axs.`idAreaSede`  AND notas.`idMatricula`='$est[0]' AND notas.`Anho`='$anho')  AND axs.`CODSEDE`='$sede'");
                $resNotasAs=mysql_num_rows($sqlAreasConAignaturas);
                if($resNotasAs>0){
                    for($p=1;$p<=4;$p++){
                        while($aAsig=mysql_fetch_array($sqlAreasConAignaturas)){
                             $prome=new Boletin();
                             $notaPromedio=$prome->promedioAreas($centro,$aAsig[3],$aAsig[1],$anho,$p,$est[0],$aAsig[4]);
                             $sumaNotas=$sumaNotas+$notaPromedio; 
                            //echo "--Suma: ".$sumaNotas."<br>";
                        }
                    }
                    $promedioEst=($sumaNotas/$TotalAreas);
                    $promedios[$est[0]]=$promedioEst;
                }
            }
            arsort($promedios);
            $cont=1;
            while (list($clave, $valor) = each($promedios) and $sw=1) {
                if($clave==$alumnoe){
                    echo $cont; 
                    $sw=0;
                }                
                $cont++;
            }            
        }

        public function finalIntitucion($centro,$sede,$anho,$periodoBol,$curso,$alumnoe){
            //1- recorro la tabla estudiantes para ir almacenando el promedio de cada uno en el array
            error_reporting(0);
            $sql_estudiantes=mysql_query("SELECT mt.idMatricula FROM matriculas mt INNER JOIN sedes sd ON sd.`CODSEDE`= mt.`codsede` INNER JOIN centroeducativo Cen ON cen.`CODINST`=sd.`CODINST` WHERE cen.`CODINST`='$centro' AND mt.estado='Matriculado' AND mt.`anho`='$anho' ORDER BY mt.idMatricula, mt.curso ASC;");
            $promedios=array();
            $sw=1;
            while($est=mysql_fetch_array($sql_estudiantes)){   
                $promedioEst=0;
                $sumaNotas=0;
                
                $sqlAreasEnsede=mysql_query("SELECT * FROM areasxsedes axs WHERE axs.`CODSEDE`='$sede';");
                $TotalAreas=mysql_num_rows($sqlAreasEnsede);
                //Consulto para conocer si el area tiene notas directas 
                $resultnotas=mysql_query("SELECT notas.nota FROM notas WHERE notas.`Anho`='$anho' AND notas.`idMatricula`='$est[0]'"); 
                $tieneNotas=mysql_num_rows($resultnotas);
                if($tieneNotas>0){  
                   while ($ntA=mysql_fetch_array($resultnotas)){
                       $sumaNotas=$sumaNotas+$ntA[0];                       
                   }
                }
                
                $sqlAreasConAignaturas=mysql_query("SELECT * FROM areasxsedes axs WHERE NOT EXISTS (SELECT nota FROM notas WHERE notas.`codArea` = axs.`idAreaSede`  AND notas.`idMatricula`='$est[0]' AND notas.`Anho`='$anho')  AND axs.`CODSEDE`='$sede'");
                $resNotasAs=mysql_num_rows($sqlAreasConAignaturas);
                if($resNotasAs>0){
                    for($p=1;$p<=4;$p++){
                        while($aAsig=mysql_fetch_array($sqlAreasConAignaturas)){
                             $prome=new Boletin();
                             $notaPromedio=$prome->promedioAreas($centro,$aAsig[3],$aAsig[1],$anho,$p,$est[0],$aAsig[4]);
                             $sumaNotas=$sumaNotas+$notaPromedio; 
                            //echo "--Suma: ".$sumaNotas."<br>";
                        }
                    }
                    $promedioEst=($sumaNotas/$TotalAreas);
                    $promedios[$est[0]]=$promedioEst;
                }
            }
            arsort($promedios);
            $cont=1;
            while (list($clave, $valor) = each($promedios) and $sw=1) {
                if($clave==$alumnoe){
                    echo $cont; 
                    $sw=0;
                }                
                $cont++;
            }            
        }
    }
?>