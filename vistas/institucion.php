<?php 
    session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/Institucion.php");
    require("../Modelo/anhoLectivo.php");
    require("../Modelo/nivel.php");
    require("../Modelo/grado.php");
    require("../Modelo/periodos.php");
    require("../Modelo/desempenhos.php");
    require("../Modelo/criterios.php");
    require("../Modelo/tipoPlanilla.php");
    $objCentro = new Institucion();
    $objCentro->id = $_SESSION['institucion'];
    $datos = $objCentro->cargar();
    foreach ($datos as $key => $value) {
        $nombre = $value['nombre'];
        $dane   = $value['dane'];
        $nit    = $value['nit'];
        $direccion  = $value['direccion'];
        $telefono   = $value['telefono'];
        $rector = $value['rector'];
        $logo   = $value['logo'];
        $icfes  = $value['icfes'];
        $resolucion = $value['resolucion'];
        $correo = $value['correo'];
        $ciudad = $value['ciudad'];
        $membrete   = $value['membrete'];
    }

    $modeloBoletin = "";
    $objAnho = new Anho();
    $objAnho->inst = $objCentro->id;
    $anhoAct = $objAnho->cargar();

    $modeloBoletin = "";
    $objModelo = new Anho();
    $objModelo->inst = $objCentro->id;
    $objModelo->anho = $anhoAct;
    $modelo = "";
    $areasReprobar = 0;
    foreach ($objModelo->modeloInforme() as $campo) {
        $modelo = $campo['modeloBoletin'];
        $areasReprobar = $campo['areasReprobadas'];
    } 

    $tipoPlanilla = "";
    $tipo_logros = "";
    $cantidad_notas = 0;
    $tipoPromedio = 0;
    $objPlanilla = new tipoPlanilla();
    $objPlanilla->anho = $anhoAct;
    foreach ($objPlanilla->cargar() as $value) {
        $tipoPlanilla = $value['tipo'];
        $cantidad_notas = $value['cantidad_notas'];
        $tipoPromedio = $value['tipo_promedio'];
        $tipo_logros = $value['tipo_logro'];
    }
?>	
	<div id='ContenedorV' style="margin:0 auto; width: 97%;">
        <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title  seccion-cabecera">
            <h3>DATOS DE LA INSTITUCIÓN</h3>
            <div class="clearfix"></div>
          </div>
          <div class="x_content box-profile">            
            <div class="col-md-4 col-sm-4  profile_left">
              <div class="profile_img">
                <div id="crop-avatar">
                  <!-- Current avatar -->
                  <img src="vistas/img/<?php echo $logo; ?>" id='fotoUs' style='margin:0px;height:220px;width:180px;'>
                </div>
              </div>
              <h3><?php echo $nombre ?></h3>
              <ul class="list-unstyled user_data">
                <li><i class="fa">Dane: </i> <?php echo $dane;?>
                </li>
                <li><i class="fa fa-map-marker user-profile-icon">Nit: </i> <?php echo $nit;?>
                </li>
                <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $direccion." - ".$ciudad;?>
                </li>

                <li>
                  <i class="fa fa-briefcase user-profile-icon"> Rector: </i> <?php echo $rector; ?>
                </li>

                <li class="m-top-xs">
                  <i class="fa fa-external-link user-profile-icon"></i>
                  <a href="http://www.kimlabs.com/profile/" target="_blank"><?php echo $correo; ?></a>
                </li>
              </ul>
              <!-- <button type="button" onclick="actualizarPerfil(2)" class="btn btn-warning">
                <i class="fa fa-save m-left-xs"></i> Modificar
              </button>
              <button class="btn btn-danger" onclick="eliminarPerfil()" >
                <i class="fa fa-trash m-right-xs"></i> Eliminar
              </button> -->
              <br />
            </div>
            <div class="col-md-8">
                <div class="profile_title panel-info">
                    <div class="col-md-12">
                      <h3><i class="fa fa-gears"> </i> AJUSTAR PARAMETROS</h3>
                    </div>
                </div>
                <div class="x_content"  style="width: 100%;">
                    <div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#cudAnho" data-toggle="tab">Año Lectivo</a></li>
                            <li><a href="#cudNiveles" data-toggle="tab">Niveles</a></li>
                            <li><a href="#cudGrados" data-toggle="tab">Grados</a></li>
                            <li><a href="#cudPeriodo" data-toggle="tab">Periodos</a></li>
                            <li><a href="#cudDesempeno" data-toggle="tab">Desempeños</a></li>
                            <li><a href="#cudCriterios" data-toggle="tab">Criterios</a></li>
                            <li><a href="#modelosInformes" data-toggle="tab">Modelo de Informe Académico</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="cudAnho">                               
                                <div class="row" style="padding-top: 10px; ">
                                    <div class='col-md-12' > 
                                        <h3>Historial de años almacenados en plataforma</h3>
                                        
                                    </div><!-- 
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="anhoAct" name="anhoAct" value="<?php echo $anhoAct; ?>"> 
                                        <button type='button' id='btnCancelarAjuste' onclick="guardarAnno()" class='btn btn-primary' style='margin-top:20px;'>
                                           <i class='fa fa-save'></i> Guardar
                                        </button>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class='table table-striped' >
                                            <thead><tr><th>No.</th><th>Año</th><th></th></tr></thead>
                                            <tbody>
                                            <?php 
                                                $con=1;
                                                foreach ($objAnho->listar() as $key => $val) {?>
                                                    <tr>
                                                        <td><?php echo $con ?></td>
                                                        <td><?php echo $val['Alectivo'] ?></td>
                                                        <td>
                                                            <?php 
                                                                if ($con == 1) {
                                                                    echo "<label ><i class='fa fa-arrow-right'> </i> Año lectivo actual</label>";
                                                                }          
                                                            ?>                
                                                        </td>
                                                    </tr>
                                                <?php 
                                                   $con++;
                                                }
                                             ?>
                                            </tbody>
                                        </table>                           
                                        <span id='resulAnno'></span>
                                    </div>
                                </div>                        
                            </div>
                            <div class="tab-pane fade" id="cudNiveles">
                                <h4>Niveles educativos manejados en la institución</h4>
                                <div id='NivelesMarco'>
                                    <?php 
                                        require("ajustes/niveles/listado.php");
                                    ?>
                                </div>                                
                            </div>
                            <div class="tab-pane fade" id="cudGrados">
                                <h4>Listado de grados de la institución</h4>
                                <div id='gradosMarco'>
                                    <?php 
                                        require("ajustes/grados/listado.php");
                                    ?>
                                </div>                                
                            </div>
                            <div class="tab-pane fade" id="cudPeriodo">
                                <h3>Nuevo Periodo</h3>                                    
                                <form action="" method="post" id="formPeriodos" onsubmit="return agregarPeriodo()">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2">
                                            <label for="">Periodo</label> 
                                            <input type="number" value='' placeholder="Nuevo Periodo" id='newPer' class="form-control" required>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <label for="">Porcentaje</label> 
                                            <input type="number" value='' placeholder="Porcentaje Periodo" id='newPor' class="form-control" required>
                                        </div>
                                        <div class="col-md-3 col-sm-3"> 
                                            <label for="">Fecha de Inicio</label>  
                                            <input type="date" value='' id='fecInicio' class="form-control" required>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="">Fecha de cierre</label>  
                                            <input type="date" value='' id='fecCierre'  class="form-control" required>
                                        </div>
                                        <div class="col-md-2 col-sm-2 mt-2">
                                            <button type='submit' id='btnAgregarPeriodo' class='btn btn-primary' style='margin-top:20px;' ><i class='fa fa-plus-circle'></i> Agregar
                                            </button>
                                        </div>
                                    </div>
                                </form>  
                                <div class="row ">
                                   <div class='cols-md-12' id='periodosRes'>
                                        <?php 
                                            require("ajustes/periodos.php");
                                        ?>                    
                                   </div>
                                </div>   
                            </div>
                            <div class="tab-pane fade" id="cudDesempeno">
                                <h4>Escala valorativa para desempeños</h4>
                                <div id='desempenhosMarco'>
                                    <?php 
                                        require("ajustes/desempenos.php");
                                    ?>
                                </div>                                
                            </div>
                            <div class="tab-pane fade" id="cudCriterios">
                                <h4>Críterios de evaluación</h4>
                                <div id='criteriosMarco'>
                                    <?php include("ajustes/criterios.php") ?>
                                </div>
                            </div> 
                            <div class="tab-pane fade" id="modelosInformes">            
                                <div class="row mt-3"  style="padding-top: 25px;">
                                    <div class="col-lg-4 col-md-5 col-sd-12 ">
                                        <label>Modelos para Informes Académicos</label>
                                        <select name="" id="modelo" class="form form-control" onchange="verModelo(this.value)">
                                            <option value="">Seleccione...</option>
                                            <option value="M1" <?php if($modelo == "M1"){ echo "selected"; } ?>>Modelo 1</option>
                                            <option value="M2" <?php if($modelo == "M2"){ echo "selected"; } ?>>Modelo 2</option>
                                        </select>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-5 col-sd-7 ">
                                        <label>Número de áreas para reprobar</label>
                                        <input type="Number" name="numAreas" id="numAreas" value="<?php echo $areasReprobar; ?>" class="form form-control">                     
                                    </div>
                                    <div class="col-lg-4 col-md-2 col-sd-5 " style="padding-top: 25px;">
                                        <button type="button" class="btn btn-info" onclick="guardarModeloInforme()"><i class="fa fa-check"></i> Utilizar Modelo seleccionado</button>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <?php  
                                                                              
                                        $modeloBoletin = "vistas/boletines/Modelos_previews/".$modelo.".pdf";
                                    ?>
                                    <div class="col-md-12 col-sd-12 " id="previews">
                                        <object width="100%" height="600" data="<?php echo $modeloBoletin; ?>" style="margin-top: 20px;"></object>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>                
                        
                    <div class='ui-widget' style='display:none;width:450px;margin:0px auto; float:none;' id='mresultados'>
                        <div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;' id='resultados'></div>
                    </div> 
                </div>                      
                <div id='divResultados'></div>
            </div>
        </div>
    </div>

    <script>
        function verModelo(model){
            if(model == 'M1'){
                $("#previews").html('<object width="100%" height="600" data="vistas/boletines/Modelos_previews/M1.pdf" style="margin-top: 20px;"></object>');
            }else if(model == 'M2'){
                $("#previews").html('<object width="100%" height="600" data="vistas/boletines/Modelos_previews/M2.pdf" style="margin-top: 20px;"></object>');
            }
        }
    </script>
