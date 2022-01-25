<?php 
	require_once ("../Modelo/Conect.php");
	require_once ("../Modelo/recuperarPass.php");

	$accion = "";

	if(isset($_POST['accion'])){
	    $accion = $_POST['accion'];
	}elseif(isset($_GET['accion'])){
	    $accion = $_GET['accion'];
	}

	switch ($accion) {
		case 'recuperar':
			$usuario = $_POST['usuario'];
			$objPass = new Contrasena();
			$objPass->usuario = $usuario;
			if($objPass->Validar()){
				$token = "";
				foreach ($objPass->datosUsuario() as $dato) {
					$objRecuperar = new Contrasena();
					$objRecuperar->usuario = $usuario;
					$objRecuperar->rol = $dato['rol'];
					$token = $objRecuperar->generarToken();
					$nombre = $dato['nombre'];
					$correo = $dato['correo'];
				}
	            
				$objPass->enviarEmail($usuario,$nombre,$correo,$token);
			}else{				
				$texto = "El Usuario $usuario no se encuentra registrado o activo en la base de datos";
                $datos = array("estado"=>false,"mensaje"=>$texto);
                echo json_encode($datos);
			}			
			break; 
		case 'reestablecer':
			$usuario = $_POST['usuario'];
		 	$token = $_POST['token'];
		 	$pass = $_POST['contrasena'];
			$objPass = new Contrasena();
			$objPass->usuario = $usuario;
			foreach ($objPass->datosUsuario() as $value) {
				$objPass->rol = $value['rol'];
				$objPass->token = $token;
				$objPass->contrasena = $pass;
				$objPass->reestablecer();
			}
			echo true;
			break;
		case 'modificar':
			$objPass = new Contrasena();
			$objPass->usuario = $_POST['usuario'];
			$objPass->rol = $_POST['rol'];
			$objPass->contrasena = $_POST['contrasena'];
			$objPass->modificar();
			break;
		
		default:
			echo false;
			break;
	}



?>