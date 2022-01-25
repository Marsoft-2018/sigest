<?php
    class Nivelacion extends ConectarPDO{
        public $Anho;
        public $idMatricula;
        public $codArea;
        public $curso;
        public $NOTA;
        public $DESEMPENO;
        public $numActa;
        public $mesActa;
        public $diaActa;
        public $observacion;
        private $sql;

        public function cargar(){
            $this->sql = "SELECT * FROM notas_nivelacion WHERE idMatricula = '".$this->idMatricula."' AND codArea = '".$this->codArea."' AND Anho = '".$this->Anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }     
        }
        
        public function listar(){
            $this->sql = "SELECT nv.idMatricula, est.PrimerNombre, est.SegundoNombre, est.PrimerApellido, est.SegundoApellido, axs.Nombre, nv.NOTA, nv.numActa,nv.diaActa, nv.mesActa,nv.Anho, nv.observacion FROM notas_nivelacion nv INNER JOIN matriculas mt ON mt.idMatricula = nv.idMatricula INNER JOIN estudiantes est ON est.Documento = mt.Documento INNER JOIN areasxsedes_2 axs ON axs.id = nv.codArea WHERE nv.Anho = '".$this->Anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            } 
        }

        public function agregar(){
            $this->sql = "INSERT INTO notas_nivelacion (Anho,idMatricula,codArea,numActa,mesActa,diaActa,NOTA,observacion) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->Anho);
                $stm->bindparam(2,$this->idMatricula);
                $stm->bindparam(3,$this->codArea);
                $stm->bindparam(4,$this->numActa);
                $stm->bindparam(5,$this->mesActa);
                $stm->bindparam(6,$this->diaActa);
                $stm->bindparam(7,$this->NOTA);
                $stm->bindparam(8,$this->observacion);
                $stm->execute();
                echo "La calificacion se agregó con éxito";
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }  
        }
        
        public function listaEstudiantes(){
            $this->sql = "SELECT notas.`idMatricula`,estudiantes.`PrimerNombre`, estudiantes.`SegundoNombre`,estudiantes.`PrimerApellido`,estudiantes.`SegundoApellido`, axs.`Nombre`, ROUND(SUM(notas.`NOTA` * (aj.`valorPeriodo`/100)),2) AS acumulado, IF(SUM(notas.`NOTA` * (aj.`valorPeriodo`/100)) < 3.5 ,'BAJO','') AS desempeno FROM notas INNER JOIN ajustes aj ON aj.`periodo` = notas.`PERIODO` INNER JOIN areasxsedes_2 axs ON axs.`id` = notas.`codArea` INNER JOIN matriculas mt ON mt.`idMatricula` = notas.idMatricula INNER JOIN estudiantes ON estudiantes.`Documento` = mt.Documento WHERE  axs.`id`= ? AND notas.`Anho` = ? AND notas.curso= ? GROUP BY axs.`id`,mt.`idMatricula`  ORDER BY estudiantes.`PrimerApellido`,estudiantes.`SegundoApellido`,estudiantes.`PrimerNombre`,estudiantes.`SegundoNombre` ASC";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codArea);
                $stm->bindparam(2,$this->Anho);
                $stm->bindparam(3,$this->curso);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al consultar las notas. ".$e;
            }
        }
        
        public function observacion(){
            $this->sql = "SELECT nv.`numActa`,nv.`mesActa`,nv.`diaActa`,nv.`Anho`, axs.`Nombre`, nv.`NOTA`,nv.observacion FROM notas_nivelacion nv INNER JOIN areasxsedes_2 axs ON axs.`id` = nv.`codArea` INNER JOIN matriculas mt ON mt.`idMatricula` = nv.`idMatricula` WHERE mt.`idMatricula` = ?";
                                
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
    }