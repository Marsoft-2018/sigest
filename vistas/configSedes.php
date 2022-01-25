<?php
     session_start();
     require('../Modelo/Conect.php');
     require("../Modelo/sede.php");     
     $nombreSede = "";
     $grado = "";
     $objSedeConfig = new Sede();
     $objSedeConfig->CODSEDE = $_POST['sede'];
 
 
     foreach ($objSedeConfig->cargar() as $key => $sd) {
       $nombreSede = $sd['NOMSEDE'];
     }
      
     $anho = date("Y");
 ?>

<div style='width: 100%;'>    
    <div class="row">
        <div class="col-lg-12">
            <div class="bs-example">
                <div class="panel panel-primary" id='configSede'>
                  <div class='panel-heading' style='height: 50px;padding: 5px;'>
                    <h2 style='float:left;margin:0px;'>Organización y planificación para la Sede <?php echo ucwords(strtolower($nombreSede))." - ".$_POST['sede']; ?></h2>
                    <button type='button' id='btnCancelarAjuste' onclick='menu("EditarSedes.php")' class='btn btn-danger' style='margin-left: 2px;float:right;'><i class='fa fa-times-circle'></i></button>
                    <button type='button' id='recargar' class='btn btn-warning' style='float:right;'><i class='fa fa-refresh'></i></button>
                  </div>
                  <div class='panel-body'>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#nivelGrados" data-toggle="tab">Niveles/Grados</a></li>
                            <li><a href="#areasAsignaturas" data-toggle="tab">Areas/Asignaturas</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="nivelGrados" style='padding:5px;'>
                              <?php include("datosSedes/organizacionCursos.php") ?>  
                            </div>
                            <div class="tab-pane fade" id="areasAsignaturas" style='padding:5px;'>
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="bs-example">
                                    <div class="panel panel-primary">
                                    <!--  -->
                                      <div class='panel-body' id='listadoAreasAsigSede'> 
                                        <?php  require("datosSedes/pensum.php"); ?>
                                      </div>    
                                    </div>
                                  </div>
                                </div>
                              </div>       
                            </div>                                         
                            </div>
                        </div>                      
                  </div>                                                
                  <div class='panel-foot'></div>             
                </div>
                <span id="resultadoAct"></span>            
                <div id="PRUEBAS" ></div>
                <div><input type='hidden' id='sedeBol' value='<?php echo $codSede; ?>'></div>
            </div>
        </div>
    </div>
    
</div>



