<?php
    session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/anhoLectivo.php");
    require("../Modelo/curso.php");
    require("../Modelo/periodos.php");
    require("../Modelo/areas.php");
    require("../Modelo/logros.php");
    $institucionID = $_SESSION['institucion'];
    $usuario = $_SESSION['idUsuario'];
    $tipoDeUsuario = $_SESSION['rol'];
    $objAnho = new Anho();
?>


<div style="width: 100%;">
    <div class="row">
      <div class="col-lg-12 col-lg-12">
        <div class="x_panel">
          <div class="x_title seccion-cabecera">
              <h3>MóDULO DE INDICADORES POR PERIODO</h3>
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
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="">CURSO</label>
                            <select id='curso' name='cursoBol' class='form-control' 
                                style='margin:0px; padding: 0px;' required 
                                onchange ="limpiarAreaLogros(); cargarTodasLasAreas()">
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
                                            <?php 
                                              if($value['CODGRADO'] > 0){
                                                echo $value['nombreCurso'];
                                              }else{
                                                echo $value['nombreGrado'];
                                              }
                                            ?>
                                        </option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>  
                        <div class="col-md-4">
                            <label>AREA/ASIGNATURA</label>
                            <select name="" id="areas" class="form form-control" onchange="limpiarAreaLogros();">
                                <option value="">Seleccione..</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">PERIODO</label>
                            <select id='periodo' name='periodo' class='form-control' style='margin:0px; padding: 0px;' required onchange='limpiarAreaLogros();'>
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
                        <div class="col-lg-3 col-md-3">
                            <label for="">AÑO</label>
                            <?php                            
                                $objAnho = new Anho();
                                $objAnho->inst = $institucionID;
                                $anhos = $objAnho->Listar();
                                echo "<select class='form-control' id='anho' name='anho' onchange='limpiarAreaDeTrabajo(); cargarTodasLasAreas()'>";
                                foreach ($anhos as $key => $value) {
                                    echo "<option value='".$value['Alectivo']."'>".$value['Alectivo']."</option>";
                                }
                                echo "</select>";
                            ?>                            
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <button type='button' class='btn btn-success' id='btnPlanilla' title='Ver Planilla de calificaciones' style="padding: 10px; margin-top:20px; width: 100%" onclick="cargarFormLogros()">
                                    <i class="fa fa-list-alt"> Ver Logros</i>
                            </button>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <?php 
                                if ($tipoDeUsuario == "Administrador") { ?>
                                    <button type='button' class='btn btn-info' id='btnPlanilla' title='Ver Planilla deobservaciones' style="padding: 10px; margin-top:20px; width: 100%" onclick="cargarResumenLogros()">
                                            <i class="fa fa-list-alt"> Resumen</i>
                                    </button>         
                            <?php } ?>
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
                                  <li>Seleccione el Curso a consultar</li>
                                  <li>Seleccione el área/asignatura</li>
                                  <li>Elija el Periodo</li>
                                  <li>Indique el año</li>                                  
                              </ul>                           
                            </p>
                          </div>           
                          <div class="col-md-6" title='Ayuda sobre las Sedes'>
                            <p>
                              <ul>
                                  <li>Presione el botón Ver planilla para ver la planilla de calificaciones</li>
                                  <li>Presione el botón Ver observaciones para ver la planilla de observaciones</li>
                              </ul>                              
                            </p>
                          </div>
                      </div>
                        <div class="alert alert-warning animated slow fadeInRight">Señor maestro, recuerde que los logros se ingresan en forma infinitiva.</div>
                        <div id='mensajes' style='padding:0px; margin:0px;'></div> 
                    </div>
                  </div>
                </div>
              </div> 
              <div class="row" style="margin-top: 10px;">
                    <div class="col-md-12 jumbotron" id='formularioLogros'> </div>                     
              </div>
            </form> 
          </div>                        
        </div>
      </div>
    </div>
    <div id="resultadoLog"></div>
</div> 


  