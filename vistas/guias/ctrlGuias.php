<?php 
session_start();
require("../../class/Conect.php");
require("classGuia.php");

$accion = "";
$objGuia = new Guia();

if(isset($_POST['accion'])){
    $accion = $_POST['accion'];
}elseif(isset($_GET['accion'])){
    $accion = $_GET['accion'];
}
    switch ($accion) {
        case 'agregar':
            $objGuia->idProfesor    =   $_POST['idProfesor'];
            $objGuia->idCurso   =   $_POST['idCurso'];
            $objGuia->idArea    =   $_POST['idArea'];

            if(isset($_FILES['guia'])){
                $archivo = $_FILES['guia'];
                $nombreGuia  = $archivo["name"];
                $tipo       = $archivo["type"];
                $nombreTemp = $archivo["tmp_name"];
                $tamanho    = $archivo["size"];
                $destino    = "archivos/";

                $extension = end(explode(".", $nombreGuia));
                @unlink($destino.$nombreGuia);
                @unlink($destino.$_POST['guiaAnterior']);
                //echo $_POST['guiaAnterior'];
                $resultado = @move_uploaded_file($nombreTemp, $destino.$nombreGuia);
                if ($resultado){
                    $objGuia->guia  = $nombreGuia;                  
                } 
            }            
            $objGuia->agregar();
        break;

        case 'eliminar':
            $objGuia->id    =   $_POST['id'];
            foreach ($objGuia->cargar() as $value) {
                $objGuia->guia  = $value['guia'];  # code...
            }
            @unlink("archivos/".$objGuia->guia);
            $objGuia->eliminar();    
        break;
        case 'cargarCursos':
            $objGuia->sede = $_POST['sede'];
            echo json_encode($objGuia->cursos());
        break;        
        default:
            # code...
            break;
    }

?>
