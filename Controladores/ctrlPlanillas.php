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
    $visible = "display:flex;";
    $oculto = "display:none;";
    $accionCampo = "";
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
    //var_dump();
    $respuestaPeriodo = $verificacion->ValidarPeriodo();
    foreach ($respuestaPeriodo['estado'] as $per=>$estado) {
        $estado;
    }

  switch ($tipoUsuario) {
    case 'Administrador':
        echo "El curso POST es: ".$_POST['curso']."<br>";
        nivelPlanilla($_POST['curso']);
        break;
    case 'Profesor':
        if($estado){
            nivelPlanilla($_POST['curso']);
        }else{ ?>
            <div class='alert' style = "font-size: 1.5em; margin:20px; padding: 50px; text-align:center; background-color: #FFD80080">
                Señor docente El periodo elegido se encuentra por fuera del tiempo estipulado para calificar. Por ese motivo no podrá ver la planilla para hacer cambios en las calificaciones,  para observar los datos ingresados diríjase al reporte consolidado.
            </div>
            <?php 
        }
        break;
  }

    function nivelPlanilla($curso){
        $objCurso = new Curso();
        $objCurso->curso = $curso;
        $grado = null;
        foreach($objCurso->consultarGrado() as $campo){
            $grado = $campo['CODGRADO'];
        }
        echo "El curso es: $curso<br>";
        echo "El grado es: $grado<br>";
        if($grado > 0){
            echo "Hola el nivel es basica";
           return include("planillaListado.php");
        }else{
            echo "Hola el nivel es preescolar";
           return include("planillaListadoPreescolar.php");
        }
    }
?>
