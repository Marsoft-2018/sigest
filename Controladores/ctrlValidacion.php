<?php 
	session_start();
    
	include ("encript.php");
	require_once ("../Modelo/Conect.php");
	require_once '../Modelo/usuario.php';
	require ("../Modelo/captcha.php");

	$usuario = $_POST['usuario'];
	$password = $_POST['contrasena'];

//Validación normal
/*    $objUsu = new Usuario();
	$objUsu->setDatos($usuario,$password);
	echo json_encode($objUsu->login());*/
	
	/* Para aplicar la validación del captcha*/
 	$captcha = new Captcha();

    if ($captcha->checkCaptcha($_POST['h-captcha-response'])) {
        $objUsu = new Usuario();
    	$objUsu->setDatos($usuario,$password);
    	echo json_encode($objUsu->login());

    } else {
        $men = "Captcha No válida";
        $datos['mensaje'] = [$men];
        $datos['estado'] = [4];
        echo json_encode($datos);
    }

?>