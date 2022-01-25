<?php 
	class Profesor extends ConectarPDO{
        public $codsede;
        public $IDUsuario;
        public $Password;
        public $Rol;
        public $Documento;
        public $PrimerNombre;
        public $SegundoNombre;
        public $PrimerApellido;
        public $SegundoApellido;
        public $fechaNacimiento;
        public $sexo;
        public $Dir;
        public $Barrio;
        public $celular;
        public $email;
        public $gradoEscalafon;
        public $estado;
        public $dirGrupo;
        public $idNivelEstudios;
        public $enfasis;
        public $foto;
        public $color;
        public $fecha_reg;
        private $sql;

        public function Listar(){
            $this->sql = "SELECT p.* FROM profesores p WHERE p.codsede ='".$this->codsede."' AND estado= 'Activo' ORDER BY  p.`PrimerNombre`, p.`SegundoNombre`, p.`PrimerApellido`, p.`SegundoApellido`  ASC";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
                $this->Conexion->cerrarConexion(); 
            } catch (Exception $e) {
                echo "Error al listar los profesores. ".$e;
            }
        }

        public function cargar(){
            $this->sql = "SELECT p.* FROM profesores p WHERE p.IDUsuario='".$this->IDUsuario."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al listar los profesores. ".$e;
            }
        }
        
        public function listarNivelEstudios(){
            $this->sql = "SELECT * FROM nivelestudioprofe";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al listar los profesores. ".$e;
            }
        }

        public function direccionDeCurso($profe,$anho,$curso){
            $this->sql = "SELECT ID, codCurso FROM direccioncursos WHERE codProfesor = '".$profe."' AND codCurso = '".$curso."' AND anho ='".$anho."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Error al listar los profesores. ".$e;
            }            
        }
     
        public function agregar(){                      
            if ($this->fechaNacimiento == ''){ $this->fechaNacimiento = '00-00-0000'; }
            $this->sql = "INSERT INTO profesores(codsede, IDUsuario, Password, Documento, PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, fechaNacimiento, sexo, Dir, Barrio, celular, email, gradoEscalafon,  idNivelEstudios, enfasis, color, foto) VALUES(? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?, ?)";

           try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->codsede);
                $stm->bindparam(2,$this->IDUsuario);
                $stm->bindparam(3,$this->Password);
                $stm->bindparam(4,$this->Documento);
                $stm->bindparam(5,$this->PrimerNombre);
                $stm->bindparam(6,$this->SegundoNombre);
                $stm->bindparam(7,$this->PrimerApellido);
                $stm->bindparam(8,$this->SegundoApellido);
                $stm->bindparam(9,$this->fechaNacimiento);
                $stm->bindparam(10,$this->sexo);
                $stm->bindparam(11,$this->Dir);
                $stm->bindparam(12,$this->Barrio);
                $stm->bindparam(13,$this->celular);
                $stm->bindparam(14,$this->email);
                $stm->bindparam(15,$this->gradoEscalafon);
                $stm->bindparam(16,$this->idNivelEstudios);
                $stm->bindparam(17,$this->enfasis);
                $stm->bindparam(18,$this->color);
                $stm->bindparam(19,$this->foto);
                $stm->execute();   
                echo "Profesor agregado con éxito";                       
            } catch (Exception $e) {
               echo "Error al tratar de agregar al Profesor: ".$e;
            }         
        } //  Fin del metodo Agregar Profesor --         

        public function modificar($id){
            $this->sql = "UPDATE profesores SET IDUsuario = ?, Password = ?, Documento = ?, PrimerNombre = ?, SegundoNombre = ?, PrimerApellido = ?, SegundoApellido = ?, fechaNacimiento = ?, sexo = ?, Dir = ?, Barrio = ?, celular = ?, email = ?, gradoEscalafon = ?, idNivelEstudios = ?, enfasis = ?, codsede = ?, estado = ?,  color = ? WHERE idUsuario = '".$id."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->IDUsuario);
                $stm->bindparam(2,$this->Password);
                $stm->bindparam(3,$this->Documento);
                $stm->bindparam(4,$this->PrimerNombre);
                $stm->bindparam(5,$this->SegundoNombre);
                $stm->bindparam(6,$this->PrimerApellido);
                $stm->bindparam(7,$this->SegundoApellido);
                $stm->bindparam(8,$this->fechaNacimiento);
                $stm->bindparam(9,$this->sexo);
                $stm->bindparam(10,$this->Dir);
                $stm->bindparam(11,$this->Barrio);
                $stm->bindparam(12,$this->celular);
                $stm->bindparam(13,$this->email);
                $stm->bindparam(14,$this->gradoEscalafon);
                $stm->bindparam(15,$this->idNivelEstudios);
                $stm->bindparam(16,$this->enfasis);
                $stm->bindparam(17,$this->codsede);
                $stm->bindparam(18,$this->estado);
                $stm->bindparam(19,$this->color);

                $stm->execute();
                echo "<div class='alert alert-success'>
                        Los datos del profesor se actualizaron con éxito, los cambios en los datos de usuario y contraseña se verán reflejados en el próximo inicio de sesión que haga el docente
                </div>";
            } catch (Exception $e) {
                echo "Error al modificar el perfil".$e;
            }            
        }

        public function actualizarPerfil(){
            $this->sql = "UPDATE profesores SET IDUsuario = ?, Password = ?, Documento = ?, PrimerNombre = ?, SegundoNombre = ?, PrimerApellido = ?, SegundoApellido = ?, fechaNacimiento = ?, sexo = ?, Dir = ?, Barrio = ?, celular = ?, email = ?, gradoEscalafon = ?, idNivelEstudios = ?, enfasis = ? WHERE idUsuario = '".$_SESSION['usuario']."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->IDUsuario);
                $stm->bindparam(2,$this->Password);
                $stm->bindparam(3,$this->Documento);
                $stm->bindparam(4,$this->PrimerNombre);
                $stm->bindparam(5,$this->SegundoNombre);
                $stm->bindparam(6,$this->PrimerApellido);
                $stm->bindparam(7,$this->SegundoApellido);
                $stm->bindparam(8,$this->fechaNacimiento);
                $stm->bindparam(9,$this->sexo);
                $stm->bindparam(10,$this->Dir);
                $stm->bindparam(11,$this->Barrio);
                $stm->bindparam(12,$this->celular);
                $stm->bindparam(13,$this->email);
                $stm->bindparam(14,$this->gradoEscalafon);
                $stm->bindparam(15,$this->idNivelEstudios);
                $stm->bindparam(16,$this->enfasis);
                $stm->execute();
                echo "<div class='alert alert-success'>
                        Perfil actualizado con éxito, los cambios en los datos de usuarío y contraseña se verán reflejados en el próximo inicio de sesión
                </div>";
            } catch (Exception $e) {
                echo "Error al modificar el perfil".$e;
            }            
        }

        public function buscarUsuario($idUsuario){
            $sqlBusca=mysql_query("SELECT p.PrimerApellido,p.SegundoApellido,p.PrimerNombre,p.SegundoNombre FROM profesores p WHERE IDUsuario='$idUsuario'");
            $resultado=mysql_num_rows($sqlBusca);
            if($resultado>0){
                echo '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            El usuario que trata de ingresar ya existe en la base de datos, por favor corrija el dato.
                        </div>';
            }
        }
        
        public function agregarDireccionCurso($clave,$valor){
            $sql_buscar=mysql_query("SELECT * FROM direccioncursos WHERE codCurso='$valor';");
            $r=mysql_num_rows($sql_buscar);
            if($r>0){
                while($p=mysql_fetch_array($sql_buscar)){
                    mysql_query("UPDATE profesores SET dirGrupo='NO' WHERE IDUsuario='$p[1]'");
                }
                mysql_query("UPDATE direccioncursos SET codProfesor='$clave' WHERE codCurso='$valor'");
            }else{
                mysql_query("INSERT INTO direccioncursos VALUES('$valor','$clave','')");
            }            
        }//Ok
                
        public function cambiarCurso($clave,$valor){
            mysql_query("UPDATE direccioncursos SET codCurso='$valor' WHERE codProfesor='$clave'");
        }//ok
   
        public function eliminar(){ 
            $this->sql = "DELETE FROM profesores WHERE Documento = ? AND codsede = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->Documento);
                $stm->bindparam(2,$this->codsede);
                $stm->execute();
                echo "El registro del Profesor fue eliminado con éxito";                 
            } catch (Exception $e) {
                echo "Error al tratar de eliminar el registro del profesor".$e;
            }        
        }

        public function quitarCarga($id,$anho){
            $this->sql = "DELETE FROM cargaacademica_new WHERE codProfesor = ? AND anho= ? ";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$id);
                $stm->bindparam(2,$anho);
                $stm->execute();
            } catch (Exception $e) {
                echo "Ocurrio un error: ".$e;
            }
        } 
    }

?>