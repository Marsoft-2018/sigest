<?php
    session_start();
    require("../../../Modelo/Conect.php");
    require("../../../Modelo/anhoLectivo.php");
    require("../../../Modelo/periodos.php");
    require("../../../Modelo/curso.php"); 
    require("../../../Modelo/desempenhos.php");

    $institucionID = $_SESSION['institucion'];
    $usuario = $_SESSION['idUsuario'];
    $tipoDeUsuario = $_SESSION['rol'];                            
    $objAnho = new Anho();
    
    

?>

<!-- Codigo Nuevo -->
<div style="width: 100%;">
    <br>    
    <div class="row">
        <div class="col-md-12">            
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2>Módulo de reporte de desempeños por Periodo</h2>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form action="" onsubmit="return cargarReporteDesempeño()">
                            <div class="col-md-2">
                                <label for="">CURSO</label>
                                <select id='curso' name='cursoBol' class='form-control'
                                    style='margin:0px; padding: 0px;' required >
                                    <option value=''>Seleccione...</option>
                                    <?php
                                        /*
                                        $objCurso = new Curso();  
                                        $objCurso->tipoUsuario = $tipoDeUsuario;
                                        $objCurso->idUsuario = $usuario;
                                        $datos = $objCurso->listar();

                                        foreach ($datos as $value) {
                                            ?>
                                            <option value="<?php echo $value['codCurso']; ?>">
                                                <?php echo $value['nombreCurso']; ?>
                                            </option>
                                            <?php
                                        }
                                        */
                                    ?>
                                    <?php
                                        $objCurso = new Curso();  
                                        $objCurso->tipoUsuario = $tipoDeUsuario;
                                        $objCurso->idUsuario = $usuario;
                                        $objCurso->anho = $objAnho->Cargar();
                                        $datos = $objCurso->listar();
    
                                        foreach ($datos as $value) {
                                            ?>
                                            <option value="<?php echo $value['codCurso']; ?>">
                                                <?php echo $value['nombreCurso']; ?>
                                            </option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-1 p-0">
                              <label for="">PERIODO</label>
                              <select id='periodo' name='periodo' class='form-control' style='margin:0px; padding: 0px;' required>
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
                            <div class="col-md-2 p-0">
                                <label for="">AÑO</label>
                                <select class='form-control' id='anho' name='anho'required>
                                <?php
                                    $objAnho->inst = $institucionID;
                                    $anhos = $objAnho->Listar();
                                    echo "";
                                    foreach ($anhos as $key => $value) {
                                        echo "<option value='".$value['Alectivo']."'>".$value['Alectivo']."</option>";
                                    }
                                ?>                                
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type='submit' class='btn btn-success' id='btnPlanilla' title='Ver Planilla' style="margin:0 auto;margin-top:20px;" >
                                    <i class="fa fa-list-alt"> Ver Reporte</i>
                                </button>
                            </div>
                        </form>
                    </div>                          
                    <div id='mensajes' style='padding:0px; margin:0px;'></div>
                    <div id="pruebas"></div>
                    <div class="row">
                        <div class="col-md-12" id='marcoReporte' style="margin: 0px;">

                        </div>
                    </div>                      
                </div>
                <div class="panel-footer"></div>                    
            </div>            
        </div>
    </div>
    <input type="hidden" id='institucion' value="<?php echo $institucionID; ?>">
</div>	


<script src="complementos/DataTables/datatables.js"></script>