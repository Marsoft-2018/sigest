<?php
    class Calificacion extends ConectarPDO{
        public $id;
        public $Anho;
        public $periodo;
        public $idMatricula;
        public $codArea;
        public $idAsignatura;
        public $curso;
        public $nota;
        public $desempeno;
        public $faltas;
        public $porPeriodo;
        public $tipoPromedio;
        public $grado;
        public $tabla;
        public $idCriterio;
        private $sql;

        public function cargar(){
            //verifico si existe alguna asignatura en el área.            
            $objAr = new Area();
            $objAr->idArea = $this->codArea;
            $objAr->idGrado = $this->grado;
            $numAsignaturas = $objAr->conteoAsignaturas();
            if ($numAsignaturas == 0 ) {                
                //para cargar la nota directa del área
                $this->sql = "SELECT * FROM notas WHERE PERIODO = ? AND idMatricula = ? AND codArea = ? AND anho = ? AND curso = ?";
                try {
                    $stm = $this->Conexion->prepare($this->sql);
                    $stm->bindparam(1,$this->periodo);
                    $stm->bindparam(2,$this->idMatricula);
                    $stm->bindparam(3,$this->codArea);
                    $stm->bindparam(4,$this->Anho);
                    $stm->bindparam(5,$this->curso);
                    $stm->execute();
                    $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                    return $datos;
                } catch (Exception $e) {
                    echo "Error al consultar las notas. ".$e;
                }
            }else{
                //cargar la calificación del área según el tipo de promedio
                switch ($this->tipoPromedio) {
                    case 'Porcentaje':
                        return $this->notaAreaXporcentaje();                        
                        break;
                    case 'IH':
                        return $this->notaAreaXintensidadHoraria();
                        break;
                    case 'Normal':
                        return $this->notaAreaXpromedio();
                        break; 
                }
            }            
        } 

        public function notaAsignatura(){
            $this->sql = "SELECT na.nota AS NOTA, na.faltas AS Faltas FROM notasasignaturas na WHERE idMatricula = ? AND anho = ? AND periodo = ? AND idCurso = ? AND na.`idAsignatura` = ?";                    
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1, $this->idMatricula);
                $stm->bindParam(2, $this->Anho);
                $stm->bindParam(3, $this->periodo);
                $stm->bindParam(4, $this->curso);
                $stm->bindParam(5, $this->idAsignatura);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }
        }

        public function notaAreaXpromedio(){
            $this->sql = "SELECT AVG(na.nota) AS NOTA, SUM(na.faltas) AS Faltas FROM notasasignaturas na INNER JOIN areas_asignaturas aa ON aa.`id` = na.`idAsignatura` INNER JOIN areasxsedes_2 axs ON axs.`id` = aa.`idArea` WHERE idMatricula = ? AND anho = ? AND periodo = ? AND idCurso = ? AND axs.`id` = ?";                    
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1, $this->idMatricula);
                $stm->bindParam(2, $this->Anho);
                $stm->bindParam(3, $this->periodo);
                $stm->bindParam(4, $this->curso);
                $stm->bindParam(5, $this->codArea);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }
        }

        public function notaAreaXporcentaje(){
            $this->sql = "SELECT SUM((na.nota * aa.`porcentaje`) / 100) AS NOTA,SUM(na.faltas) AS Faltas FROM notasasignaturas na INNER JOIN areas_asignaturas aa ON aa.`id` = na.`idAsignatura` INNER JOIN areasxsedes_2 axs ON axs.`id` = aa.`idArea` WHERE idMatricula = ? AND anho = ? AND periodo = ? AND idCurso = ? AND axs.`id` = ?";                    
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1, $this->idMatricula);
                $stm->bindParam(2, $this->Anho);
                $stm->bindParam(3, $this->periodo);
                $stm->bindParam(4, $this->curso);
                $stm->bindParam(5, $this->codArea);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }
        }

        public function notaAreaXintensidadHoraria(){              
            $arreglo["Datos"][] = 0;
            $suma = 0;
            $faltas = 0;              

            $this->sql = "SELECT axs.id AS idArea,ai.intensidad,ai.`idGrado`,asg.`id` AS idAsignatuta FROM areasxsedes_2 axs
            INNER JOIN areas_anho axa ON axa.`idArea` = axs.`id`
            INNER JOIN areas_intensidad ai ON ai.`idArea` = axs.`id`
            INNER JOIN cursos cr ON cr.`CODGRADO` = ai.`idGrado`
            INNER JOIN areas_asignaturas asg ON asg.`idArea` = axs.`id` 
            WHERE axs.id = ? AND axa.anho = ? AND cr.`codCurso`= ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1,$this->codArea);
                $stm->bindParam(2, $this->Anho);
                $stm->bindParam(3, $this->curso);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datos as $area) {
                    //echo "Ih area: ".$area['intensidad'];
                    $sql2 = "SELECT * FROM asignaturas_intensidad WHERE idAsignatura = ? AND idGrado = ?";
                    try {
                        $stm2 = $this->Conexion->prepare($sql2);
                        $stm2->bindParam(1,$area['idAsignatuta']);
                        $stm2->bindParam(2,$area['idGrado']);
                        $stm2->execute();
                        $datos_2 = $stm2->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($datos_2 as $asignaturaIntensidad) {
                            $sql3 = "SELECT nota, faltas FROM notasasignaturas WHERE idAsignatura = ? AND periodo = ? AND idMatricula = ? AND anho = ?";
                            $stm3 = $this->Conexion->prepare($sql3);
                            $stm3->bindParam(1,$asignaturaIntensidad['idAsignatura']);
                            $stm3->bindParam(2, $this->periodo);
                            $stm3->bindParam(3, $this->idMatricula);
                            $stm3->bindParam(4, $this->Anho);
                            $stm3->execute();
                            $datos_3 = $stm3->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($datos_3 as $asignaturaNota) {
                                if($asignaturaIntensidad['idAsignatura'] != 0){
                                    $suma +=  $asignaturaNota['nota'] * (($asignaturaIntensidad['intensidad']*100)/$area['intensidad'])/100;                                
                                    $faltas += $asignaturaNota['faltas'];
                                } 
                                //echo "Suma: ".$suma;
                            }
                        }
                    } catch (PDOException $e) {
                        echo "Error: ".$e;
                    }
                }
                
                $arreglo["Datos"]['NOTA'] = (round($suma,1));
                $arreglo["Datos"]['Faltas'] = $faltas;
                return $arreglo;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }
        }

        public function notaMinima(){
            $this->sql = "SELECT limiteInf FROM desempenos WHERE CODINST = 1 AND CONCEPT = 'BASICO'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
               foreach ($datos as $concep) {
                   $this->nota = $concep['limiteInf'];
               }
               return $this->nota;
            } catch (Exception $e) {
                echo "Ocurrió un error al tratar de obtener los desempeños. ".$e;
            }  
        }

        public function notaMaxima(){
            $this->sql = "SELECT limiteSup FROM desempenos WHERE CODINST = 1 AND CONCEPT = 'SUPERIOR'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                //$stm->bindparam(1,$_SESSION['institucion']);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
               foreach ($datos as $concep) {
                   $this->nota = $concep['limiteSup'];
               }
               return $this->nota;
            } catch (Exception $e) {
                echo "Ocurrió un error al tratar de obtener los desempeños. ".$e;
            }  
        }

        public function notaBaja(){
            $this->sql = "SELECT limiteInf FROM desempenos WHERE CODINST = 1 AND CONCEPT = 'BAJO'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
               foreach ($datos as $concep) {
                   $this->nota = $concep['limiteInf'];
               }
               return $this->nota;
            } catch (Exception $e) {
                echo "Ocurrió un error al tratar de obtener los desempeños. ".$e;
            }  
        }

        public function acumulado(){
            
            $acum = $this->nota * ($this->porPeriodo / 100);
            return $acum;
            /*
            $this->sql = "SELECT notas.`idMatricula`,estudiantes.`PrimerNombre`, estudiantes.`SegundoNombre`,estudiantes.`PrimerApellido`,estudiantes.`SegundoApellido`, axs.`Nombre`, ROUND(SUM(notas.`NOTA` * (aj.`valorPeriodo`/100)),2) AS acumulado, IF(SUM(notas.`NOTA` * (aj.`valorPeriodo`/100)) < 3.5 ,'BAJO','') AS desempeno FROM notas INNER JOIN ajustes aj ON aj.`periodo` = notas.`PERIODO` INNER JOIN areasxsedes_2 axs ON axs.`id` = notas.`codArea` INNER JOIN matriculas mt ON mt.`idMatricula` = notas.idMatricula INNER JOIN estudiantes ON estudiantes.`Documento` = mt.Documento WHERE notas.`idMatricula` = ? AND axs.id = ? GROUP BY axs.`Nombre`  ORDER BY axs.`Nombre`,notas.`PERIODO` ASC";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->idMatricula);
                $stm->bindparam(2,$this->codArea);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }
            */
        }

        public function agregar(){
            $this->sql = "INSERT INTO notas (Anho, PERIODO, idMatricula, codArea, curso, NOTA, DESEMPENO, Faltas) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->Anho);
                $stm->bindparam(2,$this->periodo);
                $stm->bindparam(3,$this->idMatricula);
                $stm->bindparam(4,$this->codArea);
                $stm->bindparam(5,$this->curso);
                $stm->bindparam(6,$this->nota);
                $stm->bindparam(7,$this->desempeno);
                $stm->bindparam(8,$this->faltas);
                $stm->execute();
                echo "La calificacion se agregó con éxito";
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }  
        }

        public function agregarNotaAsignatura(){            
            $this->sql = "INSERT INTO notasasignaturas (anho, periodo, idMatricula, idAsignatura, idCurso, nota, desempeno, faltas) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->Anho);
                $stm->bindparam(2,$this->periodo);
                $stm->bindparam(3,$this->idMatricula);
                $stm->bindparam(4,$this->idAsignatura);
                $stm->bindparam(5,$this->curso);
                $stm->bindparam(6,$this->nota);
                $stm->bindparam(7,$this->desempeno);
                $stm->bindparam(8,$this->faltas);
                $stm->execute();
                echo "La calificacion se agregó con éxito";
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }  
        }

        public function modificar(){
            $this->sql = "UPDATE notas SET nota= ? WHERE Anho = '".$this->Anho."'  AND PERIODO = '".$this->periodo."' AND idMatricula = '".$this->idMatricula."' AND codArea = '".$this->codArea."' AND curso = '".$this->curso."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->nota);
                $stm->execute();
                echo "La calificacion se modificó con éxito";
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }  
        }

        public function modificarNotaAsignatura(){
            $this->sql = "UPDATE notasasignaturas SET nota= ? WHERE anho = '".$this->Anho."'  AND periodo = '".$this->periodo."' AND idMatricula = '".$this->idMatricula."' AND idAsignatura = '".$this->idAsignatura."' AND idCurso = '".$this->curso."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->nota);
                $stm->execute();
                echo "La calificacion se modificó con éxito";
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }  
        }

        public function modificarInasistencias(){
            $this->sql = "UPDATE notas SET Faltas= ? WHERE Anho = '".$this->Anho."'  AND PERIODO = '".$this->periodo."' AND idMatricula = '".$this->idMatricula."' AND codArea = '".$this->codArea."' AND curso = '".$this->curso."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->faltas);
                $stm->execute();
                echo "La calificacion se modificó con éxito";
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }  
        }

        public function eliminar(){
            $this->sql = "DELETE FROM notas WHERE Anho = '".$this->Anho."'  AND PERIODO = '".$this->periodo."' AND idMatricula = '".$this->idMatricula."' AND codArea = '".$this->codArea."' AND curso = '".$this->curso."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                echo "La calificacion se eliminó con éxito";
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }  
        }

        public function promedioEstudiante(){
            $this->sql = "SELECT SUM(NOTA) as promedio FROM notas WHERE PERIODO = ? AND idMatricula = ? AND anho = ? AND curso = ?";
                try {
                    $stm = $this->Conexion->prepare($this->sql);
                    $stm->bindparam(1,$this->periodo);
                    $stm->bindparam(2,$this->idMatricula);
                    $stm->bindparam(3,$this->Anho);
                    $stm->bindparam(4,$this->curso);
                    $stm->execute();
                    $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($datos as $pro) {
                        $datos = $pro['promedio'];
                    }
                    return $datos;
                } catch (Exception $e) {
                    echo "Error al consultar las notas. ".$e;
                }
            
            /*if($tipo != "Definitivo"){
                $this->sql = "SELECT SUM(NOTA) as promedio FROM notas WHERE PERIODO = '".$this->periodo."' AND idMatricula = '".$this->idMatricula."' AND anho = '".$this->Anho."' AND curso = '".$this->curso."'";
                try {
                    $stm = $this->Conexion->prepare($this->sql);
                    $stm->execute();
                    $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($datos as $pro) {
                        $datos = $pro['promedio'];
                    }
                    return $datos;
                } catch (Exception $e) {
                    echo "Error al consultar las notas. ".$e;
                }
            }else{
                return 4;
            }*/
        }

        public function promedioAreaXcurso(){
            $this->sql = "SELECT SUM(NOTA) as promedio FROM notas WHERE PERIODO = '".$this->periodo."' AND codArea = '".$this->codArea."' AND anho = '".$this->Anho."' AND curso = '".$this->curso."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datos as $pro) {
                    $datos = $pro['promedio'];
                }
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }
        }

        public function promedioXcurso(){
            $this->sql = "SELECT SUM(NOTA) as promedio FROM notas WHERE PERIODO = '".$this->periodo."' AND anho = '".$this->Anho."' AND curso = '".$this->curso."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datos as $pro) {
                    $datos = $pro['promedio'];
                }
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }
        } 

        public function cargarPorCriterio(){   
            $nota = "";
            //para cargar la nota directa del área
            $this->sql = "SELECT id,nota FROM notas_varias WHERE periodo =? AND idMatricula =? AND id_AreaAsignatura = ? AND anho = ? AND idCurso = ? AND idCriterio = ? AND tipo = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->periodo);
                $stm->bindparam(2,$this->idMatricula);
                $stm->bindparam(3,$this->codArea);
                $stm->bindparam(4,$this->Anho);
                $stm->bindparam(5,$this->curso);
                $stm->bindparam(6,$this->idCriterio);
                $stm->bindparam(7,$this->tabla);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datos as $value) {
                    $nota = $value['nota'];
                } 
                return $nota;
            } catch (Exception $e) {
                echo "Error al consultar la nota. ".$e;
            }                  
        } 

        public function agregarNotaCriterio(){
            $this->sql = "INSERT INTO notas_varias (anho, periodo, idMatricula, id_AreaAsignatura, idCurso, nota, idCriterio, tipo, idUsuario) VALUES(?,?,?,?,?,?,?,?,?)";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->Anho);
                $stm->bindparam(2,$this->periodo);
                $stm->bindparam(3,$this->idMatricula);
                $stm->bindparam(4,$this->codArea);
                $stm->bindparam(5,$this->curso);
                $stm->bindparam(6,$this->nota);
                $stm->bindparam(7,$this->idCriterio);
                $stm->bindparam(8,$this->tabla);
                $stm->bindparam(9,$_SESSION['idUsuario']);
                $stm->execute();
                echo "La calificacion se agregó con éxito";
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }  
        }

        public function modificarNotaCriterio(){
            $this->sql = "UPDATE notas_varias SET nota= ? WHERE anho = ? AND periodo = ? AND idMatricula = ? AND id_AreaAsignatura = ? AND idCurso = ? AND idCriterio = ? AND tipo = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->nota);
                $stm->bindparam(2,$this->Anho);
                $stm->bindparam(3,$this->periodo);
                $stm->bindparam(4,$this->idMatricula);
                $stm->bindparam(5,$this->codArea);
                $stm->bindparam(6,$this->curso);
                $stm->bindparam(7,$this->idCriterio);
                $stm->bindparam(8,$this->tabla);
                $stm->execute();
                echo "La calificacion se modificó con éxito";
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }  
        }

        public function definitivaCriterios(){
            $this->sql = "SELECT SUM(nt.nota*(cr.porcentaje/100) )AS nota FROM criterios cr INNER JOIN notas_varias nt ON cr.codCriterio = nt.idCriterio WHERE periodo =? AND idMatricula =? AND id_AreaAsignatura = ? AND anho = ? AND idCurso = ? AND tipo = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->periodo);
                $stm->bindparam(2,$this->idMatricula);
                $stm->bindparam(3,$this->codArea);
                $stm->bindparam(4,$this->Anho);
                $stm->bindparam(5,$this->curso);
                $stm->bindparam(6,$this->tabla);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datos as $value) {
                    $nota = $value['nota'];
                } 
                return round($nota,1);
            } catch (Exception $e) {
                echo "Error al consultar la nota. ".$e;
            }
        }

        public function listarNotasPorCriterio(){
            $this->sql = "SELECT id,nota, idCriterio FROM notas_varias WHERE periodo =? AND idMatricula =? AND id_AreaAsignatura = ? AND anho = ? AND idCurso = ? AND tipo = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->periodo);
                $stm->bindparam(2,$this->idMatricula);
                $stm->bindparam(3,$this->codArea);
                $stm->bindparam(4,$this->Anho);
                $stm->bindparam(5,$this->curso);
                $stm->bindparam(6,$this->tabla);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar la nota. ".$e;
            } 
        }

        public function notasEstudiante(){
            $this->sql = "SELECT nt.`idMatricula` AS Estudiante, ar.`Nombre` AS `Area`,nt.`NOTA` FROM notas nt INNER JOIN areasxsedes_2 ar ON ar.`id` = nt.`codArea` WHERE  nt.`idMatricula`= '".$this->idMatricula."' AND nt.PERIODO = '".$this->periodo."' AND nt.`Anho` = '".$this->Anho."' AND nt.curso = '".$this->curso."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }
        } 

        public function notasCurso(){
            $this->sql = "SELECT nt.`NOTA` FROM notas nt INNER JOIN areasxsedes_2 ar ON ar.`id` = nt.`codArea` WHERE  nt.PERIODO = '".$this->periodo."' AND nt.`Anho` = '".$this->Anho."' AND nt.curso = '".$this->curso."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }
        } 

        public function listaPromedios(){            
            $this->sql = "SELECT SUM(NOTA) AS promedio FROM notas WHERE PERIODO = '".$this->periodo."' AND anho = '".$this->Anho."' AND curso = '".$this->curso."' GROUP BY idMatricula ORDER BY promedio DESC";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }
        }

        public function estadoAnho($areasPerdidasEstudiante, $areasPerder){    
            $estado = "";
            //echo "Aperdidas: ".$areasPerdidasEstudiante." Para perder: ". $areasPerder."<br>";
            if($areasPerdidasEstudiante >= $areasPerder){
                $estado = "Reprobado";
            }elseif($areasPerdidasEstudiante < $areasPerder and $areasPerdidasEstudiante > 0){
                $estado = "Aplazado";                    
            }elseif($areasPerdidasEstudiante == 0){
                $estado = "Aprobado";                    
            }
            return $estado;
        }
        
        public function recuperacion(){
            //cONSULTA PARA DETALLADA
            $this->sql = "SELECT nv.`numActa`,nv.`mesActa`,nv.`diaActa`,nv.`Anho`, axs.`Nombre`, nv.`NOTA`,nv.observacion FROM notas_nivelacion nv INNER JOIN areasxsedes_2 axs ON axs.`id` = nv.`codArea` INNER JOIN matriculas mt ON mt.`idMatricula` = nv.`idMatricula` WHERE mt.`idMatricula` = ?";
            // $this->sql = "select observacion from notas_nivelacion WHERE `idMatricula` = ?";                    
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindParam(1, $this->idMatricula);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar recuperacion. ".$e;
            }
        }
        
        public function formato_notas($nota){
            $entero = (int) $nota;
            $decimal  = $nota - (int) $nota;
            if($decimal > 0){
                $notaF = $nota;
            }else{
                $notaF = $entero.".".$decimal;
            }
            return $notaF;
        }
        
        public function eliminarNotaEspecifica(){
            $this->sql = "DELETE FROM notas_varias WHERE id = '".$this->id."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                echo "La calificacion se eliminó con éxito";
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }  
        }

    }//OK
