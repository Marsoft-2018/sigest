<?php 
    session_start();    
    require("../Modelo/Conect.php");  
    require("../Modelo/Estudiante.php");
    require("../Modelo/Calificacion.php");
    require("../Modelo/desempenhos.php");
    require("../Modelo/logros.php");
    require("../Modelo/periodos.php");
    require("../Modelo/curso.php");
    require("../Modelo/grado.php");

    $anho = $_POST['anho'];
    $tipoUsuario = $_SESSION['rol'];
    $codArea = $_POST['codArea'];
    $periodo = $_POST['periodo'];
    $nota = "";
    $estado = 0;
    $visible = "display:flex;";
    $oculto = "display:none;";
    $accionCampo = "";
    $accion ="";
    
    if(isset($_REQUEST['accion'])){
        $accion = $_REQUEST['accion'];
    }
    
    $objEstudiante = new Estudiante();
    $objEstudiante->curso = $_POST['curso'];
    $objEstudiante->anho = $anho;

    $verificacion = new Periodo();
    $verificacion->periodo =  $_POST['periodo'];
    $verificacion->anho = $anho;       
        $cont=1;
        $des="";
        $nota;    
    //echo "estado del periodo: ".$estadoPeriodo."<br>";
    //var_dump($_REQUEST);
    //echo "El tipo de usuario es: ".$tipoUsuario;
    $respuestaPeriodo = $verificacion->ValidarPeriodo();
    foreach ($respuestaPeriodo['estado'] as $per=>$estado) {
        $estado;
    }
    //echo "  --- El estado del periodo es: ".$estado;
    switch ($tipoUsuario) {
    case 'Administrador':
        //echo "El curso POST es: ".$_POST['curso']."<br>";
        //nivelPlanilla($_POST['curso']);
        $objCurso = new Curso();
        $objCurso->curso = $_POST['curso'];
        $grado = null;
        foreach($objCurso->consultarGrado() as $campo){
            $grado = $campo['CODGRADO'];
        }        
        include("../vistas/calificar/planillaListado.php");

        break;
    case 'Profesor':
        if($estado == 1){
            //nivelPlanilla($_POST['curso']);
             $objCurso = new Curso();
            $objCurso->curso = $_POST['curso'];
            $grado = null;
            foreach($objCurso->consultarGrado() as $campo){
                $grado = $campo['CODGRADO'];
            }  
            include("../vistas/calificar/planillaListado.php");
        }else{ ?>
            <div class='alert' style = "font-size: 1.5em; margin:20px; padding: 50px; text-align:center; background-color: #FFD80080">
                Señor docente El periodo elegido se encuentra por fuera del tiempo estipulado para calificar. Por ese motivo no podrá ver la planilla para hacer cambios en las calificaciones,  para observar los datos ingresados diríjase al reporte consolidado.
            </div>
            <?php 
        }
        break;
  }

    switch($accion){
        case "activarObservaciones":
            echo "Toggle para el botón de observaciones";
            break;
    }
?>
