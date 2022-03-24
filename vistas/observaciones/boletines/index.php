<?php 

    $anho = $_POST['anho'];
    $tipoUsuario = $_SESSION['rol'];
    $periodo = $_POST['periodo'];
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
        include("lista.php");
        break;
    case 'Profesor':
        if($estado){
            include("lista.php");  
        }else{ ?>
            <div class='alert' style = "font-size: 1.5em; margin:20px; padding: 50px; text-align:center; background-color: #FDADA020">
                Señor docente El periodo elegido se encuentra por fuera del tiempo estipulado para calificar. Por ese motivo no podrá ver la planilla para hacer cambios en las observaciones.
            </div>
            <?php 
        }
        break;
  }
?>
