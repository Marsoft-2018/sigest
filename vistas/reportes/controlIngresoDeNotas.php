<?php
session_start();
require("../../Modelo/Conect.php");
require("../../Modelo/sede.php");
require("../../Modelo/curso.php");
require("../../Modelo/periodos.php");
require("../../Modelo/anhoLectivo.php");

$obj = new Sede();
$objAnhos = new Anho();
    $institucionID = $_SESSION['institucion'];
    $escudo;
    
?>

<div class='panel panel-default'>
    <div class='panel-heading'>
        <h3>REPORTE PARA CONTROL DE INGRESO DE NOTAS EN LA PLATAFORMA</h3>                
    </div>
    <div class='panel-body' id=''>
        <form action="" method="POST" onsubmit="return cargarRegistroNotas()">  
            <div class="row">
                <div class="col-md-5">                                
                  <label for="">SEDE</label>
                  <select id='sede' name='sede' class='form-control' required>
                      <option value=''>Seleccione...</option>
                      <?php
                        $dataSed = $obj->listar();
                        foreach ($dataSed as $sed) {
                        ?>
                          <option value="<?php  echo $sed['CODSEDE']; ?>">
                            <?php  echo $sed['NOMSEDE']; ?>
                          </option>
                        <?php 
                        }
                      ?>
                  </select>                     
                </div>
                <div class="col-md-2">
                   <label for="">PERIODO</label>
                   <select id='periodo' name='periodo' class='form-control' required >
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
                <div class="col-md-2">
                  <label for="">AÑO</label>
                  <select name="anho" id="anho" class="form-control">
                      <?php
                      foreach ($objAnhos->listar() as $anho) {
                        echo "<option value='".$anho['Alectivo']."'>".$anho['Alectivo']."</option>";
                       }                                         
                      ?>
                  </select>
                </div>                  
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success" onclick="" style="margin-top: 20px; padding:10px 35px;">
                        <i class="fa fa-eye"></i> Mostrar
                    </button>
                </div>
            </div>    <!--                  
            <div class="col-md-3">
                <button type="button" class="btn btn-warning" onclick="cargarRnotas()" style="margin-top: 20px; padding:10px 35px;">
                    <i class="fa fa-eye"></i> Mostrar Anterior
                </button>
            </div>    -->    
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12" id='matrizCarga'>
        
    </div>
</div>
