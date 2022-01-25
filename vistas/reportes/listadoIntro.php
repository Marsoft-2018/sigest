<?php
    
  session_start();  
  require('../../Modelo/Conect.php');
  require("../../Modelo/sede.php");
  require("../../Modelo/anhoLectivo.php");
  require("../../Modelo/periodos.php");
  $obj = new Sede();
  $objAnhos = new Anho();
?>  

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title seccion-cabecera">
          <h3>MODULO PARA PLANILLAS O LISTADOS DE ESTUDIANTES</h3>
          <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form method="post" action="vistas/reportes/enPdf/reporte.php" target="_blank" id="formPlanilla">
          <div class="row">            
            <div class="col-lg-6 col-md-6">
              <label for="">SEDE</label>
                <select id='sede' name='sede' onchange='cargarCursos(this.value)'class='form-control' style='margin:0px; padding: 0px;' required>
                  <option value=''>Seleccione...</option>
                  <?php
                    $dataSed = $obj->listar();
                    foreach ($dataSed as $key => $value) {
                    ?>
                      <option value="<?php  echo $value['CODSEDE']; ?>">
                        <?php  echo $value['NOMSEDE']; ?>
                      </option>
                    <?php 
                    }
                  ?>
              </select>
            </div>                            
            <div class="col-lg-3 col-md-3">
                <label for="">CURSO</label>
                <div id='cursos' style='margin:0px; padding: 0px;'>
                  <select id='curso' name='curso' class='form-control' style='margin:0px; padding: 0px;' required>
                    <option value=''>Seleccione...</option>    

                    <option value='todos'>Todos</option>                              
                  </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
              <label for="">AÑO</label>                             
                <select name="anho" id="anho" class="form-control">
                  <?php
                  foreach ($objAnhos->listar() as $anho) {
                    echo "<option value='".$anho['Alectivo']."'>".$anho['Alectivo']."</option>";
                   }                                         
                  ?>
              </select>                            
            </div>
          </div>              
          <div class="row">
            <div class="col-lg-3 col-md-3">
              <label for="">TIPO DE LISTADO</label>                             
              <select name="tipoReporte" id="tipoReporte" class="form-control" required onchange="verPeriodo(this.value)">
                <option value=''>Seleccione...</option>  
                <option value='5'>Asistencia</option>  
                <option value='1'>Coordinación</option>
                <option value='8'>Lista con Firma</option>  
                <option value='2'>Pagaduría</option> 
                <option value='6'>Planilla Impresa</option>  
                <option value='7'>Planilla con Calificaciones</option>  
                <option value='3'>Rectoría</option>
                <option value='4'>Secretaría</option>
              </select>                            
            </div> 
            <div id="encabezados" style="display: none;">
              <div class="col-lg-3 col-md-3">
                <label for="">TIPO DE ENCABEZADO</label>                             
                <select name="encabezado" id="encabezado" class="form-control" >                   
                  <option value=''>Seleccione...</option>  
                  <option value='1'>Membrete</option>  
                  <option value='2'>Sencillo</option>
                  <option value='3'>Sin Encabezado</option>
                </select>                            
              </div> 
              <div class="col-lg-3 col-md-3">
                <label for="">UBICACION DEL ENCABEZADO</label>                             
                <select name="ubicacionEncabezado" id="ubicacionEncabezado" class="form-control">                   
                  <option value=''>Seleccione...</option>  
                  <option value='1'>Izquierda</option>  
                  <option value='2'>Centro</option>
                  <option value='3'>Derecha</option>
                </select>                            
              </div>
            </div>
            <div class="col-lg-3 col-sm-3" id="periodo_view" style="display: none;">
               <label for="">PERIODO</label> 
                <select id='periodo' name='periodo' class='form-control' style='margin:0px; padding: 0px;' required>
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
        <div class="row" style="margin-top: 50px;">
          <div class="col-md-12" id='planillaResultado'>
            
          </div>                     
        </div> 
      </div>                        
    </div>
  </div>
</div>
<script>
  function  verPeriodo(opcion){
    var ver = false;
    if(opcion == 7){
      ver = true;
    }else{
      ver = false;
    }

    if (ver) {
      $("#periodo_view").fadeIn("fast");
      $("#encabezados").fadeOut("fast");
    }else{
      $("#periodo_view").fadeOut("fast");
      $("#encabezados").fadeIn("fast");
    }
  }
</script>