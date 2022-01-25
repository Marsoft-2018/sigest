<?php 
session_start();
require("../Modelo/Conect.php");
require("../Modelo/foto.php");

$rol = "";

if(isset($_POST['rol'])){
    $rol = $_POST['rol'];
}elseif(isset($_GET['rol'])){
    $rol = $_GET['rol'];
}
    switch ($rol) {
        case 'Profesor':
            $objFoto = new Foto();
            $objFoto->Rol = $rol;
            $objFoto->IDUsuario  = $_POST['usuario'];

            if(isset($_FILES['foto'])){
                $archivo = $_FILES['foto'];
                $nombreIMG  = $archivo["name"];
                $tipo       = $archivo["type"];
                $nombreTemp = $archivo["tmp_name"];
                $tamanho    = $archivo["size"];
                $destino    = "../vistas/img/Usuarios/";

                $extension = end(explode(".", $nombreIMG));
                $nuevoNombre = $_POST['usuario'].".".$extension;
                @unlink($destino.$nuevoNombre);
                @unlink($destino.$_POST['fotoAnterior']);
                //echo $_POST['fotoAnterior'];
                $resultado = @move_uploaded_file($nombreTemp, $destino.$nuevoNombre);
                if ($resultado){
                    $objFoto->foto  = $nuevoNombre;                  
                } else {
                    $objFoto->foto  = "silueta.jpg";
                }
            }else{
               $objFoto->foto  = "silueta.jpg";
            }
            
            $objFoto->cambiarFoto();
        break;
        case 'Administrador':
            $objFoto = new Foto();
            $objFoto->Rol = $rol;
            $objFoto->IDUsuario  = $_POST['usuario'];

            if(isset($_FILES['foto'])){
                $archivo = $_FILES['foto'];
                $nombreIMG  = $archivo["name"];
                $tipo       = $archivo["type"];
                $nombreTemp = $archivo["tmp_name"];
                $tamanho    = $archivo["size"];
                $destino    = "../vistas/img/Usuarios/";

                $extension = end(explode(".", $nombreIMG));
                $nuevoNombre = $_POST['usuario'].".".$extension;
                @unlink($destino.$nuevoNombre);
                @unlink($destino.$_POST['fotoAnterior']);
                //echo $_POST['fotoAnterior'];
                $resultado = @move_uploaded_file($nombreTemp, $destino.$nuevoNombre);
                if ($resultado){
                    $objFoto->foto  = $nuevoNombre;                  
                } else {
                    $objFoto->foto  = "silueta.jpg";
                }
            }else{
               $objFoto->foto  = "silueta.jpg";
            }
            
            $objFoto->cambiarFoto();
        break;

        case 'value':
        # code...
        break;
        case 'value':
        # code...
        break;
        case 'value':
        # code...
        break;

        
        default:
            # code...
            break;
    }

?>
