<?php
    require("../modelo/candidatos.php");
    if(isset($_POST['accion'])){
        $accion=$_POST['accion']; 
        
        if($accion=='cargar'){     
            $cand=new Candidato();	
            $cand->Cargar();
        }elseif($accion=='cargarNuevo'){     
            $cand=new Candidato();	
            $cand->cargarNuevo();
        }elseif($accion=='Eliminar'){     
            $cand=new Candidato();	
            $cand->eliminar($_POST['codEst']);
            $cand->Cargar();
        }elseif($accion=='guardarSeleccionCandidatos'){
            if(isset($_POST['conjuntoCandidatos'])){
                $cand=new Candidato();
                $cand->Guardar($_POST['conjuntoCandidatos']);
                $cand->Cargar();
            }else{
                $cand=new Candidato();
                $cand->ninguno();
                $cand->Cargar();
            }            
        }
        

    }else{
        echo "No se recibe una accion para ejecutar";
        $accion='nada';
    }

    
?>