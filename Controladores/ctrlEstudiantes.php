<?php 

require("../Modelo/Conect.php");
require("../Modelo/Estudiante.php");
require("../Modelo/matricula.php");

$accion = "";

if(isset($_POST['accion'])){
    $accion = $_POST['accion'];
}elseif(isset($_GET['accion'])){
    $accion = $_GET['accion'];
}

    switch ($accion) {
        case 'agregarEstudiante':
            $objEstudiante = new Estudiante();
            $objMatricula = new Matricula();
            $objEstudiante->IDUsuario  = $_POST['usuario'];
            $objEstudiante->Password   = $_POST['contrasena'];
            $objEstudiante->Rol       = "Estudiante";
            $objEstudiante->num_interno = $_POST['num_interno']; 
            $objEstudiante->tipoDocumento = $_POST['tipoDocumento']; 
            $objEstudiante->Documento = $_POST['documento'];
            $objEstudiante->PrimerNombre   = $_POST['primerNombre'];
            $objEstudiante->SegundoNombre   = $_POST['segundoNombre'];
            $objEstudiante->PrimerApellido = $_POST['primerApellido'];
            $objEstudiante->SegundoApellido = $_POST['segundoApellido'];
            $objEstudiante->fechaNacimiento  = $_POST['fechaNacimiento'];
            $objEstudiante->sexo  = $_POST['sexo'];
            $objEstudiante->correo  = $_POST['correo'];


            $objMatricula->codsede = $_POST['sede'];
            $objMatricula->Documento = $_POST['documento'];
            $objMatricula->Curso = $_POST['cursoMatricula'];
            $objMatricula->fechaIngreso = $_POST['fechaIngreso'];
            $objMatricula->NombreAcudiente = $_POST['nombreAcudiente'];
            $objMatricula->barrioAcudiente = $_POST['barrioAcudiente'];
            $objMatricula->direccionAcudiente = $_POST['direccionAcudiente'];
            $objMatricula->celAcudiente = $_POST['celAcudiente'];
            $objMatricula->correoAcudiente = $_POST['correoAcudiente'];
            $objMatricula->anho = $_POST['anho'];


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
                    $objEstudiante->foto  = $nuevoNombre;                  
                } else {
                    $objEstudiante->foto  = "silueta.jpg";
                }

            }else{
               $objEstudiante->foto  = "silueta.jpg";
            }
            
            $objEstudiante->agregar();
            $objMatricula->matricular();
        break;

        case 'modificar':
            $objEstudiante = new Estudiante();
            $objEstudiante->DocumentoAnterior = $_POST['documentoAnterior'];
            $objEstudiante->IDUsuario  = $_POST['usuario'];
            $objEstudiante->Password   = $_POST['contrasena'];
            $objEstudiante->Rol       = "Estudiante";
            $objEstudiante->num_interno = $_POST['num_interno']; 
            $objEstudiante->tipoDocumento = $_POST['tipoDocumento']; 
            $objEstudiante->Documento = $_POST['documento'];
            $objEstudiante->PrimerNombre   = $_POST['primerNombre'];
            $objEstudiante->SegundoNombre   = $_POST['segundoNombre'];
            $objEstudiante->PrimerApellido = $_POST['primerApellido'];
            $objEstudiante->SegundoApellido = $_POST['segundoApellido'];
            $objEstudiante->fechaNacimiento  = $_POST['fechaNacimiento'];
            $objEstudiante->sexo  = $_POST['sexo'];
            $objEstudiante->correo  = $_POST['correo'];

            /*
                $objMatricula = new Matricula();
                $objMatricula->codsede = $_POST['sede'];
                $objMatricula->Documento = $_POST['documento'];
                $objMatricula->Curso = $_POST['cursoMatricula'];
                $objMatricula->fechaIngreso = $_POST['fechaIngreso'];
                $objMatricula->NombreAcudiente = $_POST['nombreAcudiente'];
                $objMatricula->barrioAcudiente = $_POST['barrioAcudiente'];
                $objMatricula->direccionAcudiente = $_POST['direccionAcudiente'];
                $objMatricula->celAcudiente = $_POST['celAcudiente'];
                $objMatricula->correoAcudiente = $_POST['correoAcudiente'];
                $objMatricula->anho = $_POST['anho'];
            */

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
                    $objEstudiante->foto  = $nuevoNombre;                  
                } else {
                    $objEstudiante->foto  = "silueta.jpg";
                }

            }else{
               $objEstudiante->foto  = "silueta.jpg";
            }
            
            //$objMatricula->actualizarMatricula();
            $objEstudiante->modificar();
        break;
        
        case 'loadMatricula':
            $objMatricula = new Matricula();
            $objMatricula->idMatricula = $_POST['idMatricula'];
            echo json_encode($objMatricula->cargar());        
        break;
        
        case 'addMatricula':
            $objMatricula = new Matricula();
            $objMatricula->codsede = $_POST['sede'];
            $objMatricula->Documento = $_POST['documento'];
            $objMatricula->Curso = $_POST['cursoMatricula'];
            $objMatricula->fechaIngreso = $_POST['fechaIngreso'];
            $objMatricula->NombreAcudiente = $_POST['nombreAcudiente'];
            $objMatricula->barrioAcudiente = $_POST['barrioAcudiente'];
            $objMatricula->direccionAcudiente = $_POST['direccionAcudiente'];
            $objMatricula->celAcudiente = $_POST['celAcudiente'];
            $objMatricula->correoAcudiente = $_POST['correoAcudiente'];
            $objMatricula->anho = $_POST['anho'];
            $objMatricula->agregar();        
        break;
        
        case 'setMatricula':
            $objMatricula = new Matricula();
            $objMatricula->idMatricula = $_POST['idMatricula'];
            $objMatricula->codsede = $_POST['sedeMatricula'];
            $objMatricula->Curso = $_POST['cursoMatricula'];
            $objMatricula->fechaIngreso = $_POST['fechaIngreso'];
            $objMatricula->NombreAcudiente = $_POST['nombreAcudiente'];
            $objMatricula->barrioAcudiente = $_POST['barrioAcudiente'];
            $objMatricula->direccionAcudiente = $_POST['direccionAcudiente'];
            $objMatricula->celAcudiente = $_POST['celAcudiente'];
            $objMatricula->correoAcudiente = $_POST['correoAcudiente'];
            $objMatricula->anho = $_POST['anhoMatricula']; 
            $objMatricula->estado = $_POST['estado'];            
            $objMatricula->MotivoDeRetiro = $_POST['txtRetiro'];            
            $objMatricula->fechaRetiro = $_POST['fechaRetiro'];            
            
            echo json_encode($objMatricula->actualizarMatricula());
        break;

        case 'eliminarMatricula':
            $objMatricula = new Matricula();
            $objMatricula->idMatricula = $_POST['idMatricula'];
            $objMatricula->eliminar();        
        break;
        case 'eliminar':
            $objEstudiante = new Estudiante();
            $objEstudiante->Documento = $_POST['documento'];
            $objEstudiante->idMatricula  = $_POST['idMatricula'];
            $objEstudiante->eliminar();
        break;
        case 'restaurarEstudiante':
            $objEstudiante = new Estudiante();
            $objEstudiante->idMatricula  = $_POST['idMatricula'];
            $objEstudiante->restaurar();
        break;
        case 'retirar':
            $objEstudiante = new Estudiante();
            //$objEstudiante->Documento = $_POST['documento'];
            $objEstudiante->idMatricula  = $_POST['idMatricula'];
            $objEstudiante->fechaRetiro = $_POST['fechaRetiro'];
            $objEstudiante->MotivoDeRetiro  = $_POST['MotivoDeRetiro'];
            $objEstudiante->retirar();
        break;
       
        default:
            # code...
            break;
    }

?>
