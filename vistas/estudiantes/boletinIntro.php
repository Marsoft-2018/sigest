
<style>
      .notasEstudiantes{
        margin-top: 5px;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-start;
        align-items: center;
        align-content: stretch;
      }

      .anho{
        width: 20%;
        height: 100%;
        background-color: #06caF3; 
        color: #fff;
        font-size: 2em;
        text-align: center;
      }

      .areas{
        width: 80%;
        border: 1px solid blue;
      }
    
</style>

<div>

 <?php
    session_start();
    require("../../Modelo/Conect.php");
    require("../../Modelo/Institucion.php");
    require("../../Modelo/sede.php");
    require("../../Modelo/curso.php");
    require("../../Modelo/periodos.php");
    require("../../Modelo/matricula.php");
    require("../../Modelo/anhoLectivo.php");
    require("../../Modelo/areas.php");
    require("../../Modelo/Estudiante.php");
    require("../../Modelo/entregaDeInformesPeriodo.php");
 
    $curso;
    $sede;
    $idMatricula;

    $objInstitucion = new Institucion();
    $objAnho = new Anho();
    $anho = $objAnho->Cargar();

    $objMatriculas = new Matricula();
    $objMatriculas->Documento = $_SESSION['idUsuario'];
    $objMatriculas->anho = $anho;
    foreach ($objMatriculas->cargarXdocumento() as $value) {
        $curso = $value['Curso'];
        $sede = $value['codsede'];
        $idMatricula = $value['idMatricula'];
    }
?> 


</div>
<div class="container">
    <br>    
    <div class="row">
        <div class="col-md-12">            
            <div class="x_panel">
                <div class="x_title seccion-cabecera">
                    <h3>CONSULTAR BOLETINES POR PERIODO</h3>
                    <div class="clearfix"></div>
                      <div class="x_content" style="margin-top: 15px;">  
                          <div class="clearfix"></div>

                          <div class="row">
                            <div class="col-lg-7 col-sm-12">
                              <div class="x_panel">
                                <div class="x_title">
                                  <h4>Datos de la consulta</h4>
                                  <div class="clearfix"></div>
                                </div>
                                <div class="x_content box-profile">  
                                  <div class="row" style="margin-top: 20px; margin-bottom: 20px;">
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
                                      </select> 
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                      <button type="submit" class="btn btn-info btnPrincipal" style="margin-top:25px;" title="Ver reporte de boletines" onclick='cargarBoletinEstudiante("<?php echo $sede ?>","<?php echo $curso ?>","<?php echo $anho ?>","<?php echo $idMatricula ?>")'><i class="fa fa-eye"></i> Ver Boletín</button>
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
                                      <div class="col-md-12" title='Ayuda sobre las Sedes'>                                        
                                        <p>
                                          <ul>
                                              <li>Elija el Periodo</li>
                                              <li>Presione el botón Ver Boletín</li>
                                          </ul>                              
                                        </p>
                                      </div>
                                  </div>
                                  <p  style='text-align:left; font-size: 1em;margin-bottom: 20px;'>La vista del boletín esta supeditada a la autorización del administrador de la plataforma</p> 
                                </div>
                              </div>
                            </div>
                          </div> 
                      </div> 
                </div>
                <div class="x_content" id = "view_boletin">
                                                
                </div>                
            </div>            
        </div>
    </div>
</div> 
    
