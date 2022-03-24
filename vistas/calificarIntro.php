<?php
	//require("../CONECT.php");
    session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/anhoLectivo.php");
    require("../Modelo/periodos.php");
    require("../Modelo/curso.php"); 
    require("../Modelo/desempenhos.php");

    $institucionID = $_SESSION['institucion'];
    $usuario = $_SESSION['idUsuario'];
    $tipoDeUsuario = $_SESSION['rol'];
    $objAnho = new Anho();

?>
<style>
	#tiempo{
	    display: none;
		border: 1px solid #ff2840;
		width: 250px;
		border-radius: 10px;
		background-color: rgba(180, 0, 0, 0.5);
		padding: 20px;
		font-family: "arial";
		text-align: center;
		color: #fff;
		position: fixed;
		top: calc(100% - 130px);
		right:  20px;
	}
</style>

<div style="width: 100%;">
    <div class="row">
      <div class="col-lg-12 col-lg-12">
        <div class="x_panel">
          <div class="x_title seccion-cabecera">
              <h3>Módulo de calificaciones por Periodo</h3>
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
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <label for="">CURSO</label>
                            <select id='curso' name='cursoBol' class='form-control' 
                                style='margin:0px; padding: 0px;' required 
                                onchange ="limpiarAreaDeTrabajo(); cargarTodasLasAreas(); activarObservacionesBoletin(this.value)">
                                <option value=''>Seleccione...</option>
                                <?php
                                    $objCurso = new Curso();  
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
                        <div class="col-md-6">
                            <label>AREA/ASIGNATURA</label>
                            <select name="" id="areas" class="form form-control" onchange="limpiarAreaDeTrabajo();">
                                <option value="">Seleccione..</option>
                                <optgroup label="Áreas">
                                  
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">PERIODO</label>
                            <select id='periodo' name='periodo' class='form-control' style='margin:0px; padding: 0px;' required onchange='ValidarPeriodo(); limpiarAreaDeTrabajo()'>
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
                        <div class="col-lg-2 col-md-2">
                            <label for="">AÑO</label>
                            <?php                            
                                $objAnho = new Anho();
                                $objAnho->inst = $institucionID;
                                $anhos = $objAnho->Listar();
                                echo "<select class='form-control' id='anho' name='anho' onchange='ValidarPeriodo(); limpiarAreaDeTrabajo(); cargarTodasLasAreas()'>";
                                foreach ($anhos as $key => $value) {
                                    echo "<option value='".$value['Alectivo']."'>".$value['Alectivo']."</option>";
                                }
                                echo "</select>";
                            ?>                            
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 col-sm-6">
                              <button type='button' class='btn btn-success' id='btnPlanilla' title='Ver Planilla de calificaciones' style="padding: 10px; margin-top:20px; width: 100%" onclick="cargarLista(1)">
                                    <i class="fa fa-list-alt"> Ver Planilla</i>
                                </button>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <button type='button' class='btn btn-info' id='btnObservacion' title='Ver Planilla de observaciones' style="display: none; padding: 10px; margin-top:20px; width: 100%" onclick="cargarObservacionesBoletin()">
                                    <i class="fa fa-list-alt"> Observaciones</i>
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
                       <div id='mensajes' style='padding:1px; margin:0px;'></div> 
                    </div>
                  </div>
                </div>
              </div> 
              <div id='tiempo'>
                  <div id="ad_session"></div>
                  <div id="reloj"><span id="min"></span><span id="seg"></span></div>   
              </div> 
              <div class="row" style="margin-top:5px;">
                <div id='tablaPlanilla' style="margin: 0 auto;" class="container"> </div>                                          
              </div>
            </form> 
          </div>                        
        </div>
      </div>
    </div>
</div>  
	
<script>
    var oPanel = $("#tiempo");
	var IDLE_TIMEOUT = 1600; //seconds
	var min = 5;
	var seg = 60;
	var _idleSecondsCounter = 0;
	document.onclick = function() {
	    oPanel.fadeOut();
	  _idleSecondsCounter = 0;
	};
	document.onmousemove = function() {
	    oPanel.fadeOut();
	  _idleSecondsCounter = 0;
	};
	document.onkeypress = function() {
	    oPanel.fadeOut();
	  _idleSecondsCounter = 0;
	  console.log("Presionó una tecla");
	};

	var myInterval = window.setInterval(CheckIdleTime, 600000);

	function CheckIdleTime() {
	   var oPanel = $("#tiempo");
	  _idleSecondsCounter++;
	  if (oPanel)
	  	if(_idleSecondsCounter >= 20){
	  	    oPanel.fadeIn();
	  	    
	  	    $("#ad_session").html("La sesión ha estado inactiva por 10 min:<br> ");
	  	    $("#reloj").html("Por este motivo se cerrará en : "+(IDLE_TIMEOUT - _idleSecondsCounter) + " segundos");
	  	}		    
	  if (_idleSecondsCounter >= IDLE_TIMEOUT) {
	    //alertify.error("El tiempo de espera a expirado!");
	    window.clearInterval(myInterval);
	    oPanel.fadeIn();
	    oPanel.html("Tiempo de inactividad superado, ingrese nuevamente para evitar inconvenientes con el guardado de las calificaciones");
	  }
	}
</script><!---->
<script src="complementos/DataTables/datatables.js"></script>

  