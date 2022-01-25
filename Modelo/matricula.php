<?php 
    class Matricula extends ConectarPDO{
        public $idMatricula;
        public $codsede;
        public $Documento;
        public $Curso;
        public $estado;
        public $fechaIngreso;
        public $fechaRetiro;
        public $MotivoDeRetiro;
        public $NombreAcudiente;
        public $barrioAcudiente;
        public $direccionAcudiente;
        public $celAcudiente;
        public $correoAcudiente;
        public $anho;
        private $resultado = array();
        private $sql;

        public function matricular(){
            $this->sql = "INSERT INTO matriculas(codsede, Documento, Curso, fechaIngreso, NombreAcudiente, barrioAcudiente, direccionAcudiente, celAcudiente, correoAcudiente, anho) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codsede);
                $stm->bindparam(2,$this->Documento);
                $stm->bindparam(3,$this->Curso);
                $stm->bindparam(4,$this->fechaIngreso);
                $stm->bindparam(5,$this->NombreAcudiente);
                $stm->bindparam(6,$this->barrioAcudiente);
                $stm->bindparam(7,$this->direccionAcudiente);
                $stm->bindparam(8,$this->celAcudiente);
                $stm->bindparam(9,$this->correoAcudiente);
                $stm->bindparam(10,$this->anho);
                $stm->execute();
                echo "Estudainte matriculado con éxito";          
            } catch (Exception $e) {
               echo "Error al ingresar la matricula del estudiente: ".$e;
            }         
        }//ok       

        public function cargar(){ 
            $this->sql = "SELECT * FROM matriculas WHERE idMatricula = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->idMatricula);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Ocurrió un error al cargar la lista de matriculas".$e;
            } 
        }      

        public function cargarXdocumento(){ 
            $this->sql = "SELECT * FROM matriculas WHERE Documento = ? AND anho = ? AND estado ='Matriculado'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->Documento);
                $stm->bindparam(2,$this->anho);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Ocurrió un error al cargar la lista de matriculas".$e;
            } 
        }

        public function listar(){
            $this->sql = "SELECT mt.`idMatricula`,sd.`NOMSEDE`,cur.`CODGRADO`,cur.`grupo`,j.`abreviatura` AS 'jornada' ,mt.`anho`,mt.`estado`,sd.`CODSEDE` FROM matriculas mt INNER JOIN sedes sd ON sd.`CODSEDE`=mt.`codsede` INNER JOIN cursos cur ON cur.`codCurso`=mt.`Curso` INNER JOIN jornadas j ON j.`idJornada` = cur.`idJornada` WHERE mt.`Documento`='".$this->Documento."' ORDER BY mt.anho DESC";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Ocurrió un error al cargar la lista de matriculas".$e;
            }
        }

        public function cargarListaSede(){
            
        }

        public function modificarMatricula($sede,$campo,$clave,$valor){
            $this->sqlMatriculas = mysql_query("UPDATE matriculas SET `$campo`='$valor' WHERE `idMatricula`='$clave'");
        }

        public function actualizarMatricula(){
            $this->sql = "UPDATE matriculas SET codsede = ?, Curso = ?, fechaIngreso = ?, NombreAcudiente = ?, barrioAcudiente = ?, direccionAcudiente = ?, celAcudiente = ?, correoAcudiente = ?, anho = ?, estado = ?, MotivoDeRetiro = ?, fechaRetiro = ? WHERE idMatricula = '".$this->idMatricula."' ";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codsede);
                $stm->bindparam(2,$this->Curso);
                $stm->bindparam(3,$this->fechaIngreso);
                $stm->bindparam(4,$this->NombreAcudiente);
                $stm->bindparam(5,$this->barrioAcudiente);
                $stm->bindparam(6,$this->direccionAcudiente);
                $stm->bindparam(7,$this->celAcudiente);
                $stm->bindparam(8,$this->correoAcudiente);
                $stm->bindparam(9,$this->anho);
                $stm->bindparam(10,$this->estado);
                $stm->bindparam(11,$this->MotivoDeRetiro);
                $stm->bindparam(12,$this->fechaRetiro);
                if($stm->execute()){
                    $this->resultado['mensaje'] = "Matricula ".$this->idMatricula." actualizada con éxito";          
                    $this->resultado['estado'] = [1];
                }else{
                    $this->resultado['mensaje'] = "Registro no actualizado";          
                    $this->resultado['estado'] = [0];
                }
            } catch (Exception $e) {
                $this->resultado['mensaje'] = "Error Registro no actualizado: ".$e;          
                $this->resultado['estado'] = [0];
            } 
            return $this->resultado;
        }

        public function eliminar(){            
            $this->sql = "DELETE FROM matriculas  WHERE idMatricula= ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->idMatricula);
                $stm->execute();
                echo "Matricula eliminada con éxito";
            } catch (Exception $e) {
                echo "Ocurrió un error al cargar la lista de matriculas".$e;
            }

        }

        public function agregar(){
            $this->sql = "INSERT INTO matriculas(codsede, Documento, Curso, fechaIngreso, NombreAcudiente, barrioAcudiente, direccionAcudiente, celAcudiente, correoAcudiente, anho) VALUES(? ,? ,? ,? ,? ,? ,? ,? ,? ,?)";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codsede);
                $stm->bindparam(2,$this->Documento);
                $stm->bindparam(3,$this->Curso);
                $stm->bindparam(4,$this->fechaIngreso);
                $stm->bindparam(5,$this->NombreAcudiente);
                $stm->bindparam(6,$this->barrioAcudiente);
                $stm->bindparam(7,$this->direccionAcudiente);
                $stm->bindparam(8,$this->celAcudiente);
                $stm->bindparam(9,$this->correoAcudiente);
                $stm->bindparam(10,$this->anho);
                $stm->execute();
                echo "Matricula agregada con éxito";
            } catch (Exception $e) {
                echo "Ocurrió un error al agregar la matriculas".$e;
            } 
        }//ok

        public function numeroEstudiantes($curso,$sede,$anho){
            $this->sql = "SELECT COUNT(estado) AS total FROM matriculas WHERE Curso=? AND codSede= ? AND estado='Matriculado' AND anho=?";
            $total = 0;
            try{
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$curso);
                $stm->bindparam(2,$sede);
                $stm->bindparam(3,$anho);
                $stm->execute();
                $registro = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($registro as $estudiantes) {
                   $total = $estudiantes['total'];
                }
                return $total;
            }catch(PDOException $e){
                echo "Ocurrio un error: ".$e;
            }
            return $this->registro;
        }
    }
?>