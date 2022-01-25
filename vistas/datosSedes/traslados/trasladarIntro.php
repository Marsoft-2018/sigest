<?php
    session_start();
    require("../../../Modelo/Conect.php");
    require("../../../Modelo/sede.php");
    require("../../../Modelo/curso.php");
    require("../../../Modelo/periodos.php");
    require("../../../Modelo/anhoLectivo.php");

    $obj = new Sede();
    $objAnhos = new Anho();
    $institucionID = $_SESSION['institucion'];
?>

<div style="width: 100%;">
    <div class="row">
      <div class="col-lg-12 col-lg-12">
        <div class="x_panel">
          <div class="x_title seccion-cabecera">
              <h3>MODULO PARA TRASLADO DE ESTUDIANTES ENTRE SEDES</h3>
              <div class="clearfix"></div>
          </div>
          <div class="x_content" id="trasladoResultado">
            <form method="post" id="formTraslados" onsubmit="return trasladar()">
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
                        <h4>Seleccione los datos de origen</h4>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                          <label for="">SEDE ACTUAL</label>
                            <select id='sede' name='sedeActual' onchange='cargarCursos(this.value);verificarSedeOrigen(); limpiarListado()' class='form-control' style='margin:0px; padding: 0px;' required>
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
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <label for="">CURSO ACTUAL</label>
                            <div id='cursos' style='margin:0px; padding: 0px;'>
                              <select id='curso' name='cursoActual' class='form-control' style='margin:0px; padding: 0px;' required onchange="limpiarListado()">
                                <option value=''>Seleccione...</option>    

                                <option value='todos'>Todos</option>                              
                              </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                          <label for="">AÑO</label>                             
                            <select name="anho" id="anho" class="form-control">
                              <?php
                              foreach ($objAnhos->listar() as $anho) {
                                echo "<option value='".$anho['Alectivo']."'>".$anho['Alectivo']."</option>";
                               }                                         
                              ?>
                          </select>                            
                        </div>
                        <div class="col-lg-3 col-md-3">                          
                            <button type='button' class='btn btn-success' id='btnConsultarCurso' value='Mostrar' style="margin:0 auto;margin-top:25px;width: 100%;" onclick="cargarListaEstudiantes()">
                              <i class='fa fa-list-alt'></i> Ver Estudiantes
                            </button>                            
                        </div>   
                      </div>
                      <div class="row" style="margin-top: 10px; height: 500px; overflow-y: auto;">
                        <div id="listadoEstudiantes"></div>                     
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
                          Este módulo le permitirá realizar traslados de estudiantes entre las sedes de la institución teniendo en cuentra que el proceso trasladará también las calificaciones que el estudiante tenga asignadas en el año lectivo, este proceso puede tardar varios minutos.<br><br>
                          Para realizar el cambio es necesario seguir los pasos descritos a continuación.
                        </p>
                          <div class="col-md-6" title='Ayuda sobre traslados'>
                            <p>
                              <ul>
                                <li>Seleccione la sede actual en la que se encuentra el estudiante</li>
                                <li>Seleccione El Curso </li>
                                <li>Indique el año </li>
                                <li>Haga click en ver estudiantes</li>
                              </ul>                           
                            </p>
                          </div>           
                          <div class="col-md-6" title='Ayuda sobre las Sedes'>
                            <p>
                              <ul>
                                <li>Seleccione el estudiante a trasladar</li>
                                <li>Seleccione la sede de destino</li>
                                <li>Seleccione el curso de destino</li>
                                <li>Presione el botón Continuar</li>
                              </ul>                              
                            </p>
                          </div>
                      </div>
                    </div>
                  </div> 
                  <div class="x_panel">
                    <div class="x_title">                   
                      <h4 style="text-align: center; ">Seleccione los Datos de destino</h4>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content box-profile">
                      <div class="row">
                        <div class="col-lg-8 col-md-12 col-sm-12">
                          <label for="">SEDE DESTINO</label>
                            <select id='sede' name='sedeDestino' onchange='cargarCursosDestino(this.value); verificarSedeOrigen()' class='form-control sedeDestino' style='margin:0px; padding: 0px;' required>
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
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label for="">CURSO DESTINO</label>
                            <div id='cursos' style='margin:0px; padding: 0px;'>
                              <select id='cursoDestino' name='cursoDestino' class='form-control' style='margin:0px; padding: 0px;' required onchange="verificarCurso(this.value)">
                                <option value=''>Seleccione...</option>    

                                <option value='todos'>Todos</option>                              
                              </select>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 col-sm-6">
                        </div>
                        <div class="col-lg-6 col-sm-6">
                          <button type="submit" 
                          class="btn btn-info btnPrincipal" 
                          style="margin-top:25px;" 
                          title="Continiar con el proceso de traslado de estudiantes" id="btnContinuar">
                            <i class="fa fa-eye"></i> Continuar
                          </button>
                        </div> 
                      </div>
                    </div>
                  </div>
                </div>
              </div> 
            </form> 
          </div>
          <div class="row" id="resultado"></div>                        
        </div>
      </div>
    </div>
</div>
  
<!--------- CÓDIGO ANTERIOR -------------------->
<script type='text/javascript' src="js/traslados.js"></script>  
<script type='text/javascript' src="js/boletines.js"></script>  

  