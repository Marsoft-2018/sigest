<?php
    $anho = date("Y");
    if (isset($_POST['sede'])) {
        require("../Modelo/areas.php");  
        require("../Modelo/anhoLectivo.php");
        $visible = "display:none;";   
    }else{
        session_start();
        require("../../Modelo/Conect.php");
        require("../../Modelo/sede.php");
        require("../../Modelo/nivel.php");
        require("../../Modelo/grado.php");        
        require("../../Modelo/areas.php"); 
        require("../../Modelo/anhoLectivo.php"); 
        $visible = "display:block;";
        $objSede = new Sede();
    }        

    $cont=1; 
    $cantGrados = 0;
    $objGrad = new Grado();
    $objArea = new Area();
    $objAnhos = new Anho();
    $objArea->codSede = $objSede->CODSEDE;
    $objArea->anho = $anho;

?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title seccion-cabecera">
                <h3>MODULO PARA LA ORGANIZACION DE LAS AREAS Y/O ASIGNATURAS</h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row" style="<?php echo $visible ?>">
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
                    <div class='col-md-1'>
                        <label>AÑO</label>
                        <select name="anho" id="anho" class="form-control">
                            <?php
                            foreach ($objAnhos->listar() as $anho) {
                              echo "<option value='".$anho['Alectivo']."'>".$anho['Alectivo']."</option>";
                             }                                         
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-success" onclick="cargarPensumSede()" style="margin-top: 20px; padding:10px 35px;">
                            <i class="fa fa-eye"></i> Mostrar
                        </button>
                    </div>
                </div>  
                <div class="row">
                    <div class='col-md-12' id='datosIH'>
                        <?php 
                            if (isset($_POST['sede'])) {
                                include("areasIH.php");
                            }
                        ?>                                              
                    </div>                       
                </div> 
            </div>                              
        </div>
    </div>
</div>   
