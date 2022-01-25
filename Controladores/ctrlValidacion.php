<?php 
	session_start();

	require_once ("../Modelo/Conect.php");
	require_once '../Modelo/usuario.php';

	$usuario = $_POST['usuario'];
	$password = $_POST['contrasena'];

	// $usuario = $_GET['usuario'];
	// $password = $_GET['contrasena'];
 	
 	// echo "Datos: ".$usuario." - ".$password;
	$objUsu = new Usuario();
	$objUsu->setDatos($usuario,$password);
	echo json_encode($objUsu->login());

?>