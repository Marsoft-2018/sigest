<?php
    require("../Modelo/Conect.php");    
    require("../Modelo/curso.php");
    require("../Modelo/profesores.php");
    require("../Modelo/direccionDeCursos.php");
    // require('../Modelo/planillaYnotasClass.php');
    // require("../Modelo/notaFinal.php");
    // require("../Modelo/Boletin.php");


    if(isset($_POST['accion'])){
        $accion=$_POST['accion']; 
    }else{
        echo "No se recibe una accion para ejecutar";
        $accion='nada';
    }


    if($accion == 'cargarMatriz'){        
        $sede = $_POST['sede'];
        $anho = $_POST['anho'];
        include("../vistas/datosSedes/direccionGrupoListado.php");

    }elseif($accion == "asignar"){
        $objDir = new DireccionCurso();
        $objDir->codProfesor = $_POST['profe'];
        $objDir->codCurso = $_POST['curso'];
        $objDir->anho = $_POST['anho'];
        $objDir -> guardar();
    }elseif($accion == "quitar"){
        $objDir = new DireccionCurso();
        $objDir->codProfesor = $_POST['profe'];
        $objDir->codCurso = $_POST['curso'];
        $objDir->anho = $_POST['anho'];
        $objDir -> quitar();
    }

?>