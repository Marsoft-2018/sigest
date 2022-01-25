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

<div style="width: 100%;">
    <div class="row">
      <div class="col-lg-12 col-lg-12">
        <div class="x_panel">
          <div class="x_title seccion-cabecera">
              <h3>MODULO DE PROMOCION DE ESTUDIANTES POR SEDES</h3>
              <div class="clearfix"></div>
          </div>
          <div class="x_content" id="trasladoResultado">
              <div class="clearfix"></div>
              <div class="row">
                <div class="col-lg-7 col-sm-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h4>Datos para el proceso</h4>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content box-profile">
                      <div class="row">
                        <div class="col-md-3">
                          <button class="btn btn-warning" style="padding: 10px; margin-top: 10px;" onclick="cerrarAnho()">
                            <i class="fa fa-calendar-o"> Cerrar Año lectivo actual</i>
                          </button>
                        </div>
                        <div class="col-md-9">
                          <span id="resultadoAnho">
                            <div class="alert alert-default">
                              <h4>El año lectivo actual es el: <?php echo $objAnhos->cargar();  ?></h4>
                            </div>
                          </span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                          <label for="">SEDE</label>
                            <select id='sede' name='sede' onchange='cargarCursos(this.value); limpiarMatriz()' class='form-control' style='margin:0px; padding: 0px;' required>
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
                        <div class="col-lg-2 col-md-2">
                          <label for="">AÑO A PROMOVER</label>                             
                            <select name="anho" id="anho" class="form-control">
                              <?php
                              foreach ($objAnhos->listar() as $anho) {
                                echo "<option value='".$anho['Alectivo']."'>".$anho['Alectivo']."</option>";
                               }                                         
                              ?>
                          </select>                            
                        </div>
                        <div class='col-md-3'>
                            <label for="">Acción del Proceso</label>
                           <select id='accion' name='accion' onchange='' class='form-control' style='margin:0px; padding: 0px;' required>
                               <option value='0'>Seleccione...</option>
                               <option value='Automatico'>Automático</option>
                               <option value='Manual'>Manual</option>
                           </select>
                        </div>
                        <div class='col-md-3'>
                          <button type='button' class='btn btn-success' value='' onclick='continuar()' style="padding: 10px 20px;margin-top: 20px;">
                            <i class="fa fa-mortar-board"> </i> Continuar 
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>                         
                </div>
                <div class="col-lg-5 col-sm-12">
                  <div class="clearfix"></div>
                  <div class="x_panel">
                    <div class="x_title">                   
                      <h4 style="text-align: center; "><i class="fa fa-info-circle"></i>ndicaciones</h4>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content box-profile" style='background-color: #3abbbd; color: #fff;'>
                      <div class="row">
                        <p  style='text-align:center; font-size: 1em; padding: 10px;'>
                          Este módulo le permitirá realizar la promoción de estudiantes de un grado a otro de acuerdo al resultado que el mismo tenga en el año lectivo, este proceso puede tardar varios minutos.<br><br>
                          Para realizar el proceso es necesario realizar primero el cierre del año lectivo, este proceso coniste en preparar el sistema para las matriculas del siguiente año, se debe realizar una única vez por año y luego seguir los pasos descritos a continuación.
                        </p>
                          <div class="col-md-5" title='Ayuda sobre traslados'>
                            <p>
                              <ul>
                                <li>Seleccione la sede</li>
                                <li>Indique el año </li>
                              </ul>                           
                            </p>
                          </div>           
                          <div class="col-md-7" title='Ayuda sobre las Sedes'>
                            <p>
                              <ul>
                                <li>Seleccione la forma de para realizar el proceso</li>
                                <li>Presione el botón Continuar</li>
                              </ul>                              
                            </p>
                          </div>
                      </div>
                    </div>
                  </div> 
                </div>
              </div> 
              <div class="row" style="margin-top:5px;">
                <div class="col-lg-12 col-lg-12">
                  <div class="x_panel">
                    <div class="x_title seccion-cabecera">
                        <h3>MATRIZ PARA LA PROMOCION ACADÉMICA</h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" id="matrizCarga" style='overflow:auto;'>
                    </div>
                  </div>
                </div>
              </div>
          </div>                      
        </div>
      </div>
    </div>
</div>
<script src="complementos/DataTables/datatables.js"></script>

