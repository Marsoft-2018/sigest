<?php
  session_start();  
  require('../../Modelo/Conect.php');
  require("../../Modelo/sede.php");
  require("../../Modelo/anhoLectivo.php");
  require("../../Modelo/profesores.php");

  $objSede = new Sede();
  $objAnhos = new Anho();	
  $periodo = $_POST['periodo'];
?>  
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title seccion-cabecera">
          <h3>MODULO PARA REGISTRAR LA ENTREGA DE BOLETINES EN EL PERIODO <?php echo $periodo ?></h3>
          <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">          
          <form method="post" action="" onsubmit="return listarCursosEntrega()">
            <div class="col-md-4">
            	<input type="hidden" id="periodo" value="<?php echo $periodo ?>"> 
              <label for="">SEDE</label>
                <select id='sede' name='sede' class='form-control' style='margin:0px; padding: 0px;' required>
                  <option value=''>Seleccione...</option>
              <?php
                foreach ($objSede->listar() as $sedes) {
                  echo "<option value='".$sedes['CODSEDE']."'>".$sedes['NOMSEDE']."</option>";
                }
              ?>
              </select>
            </div>
            <div class="col-md-2">
              <label for="">Año</label>
              <select name="anho" id="anho" class="form-control">
                  <?php
                  foreach ($objAnhos->listar() as $anho) {
                    echo "<option value='".$anho['Alectivo']."'>".$anho['Alectivo']."</option>"; # code...
                   }                       
                  ?>
              </select>
            </div>  
            <div class="col-md-3">
                  <button type='submit' class='btn btn-success' id='ConsultarCurso' value='Mostrar' style="margin:0 auto;margin-top:25px;width: 100%;"><i class='fa fa-list'></i> Ver cursos</button>
            </div>                    
          </form>
        </div>  
        <div class="row" style="margin-top: 50px;">
          <div class="col-md-12" id='listados' >
          </div>                      
        </div> 
      </div>                        
    </div>
  </div>
</div>
