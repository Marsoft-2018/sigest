<?php 
	session_start();
	require("../Modelo/Conect.php");
	require("../Modelo/profesores.php");
	require("encript.php");
	$accion;

    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
    }elseif(isset($_GET['accion'])){
        $accion = $_GET['accion'];
    }

	switch ($accion) {
		case 'agregar':
			$fechaNac = $_POST['fechaNacimiento'];
			if ($fechaNac==''){$fechaNac='00-00-0000';}  
			$encr = new SED();
			$objProfe = new Profesor();
	        $objProfe->IDUsuario = $_POST['usuario'];
	        $objProfe->Password = $encr->encryption($_POST['contrasena']);
	        $objProfe->Documento = $_POST['documento'];
	        $objProfe->PrimerNombre = $_POST['PrimerNombre'];
	        $objProfe->SegundoNombre = $_POST['SegundoNombre'];
	        $objProfe->PrimerApellido = $_POST['PrimerApellido'];
	        $objProfe->SegundoApellido = $_POST['SegundoApellido'];
	        $objProfe->fechaNacimiento = $fechaNac;
	        $objProfe->sexo = $_POST['sexo'];
	        $objProfe->Dir = $_POST['direccion'];
	        $objProfe->Barrio = $_POST['barrio'];
	        $objProfe->celular = $_POST['telefono'];
	        $objProfe->email = $_POST['correo'];
	        $objProfe->gradoEscalafon = $_POST['escalafon'];
	        $objProfe->idNivelEstudios = $_POST['estudios'];
	        $objProfe->enfasis = $_POST['enfasis'];
	        $objProfe->codsede	= $_POST['sede'];
			$objProfe->estado	= "Activo";
			$objProfe->dirGrupo	= "NO";
			$objProfe->color	= $_POST['color'];

            if(isset($_FILES['foto'])){
                $archivo = $_FILES['foto'];
                $nombreIMG  = $archivo["name"];
                $tipo       = $archivo["type"];
                $nombreTemp = $archivo["tmp_name"];
                $tamanho    = $archivo["size"];
                $destino    = "../vistas/img/Usuarios/";

                $extension = end(explode(".", $nombreIMG));//con esta linea guardo la extension de la imagen, el cual busca el . al final en el nombre del archivo
                $nuevoNombre = $_POST['documento'].".".$extension;

                $resultado = @move_uploaded_file($nombreTemp, $destino.$nuevoNombre);//ejecuto el comando para que sea movida la imagen temporal a la carpeta destino con el nuevo nombre.
                if ($resultado){
                    $objProfe->foto  = $nuevoNombre;                  
                } else {
                    $objProfe->foto  = "silueta.jpg";
                }

            }else{
               $objProfe->foto  = "silueta.jpg";
            }

			//$objProfe->cursos	= $_POST['cursos'];
	        $objProfe->agregar();
		break;
		case 'actualizarPerfilProfesor':
			$fechaNac = $_POST['fechaNacimiento'];
			if ($fechaNac==''){$fechaNac='00-00-0000';}  
			$encr = new SED();
			$objProfe = new Profesor();
	        $objProfe->IDUsuario = $_POST['usuario'];
	        $objProfe->Password = $encr->encryption($_POST['contrasena']);
	        $objProfe->Documento = $_POST['documento'];
	        $objProfe->PrimerNombre = $_POST['PrimerNombre'];
	        $objProfe->SegundoNombre = $_POST['SegundoNombre'];
	        $objProfe->PrimerApellido = $_POST['PrimerApellido'];
	        $objProfe->SegundoApellido = $_POST['SegundoApellido'];
	        $objProfe->fechaNacimiento = $fechaNac;
	        $objProfe->sexo = $_POST['sexo'];
	        $objProfe->Dir = $_POST['direccion'];
	        $objProfe->Barrio = $_POST['barrio'];
	        $objProfe->celular = $_POST['telefono'];
	        $objProfe->email = $_POST['correo'];
	        $objProfe->gradoEscalafon = $_POST['escalafon'];
	        $objProfe->idNivelEstudios = $_POST['estudios'];
	        $objProfe->enfasis = $_POST['enfasis'];
	        $objProfe->actualizarPerfil();
		break;
		case 'actualizarProfesor':
			$fechaNac = $_POST['fechaNacimiento'];
			if ($fechaNac==''){$fechaNac='00-00-0000';}  
			$encr = new SED();
			$objProfe = new Profesor();
	        $objProfe->IDUsuario = $_POST['usuario'];
	        $objProfe->Password = $encr->encryption($_POST['contrasena']);
	        $objProfe->Documento = $_POST['documento'];
	        $objProfe->PrimerNombre = $_POST['PrimerNombre'];
	        $objProfe->SegundoNombre = $_POST['SegundoNombre'];
	        $objProfe->PrimerApellido = $_POST['PrimerApellido'];
	        $objProfe->SegundoApellido = $_POST['SegundoApellido'];
	        $objProfe->fechaNacimiento = $fechaNac;
	        $objProfe->sexo = $_POST['sexo'];
	        $objProfe->Dir = $_POST['direccion'];
	        $objProfe->Barrio = $_POST['barrio'];
	        $objProfe->celular = $_POST['telefono'];
	        $objProfe->email = $_POST['correo'];
	        $objProfe->gradoEscalafon = $_POST['escalafon'];
	        $objProfe->idNivelEstudios = $_POST['estudios'];
	        $objProfe->enfasis = $_POST['enfasis'];
	        $objProfe->codsede	= $_POST['sede'];
			$objProfe->estado	= $_POST['estado'];
			$objProfe->color	= $_POST['color'];
			//echo "ID: ".$_GET['id'];
	        $objProfe->modificar($_GET['id']);
	        if ($_POST['cambiaSede']=="SI") {
	        	$anho = date("Y");
	        	$objProfe->quitarCarga($_POST['documento'],$anho);
	        }
		break;
		case 'eliminar':
			$objProfe = new Profesor();
			$objProfe->Documento = $_POST['documento'];
			$objProfe->codsede	= $_POST['sede'];
			$objProfe->eliminar();
			break;

		
		default:
			# code...
			break;
	}

?>