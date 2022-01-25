<?php
echo "La variable accion tiene el valor: ".$_POST['accion'];

echo $_POST['NewUSU']."<br>";
echo $_POST['NewCON']."<br>";
echo $_POST['NewEST']."<br>";
echo $_POST['NewROL']."<br>";
echo $_POST['NewDOC']."<br>";
echo $_POST['NewNO1']."<br>";
echo $_POST['NewNO2']."<br>";
echo $_POST['NewAP1']."<br>";
echo $_POST['NewAP2']."<br>";
echo $_POST['NewNAC']."<br>";
echo $_POST['NewSEX']."<br>";
echo $_POST['NewDIR']."<br>";
echo $_POST['NewBAR']."<br>";
echo $_POST['NewCEL']."<br>";
echo $_POST['NewCOR']."<br>";
echo $_POST['NewESC']."<br>";

//echo "Cargó con exito el archivo cargarFoto.php";
    if ($_FILES["imgProfe"]["error"] > 0){
        echo "ha ocurrido un error";
    }

    if(isset($_FILES['imgProfe'])){
        $archivo = $_FILES['imgProfe'];
        $nombre=$archivo["name"];
        $tipo=$archivo["type"];
        $ruta_temp=$archivo["tmp_name"];
        $tamanho=$archivo["size"];
        $carpeta="IMAGENES/usuarios/";
        if($tipo!="image/jpg" && $tipo!="image/jpeg" && $tipo!="image/png"){
            echo "El archivo no es del tipo permitido, por favor seleccione otro";
        }elseif($tamanho>1024*1024){
            echo "Error: la imagén excede el tamaño máximo permitido de 1Mb";
        }else{
            echo "<br>El metodo está listo para cargar la imagen";
        }

    }else{
       echo "<br>No se recibe la variable con la imagen<br>

       <button type='button' id='botonCan' class='btn btn-warning' style='margin-top:20px;'  onclick='cancelar()'><i class='fa fa-reply'></i> Cancelar</button>     
       ";
    }
?>