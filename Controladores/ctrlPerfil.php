<?php 
  require("../Modelo/Conect.php");
  require("../Modelo/usuario.php");

$accion = null;
if(isset($_POST['accion'])){
	$accion = $_POST['accion'];
	$obj = new Usuario();
}

if(isset($_GET['accion'])){
	$accion = $_GET['accion'];
	$obj = new Usuario();
}

 	// echo "parte desde donde se envió: ".$_GET['parte'];
 	//echo "<br>accion a ejecutar: ".$accion;
switch ($accion) {
	case 'Agregar':
		$obj->nombre = $_POST['nombre'];
		$obj->rol = $_POST['rol'];
		$obj->correo = $_POST['correo'];
		$obj->direccion = $_POST['direccion'];
		$obj->telefono = $_POST['telefono'];
		$obj->cargo = $_POST['cargo'];
		$obj->setDatos($_POST['usuario'],$_POST['contrasena']);

		echo $obj->idUsuario." - ".$obj->nombre." - ".$obj->rol." - ".$obj->correo." - ".$obj->direccion." - ".$obj->telefono." - ".$obj->cargo." - ";
		$obj->agregar();
		break;
	case 'Actualizar':
		$obj->idUsuario = $_POST['idUsuario'];
		$obj->nombre = $_POST['nombre'];
		$obj->rol = $_POST['rol'];
		$obj->correo = $_POST['correo'];
		$obj->direccion = $_POST['direccion'];
		$obj->telefono = $_POST['telefono'];
		$obj->cargo = $_POST['cargo'];
		$obj->setDatos($_POST['usuario'],$_POST['contrasena']);
		$obj->actualizar();
		break;
	case 'Cargar':
		$obj->id = $_POST['id_usuario'];
		echo $obj->cargar();
		break;
	case 'Eliminar':
		$obj->idUsuario = $_POST['idUsuario'];
		$obj->desactivar();
		break;
	default:
		http_response_code(400);
		break;
}