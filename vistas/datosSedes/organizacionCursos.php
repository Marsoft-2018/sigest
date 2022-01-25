<?php
	if (isset($_POST['sede'])) {
		require("../Modelo/nivel.php");
		require("../Modelo/grado.php");
		require("../Modelo/curso.php");
		require("../Modelo/jornada.php");
		$objSede = new Sede();
		$objSede->CODSEDE = $_POST['sede'];
		foreach ($objSede->cargar() as $key => $sd) {
		  $nombreSede = $sd['NOMSEDE'];
		} 
		$visible = "display:none;";   
	}else{
		session_start();
		require("../../Modelo/Conect.php");
		require("../../Modelo/sede.php");
		require("../../Modelo/nivel.php");
		require("../../Modelo/grado.php");
		require("../../Modelo/curso.php");
		require("../../Modelo/jornada.php");
		$visible = "display:block;";
		$objSede = new Sede();
	}
        $objGrad = new grados();
    	$objJornada = new Jornada();

	$anho = date("Y");
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title seccion-cabecera">
                <h3>MODULO PARA LA ORGANIZACION DE LOS DIREFENTES NIVELES Y GRADOS</h3>
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
                    <div class="col-md-3">
                        <button type="button" class="btn btn-success" onclick="listarCursosSede()" style="margin-top: 20px; padding:10px 35px;">
                            <i class="fa fa-eye"></i> Mostrar
                        </button>
                    </div>
                </div>  
			    <div class="row">
			        <div class='col-md-12' id='listaGradosAsoc'>
			            <?php 
			                $objGrad = new grados();
			                $objGrad->sede = $objSede->CODSEDE;
			                if (isset($_POST['sede'])) {
			                    include("listaCursos.php");
			                }
			            ?>                                              
			        </div>                       
			    </div> 
			</div>           			        
        </div>
    </div>
</div>