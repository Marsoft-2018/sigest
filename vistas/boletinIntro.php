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
?>

<div style="width: 100%;">
    <div class="row">
      <div class="col-lg-12 col-lg-12">
        <div class="x_panel">
          <div class="x_title seccion-cabecera">
              <h3>MODULO PARA REPORTE DE BOLETINES</h3>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form method="post" action="" target="_blank" id="tipoBoletin" onsubmit="return tipoBol()">  
              <div class="clearfix"></div>

              <div class="row">
                <div class="col-lg-7 col-sm-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h4>Datos de la consulta</h4>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content box-profile">
                      <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-12">
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
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <label for="">CURSO</label>
                            <div id='cursos' style='margin:0px; padding: 0px;'>
                              <select id='curso' name='curso' class='form-control' style='margin:0px; padding: 0px;' required>
                                <option value=''>Seleccione...</option>    

                                <option value='todos'>Todos</option>                              
                              </select>
                            </div>
                        </div> 
                      </div>
                      <div class="row" style="margin-top: 20px; margin-bottom: 20px;">
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
                        <div class="col-md-4">
                          <label>PERIODO</label>
                          <select id='periodo' name='periodo' class='form-control' required >
                            <option value=''>Seleccione...</option>
                              <?php
                                $objP = new Periodo();
                                $listPeriodo = $objP->cargar();
                                foreach ($listPeriodo as $key => $periodo) {
                                    echo "<option value='".$periodo['periodo']."'>".$periodo['periodo']."</option>";
                                }
                              ?>
                              <option value='Todos'>Todos</option>
                          </select> 
                        </div>
                        <div class="col-md-5">
                          <label for="">TIPO DE BOLETIN</label> 
                          <select id='tipoB' name='tipoB' class='form-control' style='margin:0px; padding: 0px;' required onchange="activarPeriodo(this.value)">
                            <option value='Periodos'>Por Periodos</option>
                            <option value='Final'>Final</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 col-sm-6">
                              <button type='button' class='btn btn-success' id='btnConsultarCurso' value='Mostrar' style="margin:0 auto;margin-top:25px;width: 100%;" onclick="cargarListaEstudiantes()">
                                <i class='fa fa-list-alt'></i> Ver Listado
                              </button>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                          <button type="submit" class="btn btn-info btnPrincipal" style="margin-top:25px;" title="Ver reporte de boletines" ><i class="fa fa-eye"></i> Ver Boletines</button>
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
                          <div class="col-md-6" title='Ayuda sobre las Sedes'>
                            <p>
                              <ul>
                                  <li>Seleccione la sede del listado</li>
                                  <li>Elija el Curso a consultar</li>
                                  <li>Indique el año</li>
                              </ul>                           
                            </p>
                          </div>           
                          <div class="col-md-6" title='Ayuda sobre las Sedes'>
                            <p>
                              <ul>
                                  <li>Elija el Periodo</li>
                                  <li>Seleccione el tipo de boletín</li>
                                  <li>Por último presione el botón Ver Boletines</li>
                              </ul>                              
                            </p>
                          </div>
                      </div>
                      <p  style='text-align:left; font-size: 1em;margin-bottom: 20px;'>En caso de necesitar consultar el boletín de uno o varios estudiantes en particular presionar el botón ver listado y seleccionar el o los estudiantes y presionar el botón ver boletines</p> 
                    </div>
                  </div>
                </div>
              </div> 
              <div class="row" style="margin-top: 50px;">
                <div id="listadoEstudiantes"></div>                     
              </div>
            </form> 
          </div>                        
        </div>
      </div>
    </div>
</div>	
  	
