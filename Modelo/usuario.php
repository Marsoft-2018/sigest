<?php
	//require_once ("Conect.php");
	class Usuario extends ConectarPDO{
		public $idUsuario;
		private $usuario;
		private $password;
		private $sql;
		public $nombre;
		public $correo;
		public $direccion;
		public $telefono;
		public $cargo;
		public $rol;
		public $estado;

		public function login() {
			$con = 0;
			$this->sql = "SELECT u.institucion,  u.id_usuario,  u.usuario,  u.password,  u.rol,  u.nombre,  u.correo,  u.direccion,  u.telefono,  u.cargo,  u.foto,  u.estado,  u.`fecha_reg` FROM t_users u WHERE u.usuario = ? AND u.PASSWORD = ? AND estado = 1 UNION SELECT cen.id,p.Documento,p.IDUsuario, p.Password, p.Rol, CONCAT(p.PrimerNombre,' ', p.SegundoNombre,' ', p.PrimerApellido,' ', p.SegundoApellido) AS nombre, p.email, CONCAT(p.Dir,' - ', p.Barrio) AS direccion, p.celular, nv.NivelEstudio,p.foto,p.estado,p.fecha_reg FROM profesores p INNER JOIN nivelestudioprofe nv ON nv.id = p.idNivelEstudios INNER JOIN sedes sd ON sd.CODSEDE = p.codsede INNER JOIN centroeducativo cen ON cen.id = sd.CODINST WHERE p.IDusuario = ? AND p.Password = ? AND p.estado = 'Activo' UNION SELECT sd.`CODINST` AS 'institucion',es.Documento,es.IDUsuario, es.Password, es.Rol, CONCAT(es.PrimerNombre,' ', es.SegundoNombre,' ', es.PrimerApellido,' ', es.SegundoApellido) AS nombre, es.tipoDocumento, es.sexo, es.fechaNacimiento, es.estado,es.foto,es.estado,es.fechaIngreso FROM matriculas mt INNER JOIN estudiantes es ON es.Documento = mt.Documento INNER JOIN sedes sd ON sd.`CODSEDE` = mt.codsede WHERE es.IDUsuario = ? AND es.Password = ? AND es.estado = 'Activo' AND mt.anho = '".(date('Y') - 1)."'";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1, $this->usuario);
				$stm->bindParam(2,$this->password);
				$stm->bindParam(3, $this->usuario);
				$stm->bindParam(4,$this->password);
				$stm->bindParam(5, $this->usuario);
				$stm->bindParam(6,$this->password);
				$stm->execute();
				$num = $stm->fetchAll(PDO::FETCH_ASSOC);
				foreach ($num as $key => $value) {
					$_SESSION['institucion'] = $value['institucion'];
					$_SESSION['idUsuario'] = $value['id_usuario'];
					$_SESSION['nombre'] = $value['nombre'];
					$_SESSION['correo'] = $value['correo'];
					$_SESSION['usuario'] = $value['usuario'];
					$_SESSION['password'] = SED::decryption($value['password']);
					$_SESSION['direccion'] = $value['direccion'];
					$_SESSION['telefono'] = $value['telefono'];
					$_SESSION['cargo'] = $value['cargo'];
					$_SESSION['rol'] = $value['rol'];
					$_SESSION['foto'] = $value['foto'];
					$_SESSION['estado'] = $value['estado'];
					$_SESSION['fecha_reg'] = $value['fecha_reg'];
					$con = 1;
				}
				if($con == 1){					
					$con = $this->validarActivacion();
				}
				return $con;
			} catch (Exception $e) {
				echo "Error en la validacion. ".$e;
			}

			if($con == 0){
				return false;
			}
		}

		public function agregar(){
			$this->sql ="INSERT INTO t_users(usuario, password, rol, nombre, correo, direccion, telefono, cargo) VALUES(?,?,?,?,?,?,?,?)";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1,$this->usuario);
				$stm->bindParam(2,$this->password);
				$stm->bindParam(3,$this->rol);
				$stm->bindParam(4,$this->nombre);
				$stm->bindParam(5,$this->correo);
				$stm->bindParam(6,$this->direccion);
				$stm->bindParam(7,$this->telefono);
				$stm->bindParam(8,$this->cargo);
				$stm->execute();
			} catch (Exception $e) {
				echo "error al guardar los datos: ".$e;
			}
		}

		public function actualizar(){
			if ($this->rol == "Profesor") {
				$this->sql ="UPDATE profesores SET usuario=?, correo=?, direccion=?, telefono=? WHERE idUsuario = '".$this->idUsuario."' AND estado = 1";
			}elseif($this->rol == "Administrador"){
				$this->sql ="UPDATE t_users SET usuario=?, rol=?, nombre=?, correo=?, direccion=?, telefono=?, cargo=? WHERE id_usuario = '".$this->idUsuario."' AND estado = 1";		
			}

			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1,$this->usuario);
				$stm->bindParam(2,$this->rol);
				$stm->bindParam(3,$this->nombre);
				$stm->bindParam(4,$this->correo);
				$stm->bindParam(5,$this->direccion);
				$stm->bindParam(6,$this->telefono);
				$stm->bindParam(7,$this->cargo);
				$stm->execute();
				echo "Se guardaron los datos con éxito, debe reiniciar la sesión para que tengan efecto";
			} catch (Exception $e) {
				echo "error al guardar los datos: ".$e;
			}
		}

		public function desactivar(){
			$this->sql ="UPDATE t_users SET estado = 2 WHERE id_usuario = '".$this->idUsuario."' ";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->execute();
			} catch (Exception $e) {
				echo "error al guardar los datos: ".$e;
			}
		}

		public function eliminar(){
			$this->sql ="DELETE FROM t_users WHERE idUsuario= ?";
			try {
				$stm = $this->Conexion->prepare($this->sql);
				$stm->bindParam(1,$this->idUsuario);
				$stm->execute();
			} catch (Exception $e) {
				echo "error al guardar los datos: ".$e;
			}
		}

		public function setDatos($us, $pass){
			$this->usuario = $us;
			$this->password = SED::encryption($pass);
		}

		public function validarActivacion(){
			require ("Institucion.php");
			$obj = new Institucion();
			return $obj->validarActivacion($_SESSION['rol']);
		}

	}
// 	include ("../Controladores/encript.php");	
// 	 $objUsu = new Usuario();
// 	 $objUsu->setDatos('Admin','123456');
// 	 $objUsu->login();

// 	$objUsu->validarActivacion();
// ?>