<?php 
	class cargaAcademica extends ConectarPDO{
        public $id;
        public $codProfesor;
        public $codCurso;
        public $codArea;
        public $codAsignatura;
        public $codigoA;
        public $codsede;
        public $anho;
        public $estado;
        private $sql;
        public function cargar(){
            $this->sql = "SELECT * FROM cargaacademica_new WHERE codProfesor = '".$this->codProfesor."' AND codCurso = '".$this->codCurso."' AND codArea = '".$this->codArea."' AND anho = '".$this->anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
                return $reg; 
                $this->cerrarConexion();             
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }            
        } 
        
        public function verCarga(){
            $this->sql = "SELECT axs.`Abreviatura`,axs.`Nombre`, cr.`CODGRADO`,cr.`grupo`, cr.codCurso, gr.NOMGRADO, gr.nomCampo FROM cargaacademica_new ca INNER JOIN areasxsedes_2 axs ON axs.`id` = ca.`codArea` INNER JOIN cursos cr ON cr.`codCurso` = ca.`codCurso` INNER JOIN grados gr ON gr.CODGRADO = cr.CODGRADO WHERE ca.codProfesor = ? AND ca.anho = ? ORDER BY axs.`Nombre`, cr.`CODGRADO` ASC";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codProfesor);
                $stm->bindparam(2,$this->anho);
                $stm->execute();
                $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
                return $reg; 
                $this->cerrarConexion();             
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }            
        } 

        public function cargarCelda(){
            $this->sql = "SELECT pf.`IDUsuario`, pf.`color`,CONCAT(pf.PrimerNombre,' ',pf.PrimerApellido,' ',pf.SegundoApellido) AS nombre FROM cargaacademica_new ca INNER JOIN profesores pf ON pf.`IDUsuario` = ca.`codProfesor` WHERE (codArea = '".$this->codigoA."' OR codAsignatura = '".$this->codigoA."') AND codCurso = '".$this->codCurso."' AND anho = '".$this->anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
                return $reg; 
                $this->cerrarConexion();             
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }  
        }

        public function verificarOtraAsignacion(){
            $this->sql = "SELECT * FROM cargaacademica_new WHERE (codArea = '".$this->codigoA."' OR codAsignatura = '".$this->codigoA."') AND codCurso = '".$this->codCurso."' AND anho = '".$this->anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $reg = $stm->fetchAll(PDO::FETCH_ASSOC);  
                return $reg;                  
                $this->cerrarConexion();               
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }            
        } 

        public function anhadircolor($profesor){
            $rojo = rand(0,255);
            $verde = rand(0,255);
            $azul = rand(0,255);
            $color = $rojo.",".$verde.",".$azul;
            $this->sql = "UPDATE profesores SET color='rgb(".$color.")' WHERE IDUsuario='".$profesor."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $this->cerrarConexion(); 
            } catch (Exception $e) {
                echo "Error al listar los profesores. ".$e;
            }
        }

        public function guardar(){
            $this->sql = "INSERT INTO cargaacademica_new(codProfesor, codCurso, codArea, codAsignatura, anho) VALUES(?, ?, ?, ?, ?)";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codProfesor);
                $stm->bindparam(2,$this->codCurso);
                $stm->bindparam(3,$this->codArea);
                $stm->bindparam(4,$this->codAsignatura);
                $stm->bindparam(5,$this->anho);
                $stm->execute();
                echo "Información agregada con éxito";
            } catch (Exception $e) {
                echo "Ocurrio un error: ".$e;
            }
        }

        public function eliminar(){
            $mensaje = "El área se quitó con éxito";
        	$this->sql = "DELETE FROM cargaacademica_new WHERE codArea = '".$this->codArea."' AND codProfesor = ? AND codCurso = ? AND  anho = ? ";
            if ($this->codArea == 0) {
                $this->sql = "DELETE FROM cargaacademica_new WHERE codAsignatura = '".$this->codAsignatura."' AND  codProfesor = ? AND codCurso = ? AND anho = ? ";
                $mensaje = "La asignatura se quitó con éxito";
            }

            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codProfesor);
                $stm->bindparam(2,$this->codCurso);
                $stm->bindparam(3,$this->anho);
                $stm->execute();
                echo $mensaje;
            } catch (Exception $e) {
                echo "Ocurrio un error: ".$e;
            }
        }

        public function cursosAsignados(){            
            $this->sql = "SELECT  DISTINCT(codCurso) AS id FROM cargaacademica_new WHERE codProfesor = '".$this->codProfesor."' AND anho = '".$this->anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $reg = $stm->fetchAll(PDO::FETCH_ASSOC); 
                return $reg;    
               $this->Conexion->cerrarConexion();           
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }
        }

        public function conteoCursos(){
            
            $this->sql = "SELECT COUNT(DISTINCT(codCurso)) AS total FROM cargaacademica_new WHERE codProfesor = '".$this->codProfesor."' AND anho = '".$this->anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $reg = $stm->fetchAll(PDO::FETCH_ASSOC); 
                foreach ($reg as $value) {
                     $reg = $value['total'];
                 } 
                return $reg;    
               $this->Conexion->cerrarConexion();           
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }
        }

        public function totalNotas($curso,$area,$anho,$periodo){           
            $this->sql = "SELECT COUNT(nts.idMatricula) as total FROM notas nts INNER JOIN matriculas mt ON mt.`idMatricula` = nts.idMatricula WHERE  nts.`curso` = '".$curso."' AND nts.`anho` = '$anho' AND nts.periodo = '$periodo' AND nts.codArea = '".$area."' AND mt.`estado` = 'Matriculado'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $reg = $stm->fetchAll(PDO::FETCH_ASSOC); 
                foreach ($reg as $value) {
                     $reg = $value['total'];
                 } 
                return $reg;    
               $this->Conexion->cerrarConexion();           
            } catch (Exception $e) {
                echo "Error al consultar los datos. <br>".$e;
            }
        }
    }

?>