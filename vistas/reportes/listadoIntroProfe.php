<?php
	//require("../CONECT.php");
    session_start();
    require("../../Modelo/Conect.php");
    require("../../Modelo/anhoLectivo.php");
    require("../../Modelo/periodos.php");
    require("../../Modelo/curso.php"); 
    require("../../Modelo/desempenhos.php");

    $institucionID = $_SESSION['institucion'];
    $usuario = $_SESSION['idUsuario'];
    $tipoDeUsuario = $_SESSION['rol'];
    $objAnho = new Anho();
?>

<!-- Codigo Nuevo -->
<div style="width: 100%;">
    <br>    
    <div class="row">
        <div class="col-md-12">            
            <div class="x_panel">
              <div class="x_title seccion-cabecera">
                  <h3>REPORTE LISTADOS DE ESTUDIANTES</h3>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <form method="post" action="vistas/reportes/enPdf/reporte.php" target="_blank" id="formEstudiante">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-xs-12">
                            <label for="">CURSO</label>
                            <select id='curso' name='curso' class='form-control' 
                                style='margin:0px; padding: 0px;' required>
                                <option value=''>Seleccione...</option>
                                <?php
                                    $objCurso = New Curso();  
                                    $objCurso->tipoUsuario = $tipoDeUsuario;
                                    $objCurso->idUsuario = $usuario;
                                    $objCurso->anho = $objAnho->Cargar();
                                    $datos = $objCurso->listar();

                                    foreach ($datos as $value) {
                                        ?>
                                        <option value="<?php echo $value['codCurso']; ?>">
                                            <?php echo $value['nombreCurso']; ?>
                                        </option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>                        
                        <div class="col-lg-2 col-md-2 col-xs-12 p-0">
                            <label for="">AÑO</label>
                            <?php                            
                                $objAnho = new Anho();
                                $objAnho->inst = $institucionID;
                                $anhos = $objAnho->Listar();
                                echo "<select class='form-control' id='anho' name='anho' required>";
                                foreach ($anhos as $key => $value) {
                                    echo "<option value='".$value['Alectivo']."'>".$value['Alectivo']."</option>";
                                }
                                echo "</select>";
                            ?>
                        </div>
                        <div class="col-lg-3 col-md-3">
                          <label for="">TIPO DE LISTADO</label>                           
                          <select name="tipoReporte" id="tipoReporte" class="form-control" required onchange="verPeriodo(this.value)">
                            <option value=''>Seleccione...</option>  
                            <option value='5'>Asistencia</option> 
                            <option value='6'>Planilla Impresa</option>  
                            <option value='9'>Planilla con calificaciones</option>  
                          </select>                            
                        </div>
                        <div class="col-lg-2 col-sm-2" id="periodo_view">
                            <label for="">PERIODO</label> 
                            <select id='periodo' name='periodo' class='form-control' style='margin:0px; padding: 0px;' required disabled>
                                <option value=''>Seleccione...</option>
                                <?php
                                    $objP = new Periodo();
                                    $listPeriodo = $objP->cargar();
                                    foreach ($listPeriodo as $key => $periodo) {
                                        echo "<option value='".$periodo['periodo']."'>".$periodo['periodo']."</option>";
                                    }
                                ?>
                            </select>
                        </div>  
                        <div class="col-lg-3 col-sm-3">
                          <button type="submit" class="btn btn-info btnPrincipal" style="margin-top:25px;" title="Ver reporte pdf" ><i class="fa fa-eye"></i> reporte PDF</button>
                        </div>
                    </div>                          
                </form>            
                </div>                
            </div>            
        </div>
    </div>
</div>	
<script>
  function  verPeriodo(opcion){
    var ver = false;
    if(opcion == 9){
      ver = true;
    }else{
      ver = false;
    }

    if (ver) {
      $("#periodo").prop('disabled', false);
    }else{
      $("#periodo").prop('disabled', true);
    }
  }
</script>
  