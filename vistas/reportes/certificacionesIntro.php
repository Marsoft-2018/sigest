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
?>	
 <!-- ****************************************************************** --> 	
<div style="width: 100%;">
    <div class="row">
      <div class="col-lg-12 col-lg-12">
        <div class="x_panel">
          <div class="x_title seccion-cabecera">
              <h3>MODULO PARA REPORTE DE CONSTANCIAS Y CERTIFICACIONES</h3>
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
                        <div class="col-lg-5 col-md-5 col-sm-12">
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
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <label for="">CURSO</label>
                            <div id='cursos' style='margin:0px; padding: 0px;'>
                              <select id='curso' name='curso' class='form-control' style='margin:0px; padding: 0px;' required>
                                <option value=''>Seleccione...</option>    

                                <option value='todos'>Todos</option>                              
                              </select>
                            </div>
                        </div> 
                        <div class="col-lg-2 col-md-2">
                          <label for="">A??O</label>                             
                            <select name="anho" id="anho" class="form-control">
                              <?php
                              foreach ($objAnhos->listar() as $anho) {
                                echo "<option value='".$anho['Alectivo']."'>".$anho['Alectivo']."</option>";
                               }                                         
                              ?>
                          </select>                            
                        </div> 
                        <div class="col-md-3">
                          <label for="">TIPO</label> 
                          <select id='tipoB' name='tipoB' class='form-control' style='margin:0px; padding: 0px;' required >
                            <option value=''>Seleccione...</option>
                            <option value='Certificado'>Certificado de notas</option>
                            <option value='Constancia'>Constancias de estudios</option>
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
                          <button type="submit" class="btn btn-info btnPrincipal" style="margin-top:25px;" title="Ver certificado" ><i class="fa fa-eye"></i> Consultar</button>
                        </div> 
                      </div> 
                    </div>
                  </div>                         
                </div>
                <div class="col-lg-5 col-sm-12">
                  <div class="clearfix"></div>
                  <div class="x_panel">
                    <div class="x_title">                   
                      <h4><i class="fa fa-info-circle"></i>ndicaciones</h4>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content box-profile" style='background-color: #3abbbd; color: #fff;'>
                      <div class="row">
                          <div class="col-md-6" title='Ayuda sobre las Sedes'>
                              <ul>
                                  <li>Seleccione la sede del listado</li>
                                  <li>Elija el Curso a consultar</li>
                                  <li>Indique el a??o</li>
                              </ul>
                          </div>
                          <div class="col-md-6" title='Ayuda sobre las Sedes'>
                              <ul>
                                  <li>Seleccione el tipo de certificado</li>
                                  <li>Por ??ltimo presione el bot??n consultar</li>
                              </ul>
                          </div>
                      </div>
                      <p  style='text-align:left; font-size: 1em;margin-bottom: 20px;'>En caso de necesitar consultar uno o varios estudiantes en particular presionar el bot??n ver listado y seleccionar el o los estudiantes y presionar el bot??n consultar</p> 
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
    
