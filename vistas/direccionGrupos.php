<?php  
    session_start();
    require("../Modelo/Conect.php");
    require("../Modelo/sede.php");
    require("../Modelo/anhoLectivo.php");


  $objSede = new Sede();
  $objAnhos = new Anho();
?>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title seccion-cabecera">
                <h3>MODULO PARA ASIGNACIÓN DE LA DIRECCIÓN DE GRUPOS</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-5">
                        <label>SEDE</label>            
                        <select id='sede' name='sede' onchange='' class='form-control' style='margin:0px; padding: 0px;' required>
                            <option value=''>Seleccione...</option>
                            <?php
                              foreach ($objSede->listar() as $sedes) {
                                echo "<option value='".$sedes['CODSEDE']."'>".$sedes['NOMSEDE']."</option>";
                              }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="">Año</label>
                        <select name="anho" id="anho" class="form-control">
                            <?php
                                foreach ($objAnhos->listar() as $anho) {
                                  echo "<option value='".$anho['Alectivo']."'>".$anho['Alectivo']."</option>"; 
                                }                     
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-success" onclick="cargarMatriz()" style="margin-top: 20px; padding:10px 35px;">
                            <i class="fa fa-eye"></i> Mostrar
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row" id='matrizCarga'>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div id="resultado"></div> 
<script type="text/javascript" src="js/direccionGrupos.js"></script>