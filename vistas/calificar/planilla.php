<?php 
    session_start();    
    require("../../Modelo/Conect.php");  
    require("../../Modelo/Estudiante.php");
    require("../../Modelo/Calificacion.php");
    require("../../Modelo/desempenhos.php");
    require("../../Modelo/logros.php");
    require("../../Modelo/periodos.php");

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
        include("planillaListado.php");
        break;
    case 'Profesor':
        if($estado){
            include("planillaListado.php");  
        }else{ ?>
            <div class='alert' style = "font-size: 1.5em; margin:20px; padding: 50px; text-align:center; background-color: #FFD80080">
                Señor docente El periodo elegido se encuentra por fuera del tiempo estipulado para calificar. Por ese motivo no podrá ver la planilla para hacer cambios en las calificaciones,  para observar los datos ingresados diríjase al reporte consolidado.
            </div>
            <?php 
        }
        break;
  }
?>
