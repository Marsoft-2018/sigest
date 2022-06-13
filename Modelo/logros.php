<?php 
    class Logro extends ConectarPDO{
        public $codArea;
        public $CODIND;
        public $INDICADOR;
        public $codCriterio;
        public $periodo;
        public $codCurso;
        public $estado;
        public $desempeno;
        public $calificacion;
        public $prefijoLogro;
        public $sufijoLogro;
        public $tabla;
        private $sql;

        public function agregar(){ 
            $this->tabla= "Area";
            /*echo "Las Valores en las Variables son: Año: $anho, Periodo: $periodo, Area: $area, Curso: $curso, Indicador: $indicador, Código del críterio: $codCriterio, Tabla: $this->tabla ";*/
            if($this->tabla == 'Area'){
                $this->sql = "INSERT INTO logros(codArea, INDICADOR, codCriterio, periodo, codCurso) VALUES(?,?,?,?,?)"; 
                
            }elseif($this->tabla == 'Asignatura'){
                $this->sql = "INSERT INTO logrosasignatura(codAsignatura, INDICADOR, codCriterio, periodo, codCurso) VALUES(?,?,?,?,?)"; 
            }             
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codArea);
                $stm->bindparam(2,$this->INDICADOR);
                $stm->bindparam(3,$this->codCriterio);
                $stm->bindparam(4,$this->periodo);
                $stm->bindparam(5,$this->codCurso);                
                $stm->execute();
                echo "Se agregó el indicador con éxito";
            } catch (Exception $e) {
                http_response_code(500);
            }           
        }//OK

        public function cargarIndicador(){
            $this->tabla= "Area";
            if($this->tabla == 'Area'){
                $this->sql = "SELECT CODIND, INDICADOR, codCriterio FROM logros WHERE CODIND = ? "; 
            }elseif($this->tabla == 'Asignatura'){
                $this->sql = "SELECT CODIND, INDICADOR, codCriterio FROM logrosasignatura WHERE CODIND = ? "; 
            }  
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->CODIND);                
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }           
        }

        public function cargar(){
            $this->estado = 1;
            $sql1 = "SELECT limiteInf, limiteSup, CONCEPT FROM desempenos WHERE CODINST = ? ORDER BY limiteInf DESC";
            try {
                $stm2 = $this->Conexion->prepare($sql1);
                $stm2->bindparam(1,$_SESSION['institucion']);                
                $stm2->execute();
                $datos = $stm2->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datos as $limit) {
                   if ($this->calificacion >= $limit['limiteInf'] and $this->calificacion <= $limit['limiteSup'] ) {
                       $this->desempeno = $limit['CONCEPT'];
                       if($this->desempeno == 'BAJO'){
                            $this->prefijoLogro = 'Tengo dificultad para ';
                            $this->sufijoLogro  = '';
                        }elseif($this->desempeno == 'BASICO'){
                            $this->prefijoLogro = 'Soy capaz de ';
                            $this->sufijoLogro = '';
                        }elseif($this->desempeno == 'ALTO'){
                            $this->prefijoLogro = 'Tengo muy buenas habilidades para ';
                            $this->sufijoLogro = '.';
                        }elseif($this->desempeno == 'SUPERIOR'){
                            $this->prefijoLogro = 'Demuestro habilidades superiores para ';
                            $this->sufijoLogro  = '.';
                        }
                   }
                }
            } catch (Exception $e) {
                echo "Error al consultar los logros. ".$e;
            }   

            if(!empty($this->desempeno)){   
                foreach ($this->cargarLista() as $indicador) {
                    echo $this->prefijoLogro.$indicador['INDICADOR'].$this->sufijoLogro.". <br>";
                } 
            }else{
                echo "<br><br>";
            }
        }//OK

        public function cargarLista(){
            $this->tabla= "Area";
            if($this->tabla == 'Area'){
                $this->sql = "SELECT L.`CODIND`,ax.`abreviatura`,criterios.`nomCriterio`,L.`periodo`,L.INDICADOR,L.estado FROM logros L
                INNER JOIN areasxsedes_2 ax ON L.`codArea`=ax.`id` INNER JOIN criterios  ON L.`codCriterio`=criterios.`codCriterio` WHERE L.`periodo`= ? AND ax.`id`= ? AND L.codCurso= ?"; 
            }elseif($this->tabla == 'Asignatura'){
                $this->sql = "SELECT L.`id`,ax.`abreviatura`,criterios.`nomCriterio`,L.`periodo`,L.INDICADOR,L.estado FROM logrosasignatura L INNER JOIN areas_asignaturas ax ON L.`idAsignatura` = ax.`id` INNER JOIN criterios  ON L.`idCriterio`=criterios.`codCriterio` WHERE L.`periodo`= ? AND ax.`id`= ? AND L.idCurso = ?";
            }
            if(!empty($this->estado)){
                $this->sql .= " AND estado = '".$this->estado."' ";
            }
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->periodo);
                $stm->bindparam(2,$this->codArea);
                $stm->bindparam(3,$this->codCurso);                
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar los logros. ".$e;
            }           
        }

        public function cargarLogrosCriterios(){
            $this->estado = 1;
            $sql1 = "SELECT limiteInf, limiteSup, CONCEPT FROM desempenos WHERE CODINST = ? ORDER BY limiteInf DESC";
            try {
                $stm2 = $this->Conexion->prepare($sql1);
                $stm2->bindparam(1,$_SESSION['institucion']);                
                $stm2->execute();
                $datos = $stm2->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datos as $limit) {
                   if ($this->calificacion >= $limit['limiteInf'] and $this->calificacion <= $limit['limiteSup'] ) {
                       $this->desempeno = $limit['CONCEPT'];
                       if($this->desempeno == 'BAJO'){
                            $this->prefijoLogro = 'Tengo dificultad para ';
                            $this->sufijoLogro  = '';
                        }elseif($this->desempeno == 'BASICO'){
                            $this->prefijoLogro = 'Soy capaz de ';
                            $this->sufijoLogro = '';
                        }elseif($this->desempeno == 'ALTO'){
                            $this->prefijoLogro = 'Tengo muy buenas habilidades para ';
                            $this->sufijoLogro = '. También demuestro intensiones de aprender más.';
                        }elseif($this->desempeno == 'SUPERIOR'){
                            $this->prefijoLogro = 'Demuestro habilidades superiores para ';
                            $this->sufijoLogro  = '. También demuestro intensiones de aprender más.';
                        }
                   }
                }
            } catch (Exception $e) {
                echo "Error al consultar los logros. ".$e;
            }   

            if(!empty($this->desempeno)){ 
                $sqlLogro = "";
                if($this->tabla == 'Area'){
                    $sqlLogro = "SELECT L.`CODIND`,ax.`abreviatura`,criterios.`nomCriterio`,L.`periodo`,L.INDICADOR,L.estado FROM logros L
                    INNER JOIN areasxsedes_2 ax ON L.`codArea`=ax.`id` INNER JOIN criterios  ON L.`codCriterio`=criterios.`codCriterio` WHERE L.`periodo`= ? AND ax.`id`= ? AND L.codCurso= ? AND L.`codCriterio` = ? And L.estado = 1"; 
                }elseif($this->tabla == 'Asignatura'){
                    $sqlLogro = "SELECT L.`id`,ax.`abreviatura`,criterios.`nomCriterio`,L.`periodo`,L.INDICADOR,L.estado FROM logrosasignatura L INNER JOIN areas_asignaturas ax ON L.`idAsignatura` = ax.`id` INNER JOIN criterios  ON L.`idCriterio`=criterios.`codCriterio` WHERE L.`periodo`= ? AND ax.`id`= ? AND L.idCurso = ? AND L.`codCriterio` =? And L.estado = 1";
                }
                try {
                    $stmL = $this->Conexion->prepare($sqlLogro);
                    $stmL->bindparam(1,$this->periodo);
                    $stmL->bindparam(2,$this->codArea);
                    $stmL->bindparam(3,$this->codCurso);   
                    $stmL->bindparam(4,$this->codCriterio);              
                    $stmL->execute();
                    $datosLogro = $stmL->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($datosLogro as $indicador) {
                        echo $this->prefijoLogro.$indicador['INDICADOR'].$this->sufijoLogro.". <br>";
                    } 
                } catch (Exception $e) {
                    echo "Error al consultar los logros. ".$e;
                } 
                
            }else{
                echo "<br><br>";
            }
        }//OK

        public function listarLogrosCriterios(){
            $this->tabla= "Area";
            
            $sqlLogro = "";
            if($this->tabla == 'Area'){
                $sqlLogro = "SELECT L.`CODIND`,ax.`abreviatura`,criterios.`nomCriterio`,L.`periodo`,L.INDICADOR,L.estado FROM logros L
                INNER JOIN areasxsedes_2 ax ON L.`codArea`=ax.`id` INNER JOIN criterios  ON L.`codCriterio`=criterios.`codCriterio` WHERE L.`periodo`= ? AND ax.`id`= ? AND L.codCurso= ? AND L.`codCriterio` = ? And L.estado = 1"; 
            }elseif($this->tabla == 'Asignatura'){
                $sqlLogro = "SELECT L.`id`,ax.`abreviatura`,criterios.`nomCriterio`,L.`periodo`,L.INDICADOR,L.estado FROM logrosasignatura L INNER JOIN areas_asignaturas ax ON L.`idAsignatura` = ax.`id` INNER JOIN criterios  ON L.`idCriterio`=criterios.`codCriterio` WHERE L.`periodo`= ? AND ax.`id`= ? AND L.idCurso = ? AND L.`codCriterio` =? And L.estado = 1";
            }
            try {
                $stmL = $this->Conexion->prepare($sqlLogro);
                $stmL->bindparam(1,$this->periodo);
                $stmL->bindparam(2,$this->codArea);
                $stmL->bindparam(3,$this->codCurso);   
                $stmL->bindparam(4,$this->codCriterio);              
                $stmL->execute();
                $datosLogro = $stmL->fetchAll(PDO::FETCH_ASSOC);
                return  $datosLogro;
            } catch (Exception $e) {
                echo "Error al consultar los logros. ".$e;
            } 
        }//OK
        public function modificar(){
            $this->tabla = "Areas";
            if($this->tabla=='Areas'){
                $this->sql = "UPDATE logros SET INDICADOR = ?, codCriterio = ? WHERE CODIND='".$this->CODIND."'"; 
            }elseif($this->tabla=='Asignaturas'){
                $this->sql = "UPDATE logrosasignatura SET INDICADOR = ?, codCriterio = ? WHERE id='$this->CODIND'";
            }  
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1, $this->INDICADOR);                
                $stm->bindparam(2, $this->codCriterio); 
                $stm->execute();
                echo "Datos guardados con éxito";
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }               
        }//OK

        public function cambiarEstado(){
            $this->tabla = "Areas";
            
            if($this->tabla=='Areas'){
                $this->sql = "UPDATE logros SET estado = '".$this->estado."' WHERE CODIND = ?";
            }elseif($this->tabla=='Asignaturas'){
                $this->sql = "UPDATE logrosasignatura SET estado = '".$this->estado."' WHERE id = ?";
            }

            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->CODIND);
                $stm->execute();
            } catch (Exception $e) {
                http_response_code(500);
            }
            
        }

        public function eliminar(){
            $this->tabla = "Areas";            
            if($this->tabla=='Areas'){
                $this->sql = "DELETE FROM logros WHERE CODIND = ?";
            }elseif($this->tabla == 'Asignatura'){
                $this->sql = "DELETE FROM logrosasignatura WHERE id = ?";
            }
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->CODIND);
                $stm->execute();
                echo "El registro del Indicador fue eliminado con éxito";
            } catch (Exception $e) {
                http_response_code(500);
            }
        }

        public function reporte(){ 
            $rol = $_SESSION['rol'];
            switch ($rol) {
                case 'Profesor':
                    $this->sql = "SELECT  CONCAT(c.`CODGRADO`,'°',c.`grupo`) AS curso,ar.`Nombre` AS area,l.`periodo`,cr.`nomCriterio`,l.`CODIND`,l.`INDICADOR` FROM logros l INNER JOIN areasxsedes_2 ar ON ar.`id` = l.`codArea` INNER JOIN cargaacademica_new ca ON ca.`codArea` = l.`codArea` AND ca.`codCurso` = l.`codCurso` INNER JOIN cursos c ON c.`codCurso` = l.`codCurso` INNER JOIN criterios cr ON cr.`codCriterio` = l.`codCriterio`  WHERE l.`estado` = 1 AND ca.`codProfesor` = '".$_SESSION['usuario']."' ORDER BY c.CODGRADO ASC, ar.`Nombre` ASC, l.`periodo` ASC";
                    break;
                case 'Administrador':
                    $this->sql = "SELECT  CONCAT(c.`CODGRADO`,'°',c.`grupo`) AS curso,CONCAT(pf.`PrimerNombre`,' ',pf.`SegundoNombre`,' ',pf.`PrimerApellido`,' ',pf.`SegundoApellido`) AS profesor, ar.`Abreviatura` AS area,l.`periodo`,cr.`nomCriterio`,l.`CODIND`,l.`INDICADOR` FROM logros l  INNER JOIN cargaacademica_new ca ON ca.`codArea` = l.`codArea` AND ca.`codCurso` = l.`codCurso` INNER JOIN areasxsedes_2 ar ON ar.`id` = ca.`codArea` INNER JOIN cursos c ON c.`codCurso` = ca.`codCurso`INNER JOIN profesores pf ON pf.`Documento` = ca.`codProfesor` INNER JOIN criterios cr ON cr.`codCriterio` = l.`codCriterio` GROUP BY l.`CODIND` ORDER BY c.CODGRADO ASC, pf.`PrimerNombre` ASC, pf.`PrimerApellido`,pf.`SegundoApellido`, ar.`Nombre`, l.`periodo` ASC";
                    break;
            }

            
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                http_response_code(500);
            }
        }       
    }//OK
?>