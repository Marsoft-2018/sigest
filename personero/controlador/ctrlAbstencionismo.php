<?php
    require("../modelo/conteo.php");
    if(isset($_POST['accion'])){
        $accion=$_POST['accion']; 
        
        //--- Eventos relacionados con los Grados y Grupos ---//
        if($accion=='cargar'){     
            $cont=new Abstencion();	
            $cont->Cargar();
        }

    }else{
        echo "No se recibe una accion para ejecutar";
        $accion='nada';
    }    
?>