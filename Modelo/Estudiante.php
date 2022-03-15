
<?php 
    //require("matricula.php");
    //require("Conect.php");
	class Estudiante extends ConectarPDO{
        public $IDUsuario;
        public $Password;
        public $Rol;
        public $PrimerNombre;
        public $SegundoNombre;
        public $PrimerApellido;
        public $SegundoApellido;
        public $tipoDocumento;
        public $Documento;
        public $sexo;
        public $fechaNacimiento;
        public $estado;
        public $fechaIngreso;
        public $sede;
        public $curso;
        public $anho;
        public $idMatricula;
        public $num_interno;
        public $Rinicio;
        public $registros;
        public $foto;
        public $DocumentoAnterior;
        public $fechaRetiro;
        public $MotivoDeRetiro;
        private $sql;

        public function Listar(){
            $this->sql = "SELECT est.Documento, est.PrimerNombre, est.SegundoNombre, est.PrimerApellido, est.SegundoApellido, est.sexo, cur.CODGRADO, cur.grupo, j.abreviatura AS 'jornada', 
mt.estado, mt.idMatricula, mt.anho, s.CODINST, est.tipoDocumento, mt.NombreAcudiente, est.num_interno, g.`NOMGRADO`,g.`nomCampo` FROM estudiantes est INNER JOIN matriculas mt ON mt.Documento = est.Documento INNER JOIN sedes s ON mt.codsede = s.CODSEDE INNER JOIN cursos cur ON mt.Curso = cur.codCurso INNER JOIN jornadas j ON j.idJornada = cur.idJornada INNER JOIN grados g ON g.`CODGRADO` = cur.`CODGRADO` WHERE mt.CODSEDE = ? AND mt.Curso= ? AND mt.anho = ? AND (mt.estado = 'Matriculado' OR mt.estado = 'Promovido') ORDER BY  cur.CODGRADO, cur.grupo, est.PrimerApellido, est.SegundoApellido, est.PrimerNombre, est.SegundoNombre ASC"; 
            if(isset($this->Rinicio) && isset($this->registros)){
                $this->sql .= " LIMIT ".$this->Rinicio.", ".$this->registros." ";
            }
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->sede);
                $stm->bindparam(2,$this->curso);
                $stm->bindparam(3,$this->anho);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (Exception $e) {
                echo "Error al consultar los datos de los estudiantes";
            }
        }

        public function ConsultaEstudiantesEspecificos($estudiantes,$Rinicio,$registros){

            $sqlString = "SELECT est.Documento, est.PrimerNombre, est.SegundoNombre, est.PrimerApellido, est.SegundoApellido, est.sexo, cur.CODGRADO, cur.grupo, j.abreviatura AS 'jornada', mt.estado, mt.idMatricula, mt.anho, s.CODINST, est.tipoDocumento, mt.NombreAcudiente, est.num_interno, est.Password FROM estudiantes est INNER JOIN matriculas mt ON mt.Documento = est.Documento INNER JOIN sedes s ON mt.codsede = s.CODSEDE INNER JOIN cursos cur ON mt.Curso = cur.codCurso INNER JOIN jornadas j ON j.idJornada = cur.idJornada WHERE mt.`codsede`= ? AND mt.`Curso` = ? AND mt.anho = ? ";
            for($i = 0;$i < sizeof($estudiantes); $i++ ){
                if($i == 0){
                    $sqlString .= " AND mt.`idMatricula` = '$estudiantes[$i]'";
                }else{
                    $sqlString .= " OR mt.`idMatricula` = '$estudiantes[$i]'";
                }
            }

            $sqlString .= " ORDER BY est.`PrimerApellido`, est.`SegundoApellido`, est.`PrimerNombre`, est.`SegundoNombre` DESC LIMIT $Rinicio, $registros;";

            $this->sql = $sqlString;
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->sede);
                $stm->bindparam(2,$this->curso);
                $stm->bindparam(3,$this->anho);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (Exception $e) {
                echo "Error al consultar los datos de los estudiantes";
            }
        }

        public function cargarEstudiante($estudiante,$Rinicio,$registros){
            $this->sql = "SELECT est.Documento, est.PrimerNombre, est.SegundoNombre, est.PrimerApellido, est.SegundoApellido, est.sexo, cur.CODGRADO, cur.grupo,j.abreviatura AS 'jornada' ,mt.estado, mt.idMatricula, mt.anho,s.CODINST, est.tipoDocumento, mt.NombreAcudiente, est.num_interno, est.Password FROM estudiantes est INNER JOIN matriculas mt ON mt.Documento = est.Documento INNER JOIN sedes s ON mt.codsede = s.CODSEDE INNER JOIN cursos cur ON mt.Curso = cur.codCurso INNER JOIN jornadas j ON j.idJornada = cur.idJornada WHERE mt.`codsede`= ? AND mt.`Curso`= ? AND mt.anho = ? AND mt.`idMatricula` = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->sede);
                $stm->bindparam(2,$this->curso);
                $stm->bindparam(3,$this->anho);
                $stm->bindparam(4,$estudiante);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (Exception $e) {
                echo "Error al consultar los datos de los estudiantes";
            }
        }

        public function listarCurso(){
            $this->sql = "SELECT est.Documento,est.PrimerNombre,est.SegundoNombre,est.PrimerApellido,est.SegundoApellido,est.sexo,cur.CODGRADO,cur.grupo,j.abreviatura AS 'jornada' ,mt.estado, mt.idMatricula, mt.anho,s.CODINST, est.tipoDocumento, est.num_interno FROM estudiantes est INNER JOIN matriculas mt ON mt.Documento = est.Documento INNER JOIN sedes s ON mt.codsede = s.CODSEDE INNER JOIN cursos cur ON mt.Curso = cur.codCurso INNER JOIN jornadas j ON j.idJornada = cur.idJornada WHERE mt.Curso= ? AND mt.anho = ? AND (mt.estado = 'Matriculado' OR mt.estado = 'Promovido') ORDER BY  cur.CODGRADO, cur.grupo, est.PrimerApellido, est.SegundoApellido, est.PrimerNombre, est.SegundoNombre ASC"; 
            if(isset($this->Rinicio) && isset($this->registros)){
                $this->sql .= " LIMIT ".$this->Rinicio.", ".$this->registros." ";
            }
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->curso);
                $stm->bindparam(2,$this->anho);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (Exception $e) {
                echo "Error al consultar los datos de los estudiantes";
            }
        }

        public function listadoSede(){          
            $this->sql = "SELECT mt.`Curso`,mt.`idMatricula`,est.`tipoDocumento`,est.`Documento`,est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre`,cr.`CODGRADO`,cr.`grupo`, est.num_interno FROM matriculas mt INNER JOIN estudiantes est ON est.`Documento`  =  mt.`Documento` INNER JOIN cursos cr ON cr.`codCurso` =  mt.`Curso` WHERE mt.`codsede`  =  ? AND mt.`estado`  =  'Matriculado' AND mt.`anho`  = ? ORDER BY cr.`CODGRADO`, cr.`grupo`, est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre` ASC"; 
            
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->sede);
                $stm->bindparam(2,$this->anho);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (Exception $e) {
                echo "Error al consultar los datos de los estudiantes";
            }            
        }

        public function totalEstudiantesXcurso(){
             
            $this->sql = "SELECT COUNT(idMatricula) AS total FROM matriculas WHERE curso= ? AND anho= ? AND estado ='Matriculado'"; 
            if(isset($this->Rinicio) && isset($this->registros)){
                $this->sql .= " LIMIT ".$this->Rinicio.", ".$this->registros." ";
            }
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->curso);
                $stm->bindparam(2,$this->anho);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $valor) {
                    $data = $valor['total'];
                }
                return $data;
            } catch (Exception $e) {
                echo "Error al consultar los datos de los estudiantes";
            }
        }

        public function totalEstudiantesXsede(){
             
            $this->sql = "SELECT COUNT(idMatricula) AS total FROM matriculas WHERE sede= ? AND anho= ? AND estado ='Matriculado'"; 
            if(isset($this->Rinicio) && isset($this->registros)){
                $this->sql .= " LIMIT ".$this->Rinicio.", ".$this->registros." ";
            }
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->sede);
                $stm->bindparam(2,$this->anho);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $valor) {
                    $data = $valor['total'];
                }
                return $data;
            } catch (Exception $e) {
                echo "Error al consultar los datos de los estudiantes";
            }
        }
        
        public function agregar(){
            if ($this->fechaNacimiento == ''){ $this->fechaNacimiento = '00-00-0000'; }
            if ($this->fechaIngreso ==''){ $this->fechaIngreso ='00-00-0000'; }

            $this->sql = "INSERT INTO estudiantes(IDUsuario, Password, Rol,  PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, tipoDocumento, Documento, sexo, fechaNacimiento, foto, num_interno) VALUES(? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? , ?, ?)";

           try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->IDUsuario);
                $stm->bindparam(2,$this->Password);
                $stm->bindparam(3,$this->Rol);
                $stm->bindparam(4,$this->PrimerNombre);
                $stm->bindparam(5,$this->SegundoNombre);
                $stm->bindparam(6,$this->PrimerApellido);
                $stm->bindparam(7,$this->SegundoApellido);
                $stm->bindparam(8,$this->tipoDocumento);
                $stm->bindparam(9,$this->Documento);
                $stm->bindparam(10,$this->sexo);
                $stm->bindparam(11,$this->fechaNacimiento);
                $stm->bindparam(12,$this->foto);
                $stm->bindparam(13,$this->num_interno);
                
                $stm->execute();   
                echo "Los datos del estudiante fueron guardados con éxito";                         
            } catch (Exception $e) {
               echo "Error al tratar de agregar al estudiente: ".$e;
            } 
        }
        
        public function cargar(){
            $this->sql = "SELECT * from estudiantes WHERE Documento = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->Documento);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Ocurrió un error al cargar los datos ".$e;    
            }                                  
        }
        
        public function buscarUsuario($idUsuario){
            $this->sql = "SELECT p.PrimerApellido,p.SegundoApellido,p.PrimerNombre,p.SegundoNombre FROM estudiantes p WHERE IDUsuario= ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$idUsuario);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach($datos as $value){
                    echo '<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            El usuario que trata de ingresar ya existe en la base de datos, por favor corrija el dato.
                        </div>';
                }
            } catch (Exception $e) {
                echo "Ocurrió un error al cargar los datos ".$e;    
            }  
        }//OK
        
        public function modificar(){
           if ($this->fechaNacimiento == ''){ $this->fechaNacimiento = '00-00-0000'; }

            $this->sql = "UPDATE estudiantes SET IDUsuario = ?, Password = ?, Rol = ?,  PrimerNombre = ?, SegundoNombre = ?, PrimerApellido = ?, SegundoApellido = ?, tipoDocumento = ?, Documento = ?, sexo = ?, fechaNacimiento = ?, foto = ?, num_interno = ? WHERE Documento = '".$this->DocumentoAnterior."' ";

           try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->IDUsuario);
                $stm->bindparam(2,$this->Password);
                $stm->bindparam(3,$this->Rol);
                $stm->bindparam(4,$this->PrimerNombre);
                $stm->bindparam(5,$this->SegundoNombre);
                $stm->bindparam(6,$this->PrimerApellido);
                $stm->bindparam(7,$this->SegundoApellido);
                $stm->bindparam(8,$this->tipoDocumento);
                $stm->bindparam(9,$this->Documento);
                $stm->bindparam(10,$this->sexo);
                $stm->bindparam(11,$this->fechaNacimiento);
                $stm->bindparam(12,$this->foto);
                $stm->bindparam(13,$this->num_interno);
                $stm->execute();   
                echo "Los datos del estudiante fueron actualizados con éxito";                       
            } catch (Exception $e) {
               echo "Error al tratar de agregar al estudiente: ".$e;
            } 
        }//OK
        
        public function cambiarFoto($usuario,$fotoAnterior,$archivo,$nombreIMG,$tipo,$nombreTemp,$tamanho,$destino){  
            //echo "<br>--$usuario,<br>-- $fotoAnterior,<br>-- $archivo,<br>-- $nombreIMG,<br>-- $tipo,<br>-- $nombreTemp,<br>-- $tamanho,<br>-- $destino ";
            if($tipo!="image/jpg" && $tipo!="image/jpeg" && $tipo!="image/png"){
                echo "El archivo no es del tipo permitido, por favor seleccione otro";
            }elseif($tamanho>1024*1024){
                echo "Error: la imagén excede el tamaño máximo permitido de 1Mb";
            }else{
                $extension = end(explode(".", $nombreIMG));//con esta linea guardo la extension de la imagen                
                $id;
                $datosTabla=mysql_query("SELECT idFoto FROM fotoestudiantes WHERE idFoto=1");
                $resultado=mysql_num_rows($datosTabla);
                if($resultado==0){
                    $id=1;
                }else{
                    $datosTabla=mysql_query("SELECT MAX(idFoto) FROM fotoestudiantes"); 
                    while($r=mysql_fetch_array($datosTabla)){
                        $id=$r[0]+1;
                    }
                }                     
            }
            $nombreAnterior="IMG".$fotoAnterior.".".$extension;        
            $nuevoNombre="IMG".$id.".".$extension;
            //elimino la imagen anterior para depues reemplazarla con la nueva
            if ($fotoAnterior!=0){ 
                @unlink($destino.$nombreAnterior);
                mysql_query("DELETE FROM fotoestudiantes WHERE idFoto='$fotoAnterior'");
            } 
            $resultado = @move_uploaded_file($nombreTemp, $destino.$nuevoNombre);
            if ($resultado){                    
                mysql_query("INSERT INTO fotoestudiantes VALUES('$usuario','$id','$nuevoNombre');");                
                echo '<div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Se actualizó con éxito.
                    </div>';
            } else {
                echo '<div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        Ocurrio un error al subir la imágen al servidor.
                    </div>';
            }            
        }//Pendiente por modificar
        
        public function retirar(){
            // $sql1 = "UPDATE estudiantes SET estado = 'Inactivo' WHERE Documento = '".$this->Documento."'";
            $sql2 = "UPDATE matriculas SET fechaRetiro = '".$this->fechaRetiro."', MotivoDeRetiro = '".$this->MotivoDeRetiro."', estado = 'Retirado' WHERE idMatricula = '".$this->idMatricula."'";   
            try {
                // $stm = $this->Conexion->prepare($sql1);
                // $stm->execute();
                $stm2 = $this->Conexion->prepare($sql2);
                $stm2->execute();
                echo "Estudiante retirado con éxito";
            } catch (Exception $e) {
               echo "Error al tratar de retirar al estudiante";
            }   
        }//OK

        public function eliminar(){
            $estado;
            $this->sql = "SELECT Estado FROM matriculas WHERE idMatricula = '".$this->idMatricula."'";
            $sqlEliminar = "DELETE FROM matriculas WHERE idMatricula = '".$this->idMatricula."'";
            $sqlEliminar2 = "DELETE FROM estudiantes WHERE Documento = '".$this->Documento."'";
            $sqlUpdate = "UPDATE matriculas SET estado = 'Eliminado' WHERE idMatricula = '".$this->idMatricula."'"; 
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datos as $value) {
                    if($value['estado'] == "Eliminado"){                        
                        try {
                            $stm2 = $this->Conexion->prepare($sqlEliminar);
                            $stm2->execute();  
                            
                            $stm3 = $this->Conexion->prepare($sqlEliminar2);
                            $stm3->execute(); 
                            echo "El registro del Estudiante fue eliminado con éxito";    
                        } catch (Exception $e) {
                           echo "Error al tratar de eliminar el registro del estudiante";
                        }                         
                    }else{ 
                        try {
                            $stm2 = $this->Conexion->prepare($sqlUpdate);
                            $stm2->execute(); 
                            echo "El registro del Estudiante fue eliminado con éxito";    
                        } catch (Exception $e) {
                           echo "Error al tratar de eliminar el registro del estudiante";
                        }  
                    }     
                }
            } catch (Exception $e) {
                
            }
        }//OK

        public function restaurar(){
            $this->sql = "UPDATE matriculas SET estado = 'Matriculado' WHERE idMatricula = '".$this->idMatricula."'";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->execute();
                echo "El registro del Estudiante fue restaurado con éxito";
            } catch (Exception $e) {
                echo "Error al tratar de restaurar el registro del estudiante";
            }
        }
        
        
        public function edad($fechanacimiento){
            list($ano,$mes,$dia) = explode("-",$fechanacimiento);
            $ano_diferencia  = date("Y") - $ano;
            $mes_diferencia = date("m") - $mes;
            $dia_diferencia   = date("d") - $dia;
            if ($dia_diferencia < 0 || $mes_diferencia < 0)
                $ano_diferencia--;
            return $ano_diferencia;
        }
        
        public function numeroEnLista($idMatricula){
            $count = 1;
            
            foreach($this->Listar() as $value){
                if ($idMatricula == $value['idMatricula']){
                    return $count;
                }
                $count++;
            }
        }

        public function cargarPorIdMatricula(){
            $this->sql = "SELECT est.Documento, est.PrimerNombre, est.SegundoNombre, est.PrimerApellido, est.SegundoApellido, est.sexo, mt.estado, mt.idMatricula, mt.anho, est.tipoDocumento, mt.NombreAcudiente, est.num_interno ,est.foto
            FROM estudiantes est INNER JOIN matriculas mt ON mt.Documento = est.Documento WHERE mt.idMatricula = ?";
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->idMatricula);
                $stm->execute();
                $datos = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $datos;
            } catch (Exception $e) {
                echo "Ocurrió un error al cargar los datos ".$e;    
            }                                  
        }
        
        public function listaRetiradosCurso(){
            $this->sql = "SELECT est.Documento,est.PrimerNombre,est.SegundoNombre,est.PrimerApellido,est.SegundoApellido,est.sexo,cur.CODGRADO,cur.grupo,j.abreviatura AS 'jornada' ,mt.estado, mt.idMatricula, mt.anho,s.CODINST, est.tipoDocumento, est.num_interno FROM estudiantes est INNER JOIN matriculas mt ON mt.Documento = est.Documento INNER JOIN sedes s ON mt.codsede = s.CODSEDE INNER JOIN cursos cur ON mt.Curso = cur.codCurso INNER JOIN jornadas j ON j.idJornada = cur.idJornada WHERE mt.Curso= ? AND mt.anho = ? AND (mt.estado = 'Retirado' OR mt.estado = 'Eliminado') ORDER BY  cur.CODGRADO, cur.grupo, est.PrimerApellido, est.SegundoApellido, est.PrimerNombre, est.SegundoNombre ASC"; 
            if(isset($this->Rinicio) && isset($this->registros)){
                $this->sql .= " LIMIT ".$this->Rinicio.", ".$this->registros." ";
            }
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->curso);
                $stm->bindparam(2,$this->anho);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (Exception $e) {
                echo "Error al consultar los datos de los estudiantes";
            }
        }

        public function listaRetiradosSede(){          
            $this->sql = "SELECT mt.`Curso`,mt.`idMatricula`,est.`tipoDocumento`,est.`Documento`,est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre`,cr.`CODGRADO`,cr.`grupo`, est.num_interno FROM matriculas mt INNER JOIN estudiantes est ON est.`Documento`  =  mt.`Documento` INNER JOIN cursos cr ON cr.`codCurso` =  mt.`Curso` WHERE mt.`codsede`  =  ? AND mt.`estado`  =  'Matriculado' AND mt.`anho`  = ? AND (mt.estado = 'Retirado' OR mt.estado = 'Eliminado') ORDER BY cr.`CODGRADO`, cr.`grupo`, est.`PrimerApellido`,est.`SegundoApellido`,est.`PrimerNombre`,est.`SegundoNombre` ASC"; 
            
            try {
                $stm = $this->Conexion->prepare($this->sql);
                $stm->bindparam(1,$this->sede);
                $stm->bindparam(2,$this->anho);
                $stm->execute();
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (Exception $e) {
                echo "Error al consultar los datos de los estudiantes";
            }            
        }
        
    }

    // $obj = new Estudiantes();
    // $obj->curso = 18;
    // $obj->anho = 2020;
    // $obj->sede = '213244000880';
    // $datos = $obj->consulta();
    // echo "<pre>";
    // var_dump($datos);
    // echo "</pre>";
 ?>