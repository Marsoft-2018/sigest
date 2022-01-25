<?php
session_start();
require("../Modelo/Conect.php");
require("../Modelo/sede.php");
require("../Modelo/curso.php");
require("../Modelo/periodos.php");
require("../Modelo/anhoLectivo.php");

$obj = new Sede();
$objAnhos = new Anho();
    $institucionID = $_SESSION['institucion'];
    $escudo;
    
?>

<!-- Codigo Nuevo -->
<div style="width: 100%;">
    <div class="row">
        <div class="col-md-12">
                <div class="panel panel-info ">
                    <div class="panel-heading"><h3>REPORTE CONSOLIDADO PARA NOTAS</h3></div>
                    <div class="panel-body">
                      <div class="col-md-7">
                        <form method="post" action="vistas/reportes/Consolidado/consolidadoGen.php" target="_blank">
                          <div class="clearfix"></div>
                          <div class="x_panel">
                            <div class="x_title">
                              <h4>Datos de la consulta</h4>
                              <div class="clearfix"></div>
                            </div>
                            <div class="x_content box-profile">
                              <div class="row">
                                <div class="col-md-6">                                
                                  <label for="">SEDE</label>
                                  <select id='sede' name='sede' onchange='cargarCursos(this.value)'class='form-control' required>
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
                                <div class="col-md-6">
                                    <label for="">CURSO</label>
                                    <select id='curso' name='curso' class='form-control' required>
                                      <option value='Todos'>Todos</option>
                                    </select>
                                </div>
                              </div>
                              <div class="row"  style="margin-top: 20px; margin-bottom: 20px;">
                                <div class="col-md-3">
                                   <label for="">PERIODO</label>
                                   <select id='periodo' name='periodo' class='form-control' required onchange="mostrarTipo(this.value)">
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
                                <div class="col-md-3">
                                  <label for="">AÑO</label>
                                  <select name="anho" id="anho" class="form-control">
                                      <?php
                                      foreach ($objAnhos->listar() as $anho) {
                                        echo "<option value='".$anho['Alectivo']."'>".$anho['Alectivo']."</option>";
                                       }                                         
                                      ?>
                                  </select>
                                </div>
                                <div class="col-md-6"> 
                                  <label for="">TIPO DE DATOS:</label>  
                                  <select id='tipoDatos' name='tipoDatos' class='form-control' required>
                                      <option value=''>Seleccione...</option>
                                      <option value='NotasPeriodo'>Notas Periodo Seleccionado</option>
                                      <option value='NotasAnteriores'>Notas con periodos anteriores</option>
                                      <option value='Acumulado'>Acumulado</option>
                                      <option value='Nota Requerida'>Nota mínima Requerida</option>
                                      <option value='Desempeno'>Desempeños</option>
                                      <option value='Definitivo'>Definitivo</option>
                                  </select>            
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                      <input type='submit' class='btn btn-success' id='ConsultarBol' value='Consultar' style="margin:0 auto;margin-top:20px;padding: 10px;">
                                </div>                                
                              </div>
                            </div>
                          </div>                                              
                        </form>
                      </div>
                      <div class="col-md-5">
                        <div class="clearfix"></div>
                        <div class="x_panel">
                          <div class="x_title">
                            <h4>Indicaciones</h4>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content box-profile"  style='background-color: #3abbbd; color: #fff;'>
                            <div title='Ayuda sobre las Sedes' style='padding: 10px;'>
                                <p>
                                    <ol>
                                        <li>- Seleccione la sede del listado</li>
                                        <li>- Seleccione El Curso a Consultar del listado</li>
                                        <li>- Elija el Periodo</li>
                                        <li>- Indique el año</li>
                                        <li>- Indique el tipo de datos que desea ver en el reporte</li>
                                        <li>- Presione el botón Consultar</li>
                                    </ol>                                
                                </p>
                                <span id='resultado'></span>
                            </div> 
                          </div>
                        </div>  
                      </div>
                    </div>
                    <div class="panel-footer">
                        
                    </div> 
                </div>            
        </div>
    </div>
</div>	
	
<!--------- CÓDIGO ANTERIOR -------------------->
  <script type='text/javascript'>
  	
    function cargarCursosBol(sede){
        var accion='cargarCombo';
        var profe='Todos';
        $("#cursosBol").load("Consultas/modelos/vistaCursos.php",{sede:sede,Profe:profe,accion:accion},function(){
            //alertify.success("La sede es: "+sede);
        });
    }
    function mostrarTipo(tipo){
        
        if(tipo=='Todos'){
            $("#tipConsolidado").fadeIn();
        }else{
            $("#tipConsolidado").fadeOut();
        }
    }
  </script>	

  